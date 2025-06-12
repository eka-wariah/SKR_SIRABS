@extends('treasurer.master_treasurer')

@section('title')
    Konfirmasi Penyerahan Dana
@endsection

@section('content')
<div class="container">
    <h3>Konfirmasi Penyerahan Dana - Metode Bank Sampah</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Warga</th>
                <th>Jumlah</th>
                <th>Status Penyerahan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->user->name }}</td>
                <td>Rp{{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                <td><span class="badge bg-warning">{{ $payment->pyn_status_submission }}</span></td>
                <td>
                    @if (!$payment->pyn_status_submission)
                    <form action="{{ route('submission.confirm', $payment->pyn_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Konfirmasi Diterima</button>
                    </form>
                    @elseif ($payment->pyn_status_submission === 'Menunggu Konfirmasi')
                    <span class="badge bg-info">Menunggu Konfirmasi</span>
                @elseif ($payment->pyn_status_submission === 'Sudah Dikonfirmasi')
                    <span class="badge bg-success">Sudah Dikonfirmasi</span>
                @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
