<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun Anda - Travelo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .welcome-title {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .activation-btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .activation-btn:hover {
            transform: translateY(-2px);
        }

        .info-box {
            background-color: #e8f4fd;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }

        .link-text {
            word-break: break-all;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">✈️ Travelo</div>
            <p style="color: #666; font-size: 16px;">Sistem Pemesanan Tiket Pesawat</p>
        </div>

        <h2 class="welcome-title">Selamat datang, {{ $user->name }}! 🎉</h2>

        <p>Terima kasih telah mendaftar di <strong>Travelo</strong>. Kami sangat senang Anda bergabung dengan kami!</p>

        <p>Untuk keamanan akun Anda, silakan klik tombol di bawah ini untuk mengaktifkan akun Anda:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('activate.account', $user->activation_token) }}" class="activation-btn">
                🔓 Aktifkan Akun Saya
            </a>
        </div>

        <div class="info-box">
            <strong>💡 Informasi Penting:</strong><br>
            • Link aktivasi ini hanya berlaku untuk satu kali penggunaan<br>
            • Setelah aktivasi berhasil, Anda dapat login dengan email dan password yang telah didaftarkan<br>
            • Jika Anda tidak dapat mengklik tombol, copy dan paste link berikut ke browser Anda:
        </div>

        <div class="link-text">
            {{ route('activate.account', $user->activation_token) }}
        </div>

        <div class="warning-box">
            <strong>⚠️ Perhatian:</strong><br>
            Jika Anda tidak merasa mendaftar akun di Travelo, silakan abaikan email ini atau hubungi kami untuk
            melaporkan penyalahgunaan.
        </div>

        <p>Setelah aktivasi berhasil, Anda dapat:</p>
        <ul>
            <li>🔍 Mencari dan memesan tiket pesawat</li>
            <li>💳 Melakukan pembayaran dengan mudah</li>
            <li>📱 Mengelola booking Anda</li>
            <li>✈️ Menikmati perjalanan yang menyenangkan</li>
        </ul>

        <p>Jika Anda mengalami kesulitan atau memiliki pertanyaan, jangan ragu untuk menghubungi tim support kami.</p>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} Travelo. Semua hak dilindungi.</p>
            <p style="font-size: 12px; color: #999;">
                Email dikirim ke: {{ $user->email }}<br>
                Tanggal: {{ now()->format('d F Y, H:i') }} WIB
            </p>
        </div>
    </div>
</body>

</html>