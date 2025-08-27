@component('mail::message')
# Invoice Baru Tersedia

Halo,  
Invoice retribusi untuk periode **{{ $invoice->periode }}** sudah dibuat dan terlampir dalam email ini.

Silakan cek dan lakukan pembayaran sebelum tanggal {{ $invoice->due_date->format('d-m-Y') }}.

Terima kasih.

@endcomponent
