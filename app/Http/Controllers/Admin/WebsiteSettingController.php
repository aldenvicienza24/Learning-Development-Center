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
            'admin_help_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'total_trainers' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'email' => ['nullable', 'email', 'max:180'],
            'whatsapp' => ['nullable', 'string', 'max:80'],
            'address' => ['nullable', 'string', 'max:500'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'email_approved_opening' => ['nullable', 'string'],
            'email_approved_closing' => ['nullable', 'string'],
            'email_rejected_opening' => ['nullable', 'string'],
            'email_rejected_closing' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('cms', 'public');
        }

        if ($request->hasFile('admin_help_pdf')) {
            $data['admin_help_pdf_path'] = $request->file('admin_help_pdf')->store('cms', 'public');
            unset($data['admin_help_pdf']);
        }

        foreach ($data as $key => $value) {
            WebsiteSetting::setValue($key, $value);
        }

        return back()->with('status', 'Pengaturan situs web berhasil diperbarui.');
    }
}
