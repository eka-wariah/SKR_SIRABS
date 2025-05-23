@extends('citizen.master_citizen')

@push('link')
    <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Daftar Kategori Sampah
@endsection

@section('content')
<div class="container">
    <h4 class="mb-4">Form Pembayaran Retribusi</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="" method="POST">
        @csrf

        <!-- Pilih Kategori -->
        <div class="mb-3">
            <label for="category" class="form-label">Kategori Retribusi</label>
            <select name="category" id="category" class="form-select" required>
                <option value="" disabled selected>Pilih kategori</option>
                <option value="air">Retribusi Air</option>
                <option value="sampah">Retribusi Sampah</option>
            </select>
        </div>

        <!-- Nominal -->
        <div class="mb-3">
            <label for="amount" class="form-label">Jumlah Pembayaran (Rp)</label>
            <input type="number" name="amount" id="amount" class="form-control" required min="100">
        </div>

        <!-- Metode Pembayaran -->
        <div class="mb-3">
            <label for="method" class="form-label">Metode Pembayaran</label>
            <select name="method" id="method" class="form-select" required>
                <option value="" disabled selected>Pilih metode</option>
                <option value="bank">Transfer Bank (Payment Gateway)</option>
                <option value="saldo">Gunakan Saldo Bank Sampah</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
        </div>
    </form>
</div>
@endsection



@push('script')
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{ asset('modernize/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="{{ asset('modernize/assets/js/datatable/datatable-advanced.init.js')}}"></script>
@endpush