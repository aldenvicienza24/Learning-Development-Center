<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengingat Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0E214A;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #0E214A;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .header {
            background-color: #2563EB;
            color: #F2F6FF;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .content p {
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .alert {
            background-color: #0E214A;
            border: 1px solid #9CB0CF;
            color: #F2F6FF;
            padding: 15px;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            background-color: #2563EB;
            color: #F2F6FF;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer {
            background-color: #0E214A;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #9CB0CF;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pengingat Pembayaran</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $registration->full_name }}</strong>,</p>
            
            <p>Terima kasih telah mendaftar di program <strong>{{ $registration->program->title ?? 'Program' }}</strong>. Kami ingin mengingatkan bahwa waktu pembayaran Anda hampir habis.</p>
            
            <div class="alert">
                Sisa waktu pembayaran sekitar {{ $remainingMinutes }} menit atau kurang.
            </div>
            <p>Batas pembayaran: <strong>{{ $deadline->timezone(config('app.timezone'))->format('d/m/Y H:i:s T') }}</strong>. Batas waktu tetap berjalan meskipun halaman ditutup.</p>
            
            <p>Jika Anda tidak menyelesaikan pembayaran sebelum batas waktu berakhir, pendaftaran Anda akan dibatalkan secara otomatis dan kursi akan dikembalikan ke kuota program.</p>
            
            <div class="button-container">
                <a href="{{ $paymentUrl }}" class="button">Selesaikan Pembayaran Sekarang</a>
            </div>
            
            <p>Jika Anda sudah melakukan transfer, pastikan bukti pembayaran juga sudah dikirim melalui halaman pembayaran. Abaikan pengingat ini jika bukti sudah berhasil dikirim.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} UISI Learning & Development Center. Hak cipta dilindungi.
        </div>
    </div>
</body>
</html>
