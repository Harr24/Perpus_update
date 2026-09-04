<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #333333; text-align: center;">Reset Password Anda</h2>

        <p style="color: #555555; font-size: 16px; line-height: 1.5;">
            Halo! Kami menerima permintaan untuk mereset password akun Perpustakaan Multicomp Anda yang terhubung dengan email <strong>{{ $email }}</strong>.
        </p>

        <p style="color: #555555; font-size: 16px; line-height: 1.5;">
            Silakan klik tombol di bawah ini untuk membuat password baru:
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}"
               style="background-color: #4f46e5; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
                Buat Password Baru
            </a>
        </div>

        <p style="color: #888888; font-size: 14px; margin-top: 30px;">
            <em>Jika Anda tidak merasa meminta reset password, abaikan saja email ini. Akun Anda tetap aman.</em>
        </p>
    </div>

</body>
</html>
