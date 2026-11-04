<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'program_id' => ['nullable', 'integer', 'exists:programs,id'],
            'visibility' => ['nullable', 'in:published,draft'],
        ]);
        $testimonials = Testimonial::with('program:id,title,slug')
            ->when($filters['program_id'] ?? null, fn ($query, $id) => $query->where('program_id', $id))
            ->when($filters['visibility'] ?? null, fn ($query, $visibility) => $query->where('is_published', $visibility === 'published'))
            ->latest('id')->paginate(10)->withQueryString();

        return view('admin.testimonials.index', [
            'testimonials' => $testimonials,
            'programs' => Program::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function create()
    {
        return $this->form(new Testimonial(['is_published' => false]));
    }

    public function store(Request $request)
    {
        $this->saveDocumentation($request, new Testimonial);

        return redirect()->route('admin.testimonials.index')->with('status', 'Dokumentasi program berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return $this->form($testimonial);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $this->saveDocumentation($request, $testimonial);

        return redirect()->route('admin.testimonials.index')->with('status', 'Dokumentasi program berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $photos = $testimonial->photos ?? [];
        $testimonial->delete();
        Storage::disk('public')->delete($photos);

        return redirect()->route('admin.testimonials.index')->with('status', 'Dokumentasi program berhasil dihapus.');
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update([
            'status' => 'approved',
            'is_published' => true,
        ]);
        return back()->with('status', 'Ulasan peserta berhasil disetujui dan akan ditampilkan.');
    }

    public function reject(Testimonial $testimonial)
    {
        $testimonial->update([
            'status' => 'rejected',
            'is_published' => false,
        ]);
        return back()->with('status', 'Ulasan peserta ditolak.');
    }

    private function form(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', [
            'testimonial' => $testimonial,
            'programs' => Program::orderBy('title')->get(['id', 'title']),
        ]);
    }

    private function saveDocumentation(Request $request, Testimonial $testimonial): void
    {
        $existing = $testimonial->photos ?? [];
        $data = $request->validate([
            'program_id' => ['required', 'integer', 'exists:programs,id'],
            'body' => ['required', 'string', 'max:1000'],
            'photos' => ['nullable', 'array', 'max:6'],
            'photos.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_photos' => ['nullable', 'array', 'max:6'],
            'remove_photos.*' => ['required', 'string', Rule::in($existing)],
            'comments' => ['nullable', 'array', 'max:8'],
            'comments.*' => ['nullable', 'string', 'max:400'],
            'is_published' => ['sometimes', 'boolean'],
        ], [
            'photos.*.image' => 'Dokumentasi harus berupa gambar JPG, PNG, atau WebP.',
            'photos.*.mimes' => 'Gunakan foto JPG, PNG, atau WebP.',
            'photos.*.max' => 'Ukuran setiap foto maksimal 3 MB.',
            'comments.*.max' => 'Setiap komentar maksimal 400 karakter.',
        ]);
        $removed = $data['remove_photos'] ?? [];
        $remaining = array_values(array_diff($existing, $removed));
        $files = $request->file('photos', []);
        $total = count($remaining) + count($files);
        if ($total > 6) {
            throw ValidationException::withMessages(['photos' => 'Maksimal 6 foto per dokumentasi. Hapus foto lama untuk menambahkan foto baru.']);
        }
        if ($request->boolean('is_published') && $total === 0) {
            throw ValidationException::withMessages(['photos' => 'Tambahkan minimal satu foto sebelum ditampilkan di situs web.']);
        }

        $uploaded = [];
        try {
            foreach ($files as $file) {
                $path = $file->store('program-documentation', 'public');
                if (! $path) {
                    throw ValidationException::withMessages(['photos' => 'Foto belum dapat disimpan. Silakan coba lagi.']);
                }
                $uploaded[] = $path;
            }
            DB::transaction(function () use ($testimonial, $data, $remaining, $uploaded, $request) {
                $testimonial->fill([
                    'program_id' => $data['program_id'], 'body' => $data['body'],
                    'comments' => array_values(array_filter(array_map(fn ($text) => trim($text ?? ''), $data['comments'] ?? []), fn ($text) => $text !== '')),
                    'photos' => array_merge($remaining, $uploaded),
                    'is_published' => $request->boolean('is_published'),
                ])->save();
            });
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($uploaded);
            throw $exception;
        }
        Storage::disk('public')->delete($removed);
    }
}
