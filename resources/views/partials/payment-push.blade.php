<style>
    #paymentHelpActions { position:fixed;right:18px;bottom:18px;bottom:calc(18px + env(safe-area-inset-bottom));display:flex;align-items:center;gap:10px;z-index:45; }
    #paymentHelpActions .public-tour-floating-trigger { position:static; }
    #paymentPushBell { display:grid;place-items:center;width:48px;height:48px;border:1px solid #29446F;border-radius:14px;background:#0E214A;color: #9CB0CF;cursor:pointer;box-shadow:0 4px 16px #0f172a0d; }
    #paymentPushBell:hover { background:#0E214A;border-color:#29446F; }
    #paymentPushBell.is-active { background:#2563EB;border-color:#2563EB;color:#F2F6FF; }
    #paymentPushBell.is-active:hover { background:#0E214A;border-color:#0E214A; }
    #paymentPushBell:focus-visible { outline:3px solid #9CB0CF;outline-offset:3px; }
    #paymentPushBell:disabled { cursor:wait;opacity:.65; }
</style>
<div id="paymentHelpActions">
    <button id="paymentPushBell" type="button" aria-label="Aktifkan notifikasi HP" title="Aktifkan notifikasi HP" aria-describedby="paymentPushStatus">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
    </button>
</div>
<span id="paymentPushStatus" role="status" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;">Notifikasi HP belum aktif.</span>
<script>
(() => {
    const bell = document.getElementById('paymentPushBell');
    document.addEventListener('DOMContentLoaded', () => {
        const guide = document.querySelector('.public-tour-floating-trigger');
        if (guide) document.getElementById('paymentHelpActions').appendChild(guide);
    });
    const button = bell;
    const status = document.getElementById('paymentPushStatus');
    const activeKey = 'uisi:payment-push-active:{{ $registration->id }}';
    const markActive = () => {
        bell.classList.add('is-active');
        bell.title = 'Notifikasi HP aktif';
        bell.setAttribute('aria-label', 'Notifikasi HP aktif');
        status.textContent = 'Notifikasi HP aktif untuk pembayaran ini.';
    };
    const publicKey = @json(config('webpush.public_key'));
    const subscribeUrl = @json(\Illuminate\Support\Facades\URL::temporarySignedRoute('pendaftaran.push', $expiresAt, ['registration' => $registration->id]));
    const ios = /iPad|iPhone|iPod/.test(navigator.userAgent) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
    const standalone = window.matchMedia('(display-mode: standalone)').matches || navigator.standalone;
    const unavailableReason = ios && !standalone
        ? 'Di iPhone, tambahkan situs ke Layar Utama lalu buka dari ikon UISI untuk mengaktifkan notifikasi.'
        : !window.isSecureContext || !('serviceWorker' in navigator) || !('PushManager' in window) || !('Notification' in window)
            ? 'Notifikasi HP belum tersedia di browser atau alamat ini. Gunakan browser yang mendukung pada alamat HTTPS.'
            : !publicKey ? 'Notifikasi HP belum diaktifkan oleh pengelola.' : null;
    const showProblem = message => {
        status.textContent = message;
        showErrorModal(message);
    };
    (async () => {
        try {
            if (unavailableReason || Notification.permission !== 'granted') return;
            const savedEndpoint = localStorage.getItem(activeKey);
            if (!savedEndpoint) return;
            const worker = await navigator.serviceWorker.getRegistration('/');
            const subscription = await worker?.pushManager.getSubscription();
            if (subscription?.endpoint === savedEndpoint) markActive();
        } catch {}
    })();
    button.addEventListener('click', async () => {
        if (unavailableReason) { showProblem(unavailableReason); return; }
        if (bell.classList.contains('is-active') && Notification.permission === 'granted') return;
        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
        try {
            // Request directly from the tap so iOS preserves the user gesture.
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                bell.classList.remove('is-active');
                bell.title = 'Aktifkan notifikasi HP';
                bell.setAttribute('aria-label', 'Aktifkan notifikasi HP');
                showProblem('Notifikasi belum diizinkan. Ubah izin notifikasi situs di pengaturan browser jika ingin mengaktifkannya.');
                return;
            }
            status.textContent = 'Mengaktifkan pengingat…';
            await navigator.serviceWorker.register('/payment-reminders-sw.js');
            const worker = await navigator.serviceWorker.ready;
            let subscription = await worker.pushManager.getSubscription();
            if (!subscription) {
                const base64 = publicKey.replace(/-/g, '+').replace(/_/g, '/');
                const bytes = Uint8Array.from(atob(base64 + '='.repeat((4 - base64.length % 4) % 4)), c => c.charCodeAt(0));
                subscription = await worker.pushManager.subscribe({ userVisibleOnly: true, applicationServerKey: bytes });
            }
            const response = await fetch(subscribeUrl, {
                method: 'POST', credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify(subscription.toJSON()),
            });
            if (!response.ok) throw new Error(response.status === 410 ? 'Waktu pembayaran sudah berakhir.' : 'Pengingat belum tersimpan. Coba aktifkan kembali.');
            status.textContent = 'Notifikasi HP aktif untuk pembayaran ini. Pastikan perangkat terhubung ke internet dan notifikasi browser diizinkan.';
            markActive();
            bell.focus();
            try { localStorage.setItem(activeKey, subscription.endpoint); } catch {}
        } catch (error) {
            showProblem(error instanceof TypeError ? 'Tidak dapat terhubung. Periksa koneksi lalu coba kembali.' : (error.message || 'Notifikasi gagal diaktifkan. Coba kembali.'));
        } finally {
            button.disabled = false;
            button.removeAttribute('aria-busy');
        }
    });
})();
</script>
