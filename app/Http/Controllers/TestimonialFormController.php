<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialFormController extends Controller
{
    public function show($token)
    {
        $testimonial = Testimonial::where('token', $token)->firstOrFail();

        if ($testimonial->is_submitted) {
            return view('testimonials.submitted', compact('testimonial')); // Or some generic message
        }

        return view('testimonials.form', compact('testimonial'));
    }

    public function store(Request $request, $token)
    {
        $testimonial = Testimonial::where('token', $token)->firstOrFail();

        if ($testimonial->is_submitted) {
            return redirect()->back()->with('error', 'Testimoni sudah pernah diisi.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'q2' => 'required|string|max:1000',
            'q3' => 'required|string|max:1000',
            'q4' => 'required|string|max:1000',
            'q5' => 'required|string|max:1000',
            'q6' => 'required|string|max:1000',
            'q7' => 'required|string|max:1000',
            'photos' => 'nullable|array|max:3',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            'consent' => 'required|accepted',
        ]);

        $bodyText = "<strong>Yang berkesan:</strong><br>{$validated['q2']}<br><br>"
                  . "<strong>Wawasan yang didapat:</strong><br>{$validated['q3']}<br><br>"
                  . "<strong>Relevansi dengan pekerjaan:</strong><br>{$validated['q4']}<br><br>"
                  . "<strong>Hal yang dapat diterapkan:</strong><br>{$validated['q5']}<br><br>"
                  . "<strong>Pesan untuk calon peserta:</strong><br>{$validated['q6']}<br><br>"
                  . "<strong>Rekomendasi:</strong><br>{$validated['q7']}";

        $uploadedPhotos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('program-documentation', 'public');
                if ($path) $uploadedPhotos[] = $path;
            }
        }

        $testimonial->update([
            'rating' => $validated['rating'],
            'body' => $bodyText,
            'photos' => $uploadedPhotos,
            'author_name' => $testimonial->registration->full_name ?? 'Peserta Program',
            'author_role' => $testimonial->registration->institution ?? null,
            'is_submitted' => true,
            'status' => 'pending', // Awaiting admin approval
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Testimoni Anda telah berhasil dikirim.');
    }
}
