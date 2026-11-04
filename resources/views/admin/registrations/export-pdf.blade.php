<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ekspor Data Peserta</title>
    <style>
        body { font-family: Inter, 'DejaVu Sans', sans-serif; color: #111827; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background: #0E214A; }
        @media print { button { display: none; } }
    </style>
</head>
<body>
    <button onclick="window.print()">Cetak / Simpan PDF</button>
    <h1>Data Peserta</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Instansi</th>
                <th>Program</th>
                <th>Status Peserta</th>
                <th>Status Pembayaran</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registrations as $registration)
                <tr>
                    <td>{{ $registration->full_name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>{{ $registration->institution }}</td>
                    <td>{{ $registration->program?->title }}</td>
                    <td>{{ str_replace('_', ' ', ucfirst($registration->participant_status ?: $registration->status)) }}</td>
                    <td>{{ str_replace('_', ' ', ucfirst($registration->payment_status ?? 'menunggu_verifikasi')) }}</td>
                    <td>{{ $registration->created_at?->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.addEventListener('load', () => window.print());
    </script>
</body>
</html>
