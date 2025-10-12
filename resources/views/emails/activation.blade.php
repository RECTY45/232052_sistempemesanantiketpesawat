<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Aktivasi Akun Kamu</title>
</head>
<body>
    <h2>Halo, {{ $user->name }}!</h2>
    <p>Terima kasih sudah mendaftar. Klik link di bawah untuk mengaktifkan akunmu:</p>

    <p>
        <a href="{{ route('activate.account', $user->activation_token) }}"
           style="background:#28a745; color:white; padding:10px 20px; text-decoration:none; border-radius:6px;">
           Aktifkan Akun Saya.
        </a>
    </p>

    <p>Jika kamu tidak merasa membuat akun ini, abaikan saja email ini.</p>
</body>
</html>
