<div class="container py-4">
    <h3 class="text-center">LAPORAN PEMBAYARAN RETRIBUSI</h3>
    <h5 class="text-center">Bulan {{ \Carbon\Carbon::createFromDate($year, $month)->translatedFormat('F Y') }}</h5>

    <table class="table table-bordered summary-table mt-4">
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
                <td class="text-end">
                    Rp{{ number_format($airTotal, 0, ',', '.') }}
                    <button class="btn btn-sm btn-link text-primary" onclick="showDetail('air', {{ $year }}, {{ $month }})">Detail</button>
                </td>
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
                <td class="text-end">
                    Rp{{ number_format($sampahTotal, 0, ',', '.') }}
                    <button class="btn btn-sm btn-link text-primary" onclick="showDetail('sampah', {{ $year }}, {{ $month }})">Detail</button>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Pengeluaran Air</td>
                <td></td>
                <td class="text-end">
                    Rp{{ number_format($airPengeluaran, 0, ',', '.') }}
                    <button class="btn btn-sm btn-link text-primary" onclick="showDetail('keluar_air', {{ $year }}, {{ $month }})">Detail</button>
                </td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>Pengeluaran Sampah</td>
                <td></td>
                <td class="text-end">
                    Rp{{ number_format($sampahPengeluaran, 0, ',', '.') }}
                    <button class="btn btn-sm btn-link text-primary" onclick="showDetail('keluar_sampah', {{ $year }}, {{ $month }})">Detail</button>
                </td>
            </tr>
        </tbody>
        <tfoot class="fw-bold">
            <tr>
                <td colspan="2" class="text-end">TOTAL PEMASUKAN</td>
                <td class="text-end">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="text-end">TOTAL PENGELUARAN</td>
                <td class="text-end">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-end">SALDO AKHIR</td>
                <td class="text-end">Rp{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</div>
