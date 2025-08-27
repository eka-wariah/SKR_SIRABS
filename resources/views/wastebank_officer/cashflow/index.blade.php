@extends('wastebank_officer.master_officer')

@push('link')
    <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Daftar Kategori Sampah
@endsection

@section('content')
<div class="datatables" style="padding: 25px">
    <div class="card">
        <div class="card-body">
            <div class="mb-5 position-relative">
                <h4 class="card-title mb-0">Laporan Kas Bank Sampah</h4>
                <a href="{{ route('cash.create') }}" class="btn btn-primary position-absolute top-0 end-0">Tambah Pemasukan</a>
            </div>
            <p class="card-subtitle mb-3">
                
            </p>
            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Transaksi</th>
                <th>Nama</th>
                <th>Jumlah Pemasukan</th>
                <th>Jumlah Pengeluaran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMasuk = 0;
                $totalKeluar = 0;
            @endphp

            @foreach($cashes as $cash)
                @php
                    if ($cash->type == 'Masuk') {
                        $totalMasuk += $cash->amount;
                    } else {
                        $totalKeluar += $cash->amount;
                    }
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($cash->date)->format('d-m-Y') }}</td>
                    <td>{{ $cash->type }}</td>
                    <td>{{ $cash->user->name ?? '-' }}</td>
                    <td>
                        @if ($cash->type == 'Masuk')
                            Rp {{ number_format($cash->amount, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        @if ($cash->type == 'Keluar')
                            Rp {{ number_format($cash->amount, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>{{ $cash->description }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Jumlah</th>
                <th>Rp {{ number_format($totalMasuk, 0, ',', '.') }}</th>
                <th>Rp {{ number_format($totalKeluar, 0, ',', '.') }}</th>
                <th></th>
            </tr>
            <tr>
                <th colspan="3">Saldo Akhir</th>
                <th colspan="3">Rp {{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</div>
        </div>
    </div>
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

