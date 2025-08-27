@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Invoice Saya</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nomor Invoice</th>
                <th>Periode</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Jatuh Tempo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->periode }}</td>
                <td>{{ $invoice->formatted_amount ?? 'Rp ' . number_format($invoice->amount, 2, ',', '.') }}</td>
                <td>
                    @if($invoice->status == 'paid')
                        <span class="badge bg-success">Lunas</span>
                    @elseif($invoice->status == 'unpaid')
                        <span class="badge bg-warning">Belum Bayar</span>
                    @else
                        <span class="badge bg-danger">Gagal</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('citizen.invoices.show', $invoice->inv_id) }}" class="btn btn-primary btn-sm">Detail</a>
                    @if($invoice->status == 'unpaid')
                        <form action="{{ route('citizen.invoices.payNow', $invoice->inv_id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button class="btn btn-success btn-sm" onclick="return confirm('Bayar sekarang?')">Bayar</button>
                        </form>
                    @endif
                    <a href="{{ route('citizen.invoices.pdf', $invoice->inv_id) }}" target="_blank" class="btn btn-info btn-sm">Cetak PDF</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada invoice.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
