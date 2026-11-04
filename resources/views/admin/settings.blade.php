@extends('admin.layout', ['title' => 'Pengaturan Situs Web', 'subtitle' => 'Kelola statistik publik, logo, kontak, alamat, dan media sosial.'])

@section('help_title', 'Panduan Pengaturan Situs Web')
@section('help_content')
<p>Halaman ini digunakan untuk mengatur elemen global yang muncul di seluruh situs web, seperti header dan footer.</p>
<ul class="list-disc pl-4 mt-2 space-y-1">
    <li><b>Logo:</b> Pastikan format gambar yang diunggah memiliki kualitas yang baik (disarankan format PNG dengan latar transparan).</li>
    <li><b>Statistik Publik:</b> Isi jumlah trainer atau pemateri berdasarkan data yang sudah terverifikasi.</li>
    <li><b>Kontak dan Alamat:</b> Informasi ini akan tampil di bagian bawah (footer) situs web.</li>
    <li><b>Media Sosial:</b> Masukkan tautan lengkap akun media sosial (misalnya <code>https://instagram.com/akun</code>). Kosongkan jika tidak ada.</li>
</ul>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="cms-panel max-w-4xl p-5">
        @csrf
        @method('PUT')

        <div class="grid gap-5 md:grid-cols-2">
            <label class="block md:col-span-1">
                <span class="cms-label">Logo</span>
                <input type="file" name="logo" accept="image/*" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
            </label>
            <label class="block md:col-span-1">
                <span class="cms-label">Berkas Panduan Admin (PDF)</span>
                <input type="file" name="admin_help_pdf" accept="application/pdf" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                @if(!empty($settings['admin_help_pdf_path']))
                    <p class="mt-2 text-xs text-slate-500">
                        <a href="{{ asset('storage/' . $settings['admin_help_pdf_path']) }}" target="_blank" rel="noopener noreferrer" class="cms-inline-link gap-1 text-[#9CB0CF] hover:underline"><i class="ti ti-download" aria-hidden="true"></i> Lihat Berkas Terunggah</a>
                    </p>
                @endif
            </label>

            <label class="block md:col-span-2">
                <span class="cms-label">Jumlah Trainer/Pemateri</span>
                <input type="number" name="total_trainers" value="{{ old('total_trainers', $settings['total_trainers'] ?? 0) }}" min="0" max="999999" step="1" inputmode="numeric" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                <span class="mt-2 block text-xs leading-relaxed text-slate-500">Angka ini tampil pada bagian Fakta UISI Learning & Development di beranda.</span>
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

            <div class="block md:col-span-2 border-t border-slate-200 mt-4 pt-6">
                <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500 mb-4">Templat Email Otomatis</h3>
                <p class="text-xs text-slate-500 mb-6">Gunakan kode berikut untuk menyisipkan data dinamis pada teks pembuka atau penutup: <code class="bg-[#0E214A] px-1 py-0.5 rounded text-[#F2F6FF]">{nama}</code> (nama peserta), <code class="bg-[#0E214A] px-1 py-0.5 rounded text-[#F2F6FF]">{program}</code> (judul program), dan <code class="bg-[#0E214A] px-1 py-0.5 rounded text-[#F2F6FF]">{institusi}</code> (instansi peserta). Detail peserta dan kode unik akan disisipkan secara otomatis di antara teks pembuka dan penutup. Jika kolom dikosongkan, fitur email ini akan dinonaktifkan.</p>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-4">
                        <h4 class="font-bold text-sm text-[#F2F6FF]">Email Disetujui (Diterima)</h4>
                        <label class="block">
                            <span class="cms-label">Salam Pembuka</span>
                            <textarea name="email_approved_opening" rows="3" placeholder="Halo {nama},&#10;Selamat! Pendaftaran Anda telah disetujui." class="cms-input mt-2 w-full px-3 py-2.5 text-sm">{{ old('email_approved_opening', $settings['email_approved_opening'] ?? '') }}</textarea>
                        </label>
                        <label class="block">
                            <span class="cms-label">Salam Penutup</span>
                            <textarea name="email_approved_closing" rows="3" placeholder="Gunakan kode unik di atas saat acara berlangsung. Terima kasih." class="cms-input mt-2 w-full px-3 py-2.5 text-sm">{{ old('email_approved_closing', $settings['email_approved_closing'] ?? '') }}</textarea>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <h4 class="font-bold text-sm text-[#F2F6FF]">Email Ditolak</h4>
                        <label class="block">
                            <span class="cms-label">Salam Pembuka</span>
                            <textarea name="email_rejected_opening" rows="3" placeholder="Halo {nama},&#10;Mohon maaf, pendaftaran Anda tidak dapat diproses." class="cms-input mt-2 w-full px-3 py-2.5 text-sm">{{ old('email_rejected_opening', $settings['email_rejected_opening'] ?? '') }}</textarea>
                        </label>
                        <label class="block">
                            <span class="cms-label">Salam Penutup</span>
                            <textarea name="email_rejected_closing" rows="3" placeholder="Nantikan program kami selanjutnya." class="cms-input mt-2 w-full px-3 py-2.5 text-sm">{{ old('email_rejected_closing', $settings['email_rejected_closing'] ?? '') }}</textarea>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <button class="cms-btn cms-btn-primary mt-6">
            Simpan Pengaturan
        </button>
    </form>
@endsection
