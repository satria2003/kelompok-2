<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 24px;
        }
        .container {
            max-width: 580px;
            margin: auto;
            background-color: #ffffff;
            padding: 36px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            color: #333;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 12px;
        }
        p {
            font-size: 15px;
            line-height: 1.6;
            color: #555;
            margin: 10px 0;
        }
        .token {
            background-color: #e9f3ff;
            color: #007bff;
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 6px;
            padding: 16px;
            border-radius: 10px;
            text-align: center;
            margin: 24px 0;
        }
        .note {
            font-style: italic;
            color: #888;
            font-size: 13px;
            margin-top: 8px;
        }
        .footer {
            font-size: 13px;
            text-align: center;
            color: #999;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">📧 Token Verifikasi Email</div>

        <p>Gunakan token berikut untuk memverifikasi email kamu:</p>

        <div class="token">{{ $token }}</div>

        <p class="note">Jangan bagikan token ini kepada siapa pun.</p>

        <div class="footer">
            &copy; {{ date('Y') }} HNFR Tools. Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>
</html>
