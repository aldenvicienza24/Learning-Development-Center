<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationStatusMail;
use App\Models\Program;
use App\Models\Registration;
use App\Services\ProgramSeatService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function __construct(private ProgramSeatService $seats) {}

    public function index(Request $request)
    {
        $this->seats->releaseExpired();

        $participantStatus = $request->input('participant_status', $request->input('status'));
        $hasActiveFilters = $request->filled('program_id')
            || filled($participantStatus)
            || $request->filled('payment_status')
            || $request->filled('date_from')
            || $request->filled('date_to')
            || $request->boolean('missing_receipt');

        $programSearch = $request->input('program_search');
        $programCategory = $request->input('category');
        $programStatus = $request->input('program_status');

        $programs = Program::query()
            ->withCount('registrations')
            ->when(filled($programSearch), fn ($query) => $query->where('title', 'like', '%'.$programSearch.'%'))
            ->when(filled($programCategory), fn ($query) => $query->where('category', $programCategory))
            ->when(filled($programStatus), fn ($query) => $query->where('status', $programStatus))
            ->orderBy('title')
            ->paginate(4, ['*'], 'program_page')
            ->withQueryString();

        $programOptions = Program::query()
            ->orderBy('title')
            ->get(['id', 'title']);

        $programCategories = Program::query()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $selectedProgram = $request->filled('program_id')
            ? Program::query()->withCount('registrations')->find((int) $request->program_id)
            : null;

        $statusCounts = collect([
            'menunggu_pembayaran' => 0,
            'menunggu_verifikasi' => 0,
            'diproses' => 0,
            'diterima' => 0,
            'ditolak' => 0,
        ]);

        if ($selectedProgram) {
            $statusCounts = $statusCounts->merge(
                Registration::query()
                    ->where('program_id', $selectedProgram->id)
                    ->selectRaw("COALESCE(NULLIF(participant_status, ''), status, 'menunggu_verifikasi') as status_key, COUNT(*) as total")
                    ->groupBy('status_key')
                    ->pluck('total', 'status_key')
            );
        }

        $registrations = $hasActiveFilters
            ? $this->filteredQuery($request)->latest()->paginate(8)->withQueryString()
            : new LengthAwarePaginator([], 0, 8, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

        return view('admin.registrations.index', [
            'registrations' => $registrations,
            'programs' => $programs,
            'programOptions' => $programOptions,
            'programCategories' => $programCategories,
            'selectedProgram' => $selectedProgram,
            'statusCounts' => $statusCounts,
            'participantStatus' => $participantStatus,
            'hasActiveFilters' => $hasActiveFilters,
        ]);
    }

    public function show(Registration $registration)
    {
        $registration->load(['program', 'partnerDiscount']);

        return view('admin.registrations.show', compact('registration'));
    }

    public function edit(Registration $registration)
    {
        $registration->load(['program', 'partnerDiscount']);

        return view('admin.registrations.edit', compact('registration'));
    }

    public function update(Request $request, Registration $registration)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:180'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['required', 'string', 'max:40'],
            'institution' => ['required', 'string', 'max:180'],
            'participant_status' => ['required', 'in:menunggu_pembayaran,menunggu_verifikasi,diproses,diterima,ditolak'],
            'payment_status' => ['required', 'in:menunggu_pembayaran,menunggu_verifikasi,disetujui,ditolak'],
            'payment_proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'payment_amount' => ['exclude_unless:payment_status,disetujui', 'nullable', 'integer', 'min:0', 'max:999999999999'],
            'payment_received_at' => ['exclude_unless:payment_status,disetujui', 'nullable', 'date_format:Y-m-d', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
        ]);

        if ($request->hasFile('payment_proof')) {
            $data['payment_proof'] = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        $data['status'] = $data['participant_status'];

        $updated = DB::transaction(function () use ($registration, $data): bool {
            $lockedRegistration = Registration::query()
                ->whereKey($registration->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $newStatus = $data['participant_status'];

            if (! $this->seats->syncForStatus($lockedRegistration, $newStatus)) {
                return false;
            }

            $lockedRegistration->update($data);
            $registration->setRelation('program', $lockedRegistration->program);

            return true;
        });

        if (! $updated) {
            return back()
                ->withInput()
                ->with('status', 'Status peserta tidak bisa diubah karena kuota program sudah penuh.');
        }

        $this->sendStatusEmailIfNeeded($registration, $registration->status, $data['participant_status']);

        return redirect()
            ->route('admin.programs.show', $registration->program)
            ->with('status', 'Data peserta berhasil diperbarui.');
    }

    public function approve(Request $request, Registration $registration)
    {
        $receipt = $request->validate([
            'payment_amount' => ['nullable', 'integer', 'min:0', 'max:999999999999'],
            'payment_received_at' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
        ]);
        $updated = $this->updateRegistrationStatus($registration, [
            ...$receipt,
            'participant_status' => 'diterima',
            'payment_status' => 'disetujui',
            'status' => 'diterima',
        ]);

        if (! $updated) {
            return back()->with('status', 'Peserta tidak bisa disetujui karena kuota program sudah penuh.');
        }

        $this->sendStatusEmailIfNeeded($registration, $registration->status, 'diterima');

        return back()->with('status', 'Peserta berhasil disetujui.');
    }

    public function reject(Registration $registration)
    {
        $this->updateRegistrationStatus($registration, [
            'participant_status' => 'ditolak',
            'payment_status' => 'ditolak',
            'status' => 'ditolak',
        ]);

        $this->sendStatusEmailIfNeeded($registration, $registration->status, 'ditolak');

        return back()->with('status', 'Peserta berhasil ditolak.');
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        $registrations = $this->filteredQuery($request)->latest()->get();

        return response()->streamDownload(function () use ($registrations): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Email', 'Nomor HP', 'Instansi', 'Program', 'Status Peserta', 'Status Pembayaran', 'Diskon Mitra', 'Tarif Tagihan', 'Nominal Diterima', 'Tanggal Daftar']);

            foreach ($registrations as $registration) {
                $discountText = $registration->discount_percentage > 0
                    ? ($registration->partnerDiscount?->institution_name ?? 'Mitra') . " ({$registration->discount_percentage}%)"
                    : '-';
                $billAmount = $registration->final_price ?? $registration->program?->price ?? 0;

                fputcsv($handle, [
                    $registration->full_name,
                    $registration->email,
                    $registration->phone,
                    $registration->institution,
                    $registration->program?->title,
                    $registration->participant_status ?: $registration->status,
                    $registration->payment_status,
                    $discountText,
                    $billAmount,
                    $registration->payment_amount ?? '-',
                    $registration->created_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        }, 'peserta.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportPdf(Request $request)
    {
        return view('admin.registrations.export-pdf', [
            'registrations' => $this->filteredQuery($request)->latest()->get(),
        ]);
    }

    private function filteredQuery(Request $request)
    {
        $participantStatus = $request->input('participant_status', $request->input('status'));
        $participantSearch = trim((string) $request->input('participant_search', $request->input('search', '')));

        return Registration::query()
            ->with(['program', 'partnerDiscount'])
            ->when($request->boolean('missing_receipt'), fn ($query) => $query->where(fn ($q) => $q->whereNull('payment_amount')->orWhereNull('payment_received_at')))
            ->when($request->boolean('missing_receipt') && $request->filled('category'), fn ($query) => $query->whereHas('program', fn ($q) => $q->where('category', $request->category)))
            ->when($request->filled('program_id'), fn ($query) => $query->where('program_id', $request->program_id))
            ->when($participantSearch !== '', function ($query) use ($participantSearch) {
                $query->where(function ($query) use ($participantSearch) {
                    $query->where('full_name', 'like', '%'.$participantSearch.'%')
                        ->orWhere('email', 'like', '%'.$participantSearch.'%')
                        ->orWhere('phone', 'like', '%'.$participantSearch.'%')
                        ->orWhere('institution', 'like', '%'.$participantSearch.'%')
                        ->orWhere('participant_status', 'like', '%'.$participantSearch.'%')
                        ->orWhere('payment_status', 'like', '%'.$participantSearch.'%')
                        ->orWhere('status', 'like', '%'.$participantSearch.'%');
                });
            })
            ->when(filled($participantStatus), function ($query) use ($participantStatus) {
                $query->where(function ($query) use ($participantStatus) {
                    $query->where('participant_status', $participantStatus)
                        ->orWhere(function ($query) use ($participantStatus) {
                            $query->where('status', $participantStatus)
                                ->where(function ($query) {
                                    $query->whereNull('participant_status')
                                        ->orWhere('participant_status', '');
                                });
                        });
                });
            })
            ->when($request->filled('payment_status'), fn ($query) => $query->where('payment_status', $request->payment_status))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('created_at', '<=', $request->date_to));
    }

    private function updateRegistrationStatus(Registration $registration, array $data): bool
    {
        return DB::transaction(function () use ($registration, $data): bool {
            $lockedRegistration = Registration::query()
                ->whereKey($registration->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $newStatus = $data['participant_status'];

            if (! $this->seats->syncForStatus($lockedRegistration, $newStatus)) {
                return false;
            }

            $lockedRegistration->update($data);

            return true;
        });
    }

    private function sendStatusEmailIfNeeded(Registration $registration, string $oldStatus, string $newStatus): void
    {
        if ($oldStatus === $newStatus) {
            return;
        }

        if (in_array($newStatus, ['diterima', 'ditolak'], true)) {
            $mail = new RegistrationStatusMail($registration, $newStatus);
            
            // Only send if template is not empty
            if ($mail->hasContent()) {
                try {
                    Mail::to($registration->email)->send($mail);
                } catch (\Throwable $exception) {
                    report($exception);
                }
            }
        }
    }

}
