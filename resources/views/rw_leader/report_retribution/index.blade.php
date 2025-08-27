@extends('rw_leader.master_rw-leader')

@push('link')
    <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
Daftar Laporan Pembayaran Retribusi
@endsection

@section('content')
<div class="datatables" style="padding: 25px">
    <h4 class="mb-3">Daftar Laporan Pembayaran Retribusi dari Bendahara</h4>
    <ul class="nav nav-tabs">
        @foreach ([2025, 2024, 2023] as $tahun)
            <li class="nav-item">
                <a class="nav-link {{ request('year', date('Y')) == $tahun ? 'active' : '' }}" 
                   href="?year={{ $tahun }}&month={{ request('month', date('n')) }}">
                    {{ $tahun }}
                </a>
            </li>
        @endforeach
    </ul>
    
    {{-- Tombol Bulan --}}
    @php
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $selectedYear = request('year', date('Y'));
        $selectedMonth = request('month', date('n'));
    @endphp
    
    <div class="mt-3 d-flex flex-wrap gap-2">
        @foreach ($bulanList as $no => $namaBulan)
            <a href="?year={{ $selectedYear }}&month={{ $no }}"
               class="btn btn-sm {{ $selectedMonth == $no ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ $namaBulan }}
            </a>
        @endforeach
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Laporan</th>
                    <th>Bendahara</th>
                    <th>Bulan</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notifications as $notif)
                    @php
                        $data = $notif->data;
                        $tanggal = \Carbon\Carbon::parse($notif->created_at)->format('d M Y');
                        $link = $data['url'] ?? '#';
                    @endphp
                    <tr>
                        <td>{{ $tanggal }}</td>
                        <td>{{ $data['title'] ?? '-' }}</td>
                        <td>{{ $data['message'] ? explode(' ', $data['message'])[0] : '-' }}</td>
                        <td>{{ $data['bulan'] ?? '' }} {{ $data['tahun'] ?? '' }}</td>
                        <td><a href="{{ $link }}" class="btn btn-sm btn-primary" target="_blank">Lihat PDF</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Belum ada laporan yang masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
