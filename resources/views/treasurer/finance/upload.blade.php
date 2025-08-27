@extends('treasurer.master_treasurer')

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
    <h4>Upload Laporan PDF ke RW</h4>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('treasurer.laporan.upload') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="pdf" class="form-label">File PDF</label>
            <input type="file" class="form-control" name="pdf" accept="application/pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">Kirim ke RW</button>
    </form>

    @if(isset($uploadedReports) && count($uploadedReports) > 0)
    <hr class="my-5">
    <h5>Riwayat Laporan Terkirim</h5>
    <table class="table">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Waktu Kirim</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($uploadedReports as $report)
                <tr>
                    <td>{{ $report->bulan }}</td>
                    <td>{{ $report->tahun }}</td>
                    <td>{{ $report->created_at->format('d M Y H:i') }}</td>
                    <td><a href="{{ $report->file_url }}" target="_blank">Lihat File</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
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
