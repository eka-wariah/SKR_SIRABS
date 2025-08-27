<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Penarikan</title>
</head>
<body>
    <p>Halo {{ $name }},</p>

    <p>Anda telah melakukan <strong>penarikan</strong> sebesar:</p>
    <p style="font-size: 18px; font-weight: bold;">
        Rp {{ number_format($amount, 0, ',', '.') }}
    </p>

    <p>Saldo Anda setelah penarikan:</p>
    <p style="font-size: 16px; color: green;">
        Rp {{ number_format($sisa, 0, ',', '.') }}
    </p>

    <p>Waktu penarikan: <strong>{{ $tanggal }}</strong></p>

    <hr>
    <p>Terima kasih telah menggunakan layanan Bank Sampah RW 04.</p>
</body>
</html>
