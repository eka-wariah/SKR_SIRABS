@extends('treasurer.master_treasurer')

@section('content')
<div class="body-wrapper mt-4">
    <div class="container-fluid">
      <br>

    <div class="d-flex align-items-center gap-4 mb-4">
        <div class="position-relative">
          <div class="border border-2 border-primary rounded-circle">
            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('vuexy/assets/img/avatars/16.jpg') }}" class="rounded-circle object-fit-cover" alt="user1" width="60" height="60"/>
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
            <h3 class="fw-semibold mb-1">
                Selamat Datang {{ trim((auth()->user()->first_name ?? '') . ' ' . (auth()->user()->last_name ?? '')) }}!
            </h3>
            
          @php
            \Carbon\Carbon::setLocale('id');
            $tanggal = \Carbon\Carbon::now();
          @endphp
          <span>{{ $jabatan }}, Semangat beraktivitas dan jangan lupa membayar retribusi - {{ $tanggal->translatedFormat('d F Y') }}</span>
        </div>
      </div>

      <br>

    <div class="row">
        <div class="col-md-3"><x-stat-box title="Total Pemasukan" value="Rp{{ number_format($totalPemasukan,0,',','.') }}" bg="success"/></div>
        <div class="col-md-3"><x-stat-box title="Total Pengeluaran" value="Rp{{ number_format($totalPengeluaran,0,',','.') }}" bg="danger"/></div>
        <div class="col-md-3"><x-stat-box title="Potongan Bendahara (10%)" value="Rp{{ number_format($potonganBendahara,0,',','.') }}" bg="warning"/></div>
        <div class="col-md-3"><x-stat-box title="Saldo Akhir" value="Rp{{ number_format($saldoAkhir,0,',','.') }}" bg="primary"/></div>
    </div>

    {{-- Grafik Pemasukan & Pengeluaran --}}
    <div class="card mt-4">
        <div class="card-body">
            <h5>Grafik Pemasukan & Pengeluaran Bulanan</h5>
            <canvas id="financeChart"></canvas>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Transaksi Masuk Terbaru</h6>
                    <ul class="list-group">
                        @foreach ($transaksiMasuk as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $item->created_at->format('d M Y') }}</span>
                                <strong>Rp{{ number_format($item->jumlah_bayar, 0, ',', '.') }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Transaksi Keluar Terbaru</h6>
                    <ul class="list-group">
                        @foreach ($transaksiKeluar as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $item->created_at->format('d M Y') }}</span>
                                <strong>Rp{{ number_format($item->jumlah_bayar, 0, ',', '.') }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($bulanLabels) !!};
    const dataMasuk = {!! json_encode($pemasukanBulanan) !!};
    const dataKeluar = {!! json_encode($pengeluaranBulanan) !!};

    new Chart(document.getElementById('financeChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: dataMasuk,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Pengeluaran',
                    data: dataKeluar,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.2)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
