<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title> LAPORAN PEMBAYARAN RETRIBUSI {{ strtoupper($nomorRT) }} Bulan {{ strtoupper($bulan) }} {{ $tahun }}
    </title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            font-size: 12px;
            margin: 40px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #000;
        }
        th {
            background-color: #e8e8e8;
        }
        .summary-table {
            margin-top: 30px;
            width: 100%;
        }
        .summary-table td {
            padding: 6px;
        }
    </style>
</head>
<body>

    <h2>LAPORAN PEMBAYARAN RETRIBUSI {{ strtoupper($nomorRT) }}</h2>
        <h4>Bulan {{ strtoupper($bulan) }} {{ $tahun }}</h4>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Deskripsi</th>
                <th class="text-end">Pemasukan</th>
                <th class="text-end">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Pemasukan Air</td>
                <td class="text-end">Rp{{ number_format($airTotal, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Potongan 10% Bendahara (Air)</td>
                <td></td>
                <td class="text-end">Rp{{ number_format($airPotongan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Pemasukan Sampah</td>
                <td class="text-end">Rp{{ number_format($sampahTotal, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Pengeluaran Air</td>
                <td></td>
                <td class="text-end">Rp{{ number_format($pengeluaranAir, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Pengeluaran Sampah</td>
                <td></td>
                <td class="text-end">Rp{{ number_format($pengeluaranSampah, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-end">TOTAL PEMASUKAN</th>
                <th class="text-end">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</th>
                <th></th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">TOTAL PENGELUARAN</th>
                <th class="text-end">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">SALDO AKHIR</th>
                <th class="text-end">Rp{{ number_format($saldoAkhir, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 60px;">
        <div style="float: left; width: 50%; text-align: center;">
            <p>Disusun Oleh,</p>
            <br><br><br>
            <p><strong>{{ $namaBendahara }}</strong></p>
            <p><strong>Bendahara {{ strtoupper($nomorRT) }}</strong></p>
        </div>
        <div style="float: right; width: 50%; text-align: center;">
            <p>Diperiksa Oleh,</p>
            <br><br><br><br>
            <p><strong>Ketua RW</strong></p>
        </div>
    </div>

</body>
</html>
