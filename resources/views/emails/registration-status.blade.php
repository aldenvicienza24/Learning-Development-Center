<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0E214A;
            color: #F2F6FF;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #0E214A;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #08142D;
            color: #F2F6FF;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .content {
            padding: 30px;
        }
        .message-block {
            white-space: pre-wrap;
            margin-bottom: 20px;
        }
        .details-card {
            background-color: #0E214A;
            border: 1px solid #29446F;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .details-card h3 {
            margin-top: 0;
            color: #F2F6FF;
            font-size: 16px;
            margin-bottom: 15px;
            border-bottom: 1px solid #29446F;
            padding-bottom: 10px;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
            color: #9CB0CF;
        }
        .detail-value {
            color: #F2F6FF;
        }
        .unique-code-box {
            margin-top: 20px;
            background-color: #0E214A;
            border: 1px dashed #3B82F6;
            padding: 15px;
            text-align: center;
            border-radius: 6px;
        }
        .unique-code-label {
            font-size: 12px;
            color: #3B82F6;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .unique-code-value {
            font-size: 24px;
            font-family: monospace;
            font-weight: bold;
            color: #F2F6FF;
            letter-spacing: 2px;
        }
        .footer {
            background-color: #0E214A;
            color: #9CB0CF;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>UISI Learning & Development Center</h1>
        </div>
        <div class="content">
            @if(!empty(trim($opening)))
            <div class="message-block">{{ $opening }}</div>
            @endif

            <div class="details-card">
                <h3>Detail Pendaftaran</h3>
                <div class="detail-row">
                    <span class="detail-label">Nama Lengkap:</span>
                    <span class="detail-value">{{ $registration->full_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Program:</span>
                    <span class="detail-value">{{ $registration->program?->title ?? 'Program' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Instansi:</span>
                    <span class="detail-value">{{ $registration->institution }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $registration->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" style="font-weight:bold; color: {{ $status === 'diterima' ? '#0E214A' : '#2563EB' }};">
                        {{ strtoupper($status) }}
                    </span>
                </div>

                @if($status === 'diterima')
                <div class="unique-code-box">
                    <span class="unique-code-label">Kode Pendaftaran Unik</span>
                    <span class="unique-code-value">{{ $registration->unique_code }}</span>
                </div>
                @endif
            </div>

            @if(!empty(trim($closing)))
            <div class="message-block">{{ $closing }}</div>
            @endif
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Universitas Internasional Semen Indonesia. Hak cipta dilindungi.<br>
            Jl. Veteran, Kompleks PT Semen Indonesia, Gresik, Jawa Timur.
        </div>
    </div>
</body>
</html>
