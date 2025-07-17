@extends('wastebank_officer.master_officer')
@push('link')
<link rel="stylesheet" href="{{ asset('vuexy/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
@endpush

@section('content')
<div class="body-wrapper mt-4">
  <div class="container-fluid">
    <div class="d-flex align-items-center gap-4 mb-4">
      <div class="position-relative">
        <div class="border border-2 border-primary rounded-circle">
          <img src="{{ asset('modernize/assets/images/profile/user-1.jpg') }}" class="rounded-circle m-1" alt="user1" width="60" />
        </div>
      </div>
      <div>
        <h3 class="fw-semibold">Selamat Datang {{ auth()->user()->name }}!</h3>
        @php
        \Carbon\Carbon::setLocale('id');
        $tanggal = \Carbon\Carbon::now();
        @endphp
        <span>Semangat beraktivitas - {{ $tanggal->translatedFormat('d F Y') }}</span>
      </div>
    </div>

    <div class="body-wrapper mt-4">
      <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="row pb-4">
          {{-- KIRI: Rekap Ringkas --}}
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="d-flex flex-column align-items-start w-100">
              <div class="text-start">
                <h5 class="card-title fw-semibold">Rekap Bank Sampah</h5>
                <span>Tahun {{ now()->format('Y') }}</span>
              </div>
              <div class="mt-lg-auto mt-4 mb-4">
                <span class="text-dark">Total Sampah yang Terkumpul</span>
                <h2 class="mt-2 fw-bold">{{ number_format($totalBerat, 2, ',', '.') }} kg</h2>
              </div>
            </div>
          </div>
    
          {{-- KANAN: Grafik Berat Sampah --}}
          <div class="col-lg-8">
            <div class="card shadow-sm">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-3">Grafik Berat Sampah per Bulan</h5>
                <canvas id="beratSampahChart" height="100"></canvas>
              </div> 
            </div>
          </div>
    
      {{-- BAWAH: Statistik --}}
      <br>
      <div class="col-12">
        <div class="border-top">
          <div class="row gx-0">
            {{-- Box 1 --}}
            <div class="col-md-4 border-end">
              <div class="p-4 py-3 py-md-4">
                <p class="fs-5 text-danger mb-0">
                  <span class="text-danger">
                    <span class="bg-danger rounded-circle d-inline-block me-1" style="width:8px; height:8px;"></span>
                  </span>Total Dana yang ditarik tunai
                <h3 class="mt-2 mb-0">Rp {{ number_format($danaDiambil, 0, ',', '.') }}</h3>
              </div>
            </div>
    
            {{-- Box 2 --}}
            <div class="col-md-4 border-end">
              <div class="p-4 py-3 py-md-4">
                <p class="fs-5 text-primary mb-0">
                  <span class="bg-primary rounded-circle d-inline-block me-1" style="width:8px; height:8px;"></span>
                  </span>Total warga yang menabung
                </p>
                <h3 class="mt-2 mb-0">{{ $jumlahPenabung }} Warga</h3>
              </div>
            </div>
    
            {{-- Box 3 --}}
            <div class="col-md-4">
              <div class="p-4 py-3 py-md-4">
                <p class="fs-5 text-info mb-0">
                  <span class="bg-info rounded-circle d-inline-block me-1" style="width:8px; height:8px;"></span>
                  Total saldo bank sampah
                </p>
                <h3 class="mt-2 mb-0">Rp {{ number_format($totalUang, 0, ',', '.') }}</h3>
              </div>
            </div>
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
  const ctx = document.getElementById('beratSampahChart');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: @json($bulanLabels),
      datasets: [{
        label: 'Berat Sampah (kg)',
        data: @json($beratPerBulan),
        borderColor: '#3b82f6',
        backgroundColor: 'rgba(59, 130, 246, 0.2)',
        borderWidth: 3,
        tension: 0.4,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
@endpush
