<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class WebsiteSettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings', [
            'settings' => WebsiteSetting::allAsArray(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'logo' => ['nullable', 'image', 'max:2048'],
            'email' => ['nullable', 'email', 'max:180'],
            'whatsapp' => ['nullable', 'string', 'max:80'],
            'address' => ['nullable', 'string', 'max:500'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('cms', 'public');
        }

        foreach ($data as $key => $value) {
            WebsiteSetting::setValue($key, $value);
        }

        return back()->with('status', 'Pengaturan website berhasil diperbarui.');
    }
}
