@extends('rw_leader.master_rw-leader')

@push('link')
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('content')
<div class="body-wrapper mt-4">
  <div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center gap-4 mb-4">
      <div class="position-relative">
        <div class="border border-2 border-primary rounded-circle">
          <img src="{{ asset('modernize/assets/images/profile/user-1.jpg') }}" class="rounded-circle m-1" alt="user" width="60" />
        </div>
      </div>
      <div>
        @php
            \Carbon\Carbon::setLocale('id');
            $tanggal = \Carbon\Carbon::now();
          @endphp
        <h3 class="fw-semibold">Selamat Datang {{ auth()->user()->name }}!</h3>
        <span>Ketua RW 04, Semangat beraktivitas dan jangan lupa membayar retribusi - {{ $tanggal->translatedFormat('d F Y') }}</span>
      </div>
    </div>

    {{-- Statistik --}}
    <div class="row">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="mb-1">Jumlah RT</h6>
            <h4 class="fw-bold">{{ $jumlahRT }}</h4>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="mb-1">Jumlah Warga</h6>
            <h4 class="fw-bold">{{ $jumlahWarga }}</h4>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="mb-1">Pengguna Air Aktif</h6>
            <h4 class="fw-bold">{{ $jumlahPenggunaAir }}</h4>
          </div>
        </div>
      </div>
    </div>

    {{-- Tabel Warga per RT --}}
    <div class="card mt-4">
      <div class="card-body">
        <h5 class="card-title">Jumlah Warga per RT</h5>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>RT</th>
                <th class="text-end">Jumlah Warga</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rtStats as $rt)
              <tr>
                <td>{{ $rt['label'] }}</td>
                <td class="text-end">{{ $rt['jumlah'] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Chart --}}
    <div class="card mt-4">
      <div class="card-body">
        <h5 class="card-title">Grafik Jumlah Warga per RT</h5>
        <canvas id="wargaChart" height="100"></canvas>
      </div>
    </div>

  </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const rtLabels = {!! json_encode($chartLabels) !!};
  const rtData = {!! json_encode($chartData) !!};

  new Chart(document.getElementById('wargaChart'), {
    type: 'bar',
    data: {
      labels: rtLabels,
      datasets: [{
        label: 'Jumlah Warga',
        data: rtData,
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          precision: 0
        }
      },
      plugins: {
        legend: { display: false }
      }
    }
  });
</script>
@endpush
