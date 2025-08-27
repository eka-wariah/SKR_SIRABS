<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header, .footer { text-align: center; }
        .invoice-header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .invoice-number { font-weight: bold; font-size: 18px; }
        .section { margin-bottom: 20px; }
        .section h4 { margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        .address { line-height: 1.4; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #999; }
        th, td { padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .total { font-weight: bold; font-size: 16px; }
    </style>
</head>
<body>

    <div class="header invoice-header">
        <h2>Tagihan Pembayaran Retribusi</h2>
        <div class="invoice-number">No. Invoice: #{{ $invoice->invoice_number }}</div>
    </div>

    <div class="section">
        <h4>Dari:</h4>
        <div class="address">
            <strong>{{ trim(($treasurer?->first_name ?? '') . ' ' . ($treasurer?->last_name ?? '')) ?: '-' }}</strong><br/>
            Bendahara RT {{ $treasurer->usr_scope_id ?? '-' }}<br/>
            RW 04 - Sistem Informasi Retribusi<br/>
        </div>
    </div>

    <div class="section">
        <h4>Kepada:</h4>
        <div class="address">
            <strong>{{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) }}</strong><br/>
            No. KK: {{ $household->no_kk ?? '-' }}<br/>
            Alamat: {{ $user->address ?? '-' }}<br/>
        </div>
    </div>

    <div class="section">
        <h4>Detail Invoice:</h4>
        <p>Periode: {{ \Carbon\Carbon::parse($invoice->periode)->locale('id')->translatedFormat('F Y') }}</p>
        <p>Tanggal Invoice: {{ \Carbon\Carbon::parse($invoice->created_at)->locale('id')->translatedFormat('j F Y') }}</p>
        <p>Jatuh Tempo: {{ \Carbon\Carbon::parse($invoice->due_date)->locale('id')->translatedFormat('j F Y') }}</p>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kategori Pembayaran</th>
                    <th class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $invoice->paymentCategory->pym_name ?? '-' }}</td>
                    <td class="text-right">{{ number_format($invoice->amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-right total">Jumlah yang harus dibayar:</td>
                    <td class="text-right total">{{ number_format($invoice->amount, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer section">
        <p>Terima kasih atas perhatian dan kerjasama Anda.</p>
    </div>

</body>
</html>
