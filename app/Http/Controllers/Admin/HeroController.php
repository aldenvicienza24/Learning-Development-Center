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
            'hero_title' => ['required', 'string', 'max:160'],
            'hero_description' => ['required', 'string', 'max:500'],
            'hero_calendar_link' => ['nullable', 'string', 'max:500'],
            'hero_banner' => ['nullable', 'image', 'max:2048'],
        ]);

        WebsiteSetting::setValue('hero_title', $data['hero_title']);
        WebsiteSetting::setValue('hero_description', $data['hero_description']);
        WebsiteSetting::setValue('hero_calendar_link', $data['hero_calendar_link'] ?: '/kalender-program');

        if ($request->hasFile('hero_banner')) {
            WebsiteSetting::setValue('hero_banner', $request->file('hero_banner')->store('cms', 'public'));
        }

        return back()->with('status', 'Hero berhasil diperbarui.');
    }
}
