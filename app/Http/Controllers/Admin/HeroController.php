<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function edit()
    {
        return view('admin.hero', [
            'settings' => WebsiteSetting::allAsArray(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_banner' => ['nullable', 'image', 'max:4096'],
            'service_training_image' => ['nullable', 'image', 'max:4096'],
            'service_certification_image' => ['nullable', 'image', 'max:4096'],
            'service_language_image' => ['nullable', 'image', 'max:4096'],
        ]);

        foreach (['hero_banner', 'service_training_image', 'service_certification_image', 'service_language_image'] as $imageKey) {
            if ($request->hasFile($imageKey)) {
                WebsiteSetting::setValue($imageKey, $data[$imageKey]->store('cms/homepage', 'public'));
            }
        }

        return back()->with('status', 'Konten beranda berhasil diperbarui.');
    }
}
