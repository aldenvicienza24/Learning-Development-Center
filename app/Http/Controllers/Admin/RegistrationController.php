<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $participantStatus = $request->input('participant_status', $request->input('status'));
        $hasActiveFilters = $request->filled('program_id')
            || filled($participantStatus)
            || $request->filled('payment_status')
            || $request->filled('date_from')
            || $request->filled('date_to');

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
        $registration->load('program');

        return view('admin.registrations.show', compact('registration'));
    }

    public function edit(Registration $registration)
    {
        $registration->load('program');

        return view('admin.registrations.edit', compact('registration'));
    }

    public function update(Request $request, Registration $registration)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:180'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['required', 'string', 'max:40'],
            'institution' => ['required', 'string', 'max:180'],
            'participant_status' => ['required', 'in:menunggu_verifikasi,diproses,diterima,ditolak'],
            'payment_status' => ['required', 'in:menunggu_verifikasi,disetujui,ditolak'],
            'payment_proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        if ($request->hasFile('payment_proof')) {
            $data['payment_proof'] = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        $data['status'] = $data['participant_status'];

        $registration->update($data);

        return redirect()->route('admin.registrations.index')->with('status', 'Data peserta berhasil diperbarui.');
    }

    public function approve(Registration $registration)
    {
        $registration->update([
            'participant_status' => 'diterima',
            'payment_status' => 'disetujui',
            'status' => 'diterima',
        ]);

        return back()->with('status', 'Peserta berhasil disetujui.');
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        $registrations = $this->filteredQuery($request)->latest()->get();

        return response()->streamDownload(function () use ($registrations): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Email', 'Nomor HP', 'Instansi', 'Program', 'Status Peserta', 'Status Pembayaran', 'Tanggal Daftar']);

            foreach ($registrations as $registration) {
                fputcsv($handle, [
                    $registration->full_name,
                    $registration->email,
                    $registration->phone,
                    $registration->institution,
                    $registration->program?->title,
                    $registration->participant_status ?: $registration->status,
                    $registration->payment_status,
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

        return Registration::query()
            ->with('program')
            ->when($request->filled('program_id'), fn ($query) => $query->where('program_id', $request->program_id))
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
}