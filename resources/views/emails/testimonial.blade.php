<!DOCTYPE html>
<html>
<head>
    <title>Mohon Kesan dan Pesan Anda - {{ $program->title }}</title>
</head>
<body>
    <h2>Halo!</h2>
    <p>Terima kasih telah mengikuti program <strong>{{ $program->title }}</strong>.</p>
    <p>Kami sangat menghargai partisipasi Anda. Untuk membantu kami meningkatkan kualitas program di masa depan, kami mohon kesediaan Anda untuk memberikan ulasan (kesan, pesan, dan penilaian) mengenai program ini.</p>
    <p>Silakan klik tautan di bawah ini untuk mengisi form testimoni:</p>
    <p>
        <a href="{{ url('/testimoni/' . $token) }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Isi Testimoni</a>
    </p>
    <p>Tautan ini bersifat unik dan hanya untuk Anda. Form ini hanya dapat diisi satu kali.</p>
    <p>Terima kasih,<br>Tim {{ config('app.name') }}</p>
</body>
</html>
