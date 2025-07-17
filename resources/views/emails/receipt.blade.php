@component('mail::message')
# Bukti Pembayaran

Halo {{ $payment->user->name }},

Berikut detail pembayaran kamu:

- Kategori: {{ $payment->paymentCategory->pym_name }}
- Jumlah: Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
- Metode: {{ ucfirst($payment->metode_bayar) }}
- Tanggal: {{ $payment->created_at->format('d M Y') }}

@component('mail::button', ['url' => url('/citizen/payment/invoice/'.$payment->pyn_id)])
Lihat Invoice
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
