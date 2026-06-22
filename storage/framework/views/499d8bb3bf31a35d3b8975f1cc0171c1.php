<script>
    document.addEventListener('DOMContentLoaded', function () {
        const initialQuotas = {
            '1': 22, '2': 25, '3': 22, '4': 22, '5': 35, '6': 15, '7': 15,
            'a': 22, 'b': 25, 'c': 22, 'd': 22, 'e': 35, 'f': 15
        };
        const maxQuotas = {
            '1': 30, '2': 30, '3': 30, '4': 30, '5': 40, '6': 20, '7': 20,
            'a': 30, 'b': 30
        };
        const quotaDataVersion = '2026-06-21-quota-persist-v2';
        let quotas = localStorage.getItem('uisi_quota_version') === quotaDataVersion
            ? JSON.parse(localStorage.getItem('uisi_quotas') || '{}')
            : { ...initialQuotas };
        localStorage.setItem('uisi_quota_version', quotaDataVersion);
        Object.keys(initialQuotas).forEach(function (key) {
            if (quotas[key] === undefined) quotas[key] = initialQuotas[key];
        });
        localStorage.setItem('uisi_quotas', JSON.stringify(quotas));

        document.querySelectorAll('.program-card').forEach(function (card) {
            const id = card.dataset.id;
            const numberSpan = card.querySelector('.kuota-number');

            if (!id || !numberSpan || quotas[id] === undefined) return;

            const q = quotas[id];
            const maxQ = maxQuotas[id] || 30;
            const ratio = q / maxQ;

            numberSpan.innerText = q;

            const badge = numberSpan.closest('.kuota-badge');
            if (!badge) return;

            badge.classList.remove(
                'bg-red-50', 'text-[#C3110C]', 'border-red-100',
                'text-red-700',
                'bg-yellow-50', 'text-yellow-700', 'border-yellow-100',
                'bg-green-50', 'text-green-700', 'border-green-100',
                'bg-slate-50', 'text-slate-700', 'border-slate-100'
            );

            if (q === 0) {
                badge.classList.add('bg-slate-50', 'text-slate-700', 'border-slate-100');
            } else if (ratio <= 0.25) {
                badge.classList.add('bg-red-50', 'text-[#C3110C]', 'border-red-100');
            } else if (ratio <= 0.50) {
                badge.classList.add('bg-yellow-50', 'text-yellow-700', 'border-yellow-100');
            } else {
                badge.classList.add('bg-green-50', 'text-green-700', 'border-green-100');
            }
        });
    });
</script>
<?php /**PATH C:\PROJECT\web-uisi\resources\views/partials/quota-sync.blade.php ENDPATH**/ ?>