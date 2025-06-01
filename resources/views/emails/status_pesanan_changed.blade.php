<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Status Pesanan Diperbarui</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      padding: 24px;
    }
    .container {
      max-width: 620px;
      margin: auto;
      background-color: #ffffff;
      padding: 36px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      color: #333;
    }
    h2 {
      font-size: 22px;
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    p {
      font-size: 15px;
      line-height: 1.6;
      color: #555;
      margin: 10px 0;
    }
    .status {
      background-color: #e9f8f0;
      color: #28a745;
      font-weight: bold;
      padding: 10px 18px;
      border-radius: 8px;
      display: inline-block;
      margin: 16px 0;
    }
    .divider {
      border-top: 1px dashed #ccc;
      margin: 28px 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      margin-top: 12px;
    }
    table th, table td {
      padding: 12px 14px;
      border-bottom: 1px solid #eaeaea;
      text-align: left;
    }
    table th {
      background-color: #f8f9fa;
      color: #2c3e50;
    }
    .total {
      font-weight: bold;
      color: #1d1d1d;
    }
    .footer {
      font-size: 13px;
      color: #999;
      text-align: center;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>📦 Status Pesanan Anda Telah Diperbarui</h2>

    <p>Halo <strong>{{ $username }}</strong>,</p>

    <p>Kami ingin memberitahu bahwa status pesanan Anda telah diperbarui menjadi:</p>
    <div class="status">{{ ucfirst($status) }}</div>

    <div class="divider"></div>

    <p><strong>Detail Pesanan:</strong></p>
    <table>
      <tr>
        <th>ID Pesanan</th>
        <td>{{ $pesanan->id_pesanan }}</td>
      </tr>
      <tr>
        <th>Tanggal Pesanan</th>
        <td>{{ $pesanan->tanggal_dibuat }}</td>
      </tr>
      <tr>
        <th>Total Pembayaran</th>
        <td class="total">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
      </tr>
    </table>

    <div class="divider"></div>

    <p>Anda dapat memeriksa status terbaru pesanan Anda dengan login ke akun Anda melalui aplikasi kami.</p>

    <p>Terima kasih telah berbelanja di <strong>HNFR Tools</strong>. Kami senang dapat melayani Anda!</p>

    <div class="footer">
      &copy; {{ date('Y') }} HNFR Tools. Seluruh hak cipta dilindungi.
    </div>
  </div>
</body>
</html>
