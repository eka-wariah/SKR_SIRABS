@extends('rt_leader.master_rt-leader')

@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css') }}">
@endpush

@section('title', 'SITAW | Laporan Penyerahan Dana')

@section('content')
<div class="datatables" style="padding: 25px">
    {{-- Filter Tahun --}}
    <ul class="nav nav-tabs" id="yearTabs">
        @foreach ([2025, 2024, 2023] as $tahun)
            <li class="nav-item">
                <button class="nav-link year-tab {{ $year == $tahun ? 'active' : '' }}" data-year="{{ $tahun }}">{{ $tahun }}</button>
            </li>
        @endforeach
    </ul>

    {{-- Filter Bulan --}}
    @php
        $bulanList = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
    @endphp

    <div class="mt-3 d-flex flex-wrap gap-2" id="monthButtons">
        @foreach ($bulanList as $no => $namaBulan)
            <button class="btn btn-sm month-btn {{ $month == $no ? 'btn-primary' : 'btn-outline-primary' }}" data-month="{{ $no }}">{{ $namaBulan }}</button>
        @endforeach
    </div>

    {{-- Tempat laporan --}}
    <div id="reportSummaryContainer" class="mt-4">
        @include('rt_leader.report_retribution.summary', get_defined_vars())
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" id="detailModalContent">
        <div class="text-center">Memuat data...</div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
    function showDetail(type, year, month) {
        $('#detailModalContent').html('<div class="text-center">Memuat data...</div>');
        $('#detailModal').modal('show');
        $.get("{{ url('/rt_leader/retributions/detail') }}", { type, year, month }, function (res) {
            $('#detailModalContent').html(res.html);
        }).fail(() => $('#detailModalContent').html('<div class="text-danger">Gagal memuat data.</div>'));
    }

    $(document).on('click', '.year-tab, .month-btn', function () {
        const year = $(this).data('year') || $('.year-tab.active').data('year');
        const month = $(this).data('month') || $('.month-btn.btn-primary').data('month');

        $('.year-tab').removeClass('active');
        $(`.year-tab[data-year="${year}"]`).addClass('active');

        $('.month-btn').removeClass('btn-primary').addClass('btn-outline-primary');
        $(`.month-btn[data-month="${month}"]`).removeClass('btn-outline-primary').addClass('btn-primary');

        $('#reportSummaryContainer').html('<div class="text-center mt-4">Memuat laporan...</div>');

        $.get("{{ url('/rt_leader/retributions/summary') }}", { year, month }, function (res) {
            $('#reportSummaryContainer').html(res);
        });
    });
</script>
@endpush
