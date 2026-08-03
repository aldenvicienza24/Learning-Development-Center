@extends('admin.layout', ['title' => 'Pengaturan Website', 'subtitle' => 'Kelola logo, kontak, alamat, dan sosial media.'])

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="cms-panel max-w-4xl p-5">
        @csrf
        @method('PUT')

        <div class="grid gap-5 md:grid-cols-2">
            <label class="block md:col-span-2">
                <span class="cms-label">Logo</span>
                <input type="file" name="logo" accept="image/*" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
            </label>

            @foreach (['email' => 'Email', 'whatsapp' => 'Nomor WhatsApp', 'instagram' => 'Instagram', 'facebook' => 'Facebook', 'youtube' => 'YouTube', 'linkedin' => 'LinkedIn'] as $key => $label)
                <label class="block">
                    <span class="cms-label">{{ $label }}</span>
                    <input name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                </label>
            @endforeach

            <label class="block md:col-span-2">
                <span class="cms-label">Alamat</span>
                <textarea name="address" rows="4" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">{{ old('address', $settings['address'] ?? '') }}</textarea>
            </label>
        </div>

        <button class="cms-btn cms-btn-primary mt-6">
            Simpan Pengaturan
        </button>
    </form>
@endsection
