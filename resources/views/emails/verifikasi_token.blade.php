<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Akun Anda</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 560px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            color: #333333;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        p {
            font-size: 15px;
            line-height: 1.6;
            margin: 10px 0;
            color: #555555;
        }

        .token {
            background-color: #e8f4ff;
            color: #2b7cd3;
            font-size: 26px;
            font-weight: bold;
            padding: 14px 20px;
            border-radius: 8px;
            text-align: center;
            letter-spacing: 6px;
            margin: 20px 0;
        }

        .footer {
            font-size: 13px;
            text-align: center;
            color: #aaa;
            margin-top: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Halo!</h2>
        <p>Terima kasih telah mendaftar di <strong>HNFR Tools</strong>.</p>
        <p>Untuk mengaktifkan akun kamu, silakan gunakan token verifikasi berikut:</p>

        <div class="token">{{ $token }}</div>

        <p>Masukkan token ini di aplikasi untuk menyelesaikan proses aktivasi akunmu.</p>
        <p style="font-style: italic; color: #d9534f;">Jangan bagikan token ini kepada siapa pun.</p>

        <div class="footer">
            &copy; {{ date('Y') }} HNFR Tools. Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>
</html>
