@extends('rt_leader.master_rt-leader')

@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
<div class="body-wrapper mt-4">
  <div class="container-fluid">

    {{-- Header Selamat Datang --}}
    <div class="d-flex align-items-center gap-4 mb-4">
      <div class="position-relative">
        <div class="border border-2 border-primary rounded-circle">
          <img src="{{ asset('modernize/assets/images/profile/user-1.jpg') }}" class="rounded-circle m-1" alt="user1" width="60" />
        </div>
      </div>
      <div>
        @php
    $user = auth()->user();
    $role = $user->getRoleNames()->first(); // misalnya "rt_leader"
    $rtNumber = $user->areaScope->asc_number ?? '-';

    // Ubah role menjadi label
    $jabatan = match ($role) {
        'rt_leader' => "Ketua RT $rtNumber",
        'treasurer' => "Bendahara RT $rtNumber",
        'citizen' => "Warga RT $rtNumber",
        default => "RT $rtNumber"
    };
@endphp
<h3 class="fw-semibold">Selamat Datang {{ auth()->user()->full_name }}!</h3>

        @php
        \Carbon\Carbon::setLocale('id');
        $tanggal = \Carbon\Carbon::now();
        @endphp
        <span>{{ $jabatan }}, Semangat beraktivitas - {{ $tanggal->translatedFormat('d F Y') }}</span>
      </div>
    </div>

    {{-- Statistik --}}
    <div class="row g-3">
      <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="mb-1">Jumlah Warga</h6>
            <h4 class="fw-bold">{{ $jumlahWarga }}</h4>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="mb-1">Jumlah KK</h6>
            <h4 class="fw-bold">{{ $jumlahKK }}</h4>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="mb-1">Warga Belum Diverifikasi</h6>
            <h4 class="fw-bold">{{ $wargaverif }}</h4>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="mb-1">Pengajuan Air (Pending)</h6>
            <h4 class="fw-bold">{{ $pengajuanPending }}</h4>
          </div>
        </div>
      </div>
      {{-- <div class="col-md-12 col-xl-6">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h6 class="mb-1">Total Retribusi Bulan Ini</h6>
            <h4 class="fw-bold">Rp{{ number_format($totalRetribusi, 0, ',', '.') }}</h4>
          </div>
        </div>
      </div> --}}
    </div>

    {{-- Chart Area --}}
    <div class="row mt-4 g-4">
      <div class="col-md-6">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title">Grafik Pengajuan Air per Bulan</h5>
            <canvas id="pengajuanChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title">Grafik Pendaftaran Warga per Bulan</h5>
            <canvas id="pendaftaranChart"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const bulan = {!! json_encode($bulanLabels) !!};
  const dataPengajuan = {!! json_encode($jumlahPengajuanArray) !!};
  const dataPendaftaran = {!! json_encode($jumlahPendaftaranArray) !!};

  // Area Chart Pengajuan Air
  new Chart(document.getElementById('pengajuanChart'), {
    type: 'line',
    data: {
      labels: bulan,
      datasets: [{
        label: 'Pengajuan Air',
        data: dataPengajuan,
        backgroundColor: 'rgba(93, 135, 255, 0.2)',
        borderColor: '#5D87FF',
        borderWidth: 2,
        tension: 0.4,
        fill: true,
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } }
      }
    }
  });

  // Bar Chart Pendaftaran Warga
  new Chart(document.getElementById('pendaftaranChart'), {
    type: 'bar',
    data: {
      labels: bulan,
      datasets: [{
        label: 'Pendaftaran Warga',
        data: dataPendaftaran,
        backgroundColor: 'rgba(40, 167, 69, 0.6)',
        borderColor: '#28a745',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 } }
      }
    }
  });
</script>
@endpush
