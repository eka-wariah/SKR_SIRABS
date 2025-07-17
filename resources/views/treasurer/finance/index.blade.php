@extends('treasurer.master_treasurer') {{-- Ganti sesuai layout kamu --}}

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Catatan Keuangan Bendahara</h4>

    {{-- Tombol Tambah --}}
    <div class="d-flex gap-2 mb-4">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahPemasukan">
            + Tambah Pemasukan
        </button>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTambahPengeluaran">
            + Tambah Pengeluaran
        </button>
    </div>

    {{-- Tabel --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Kategori</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                @if($item->tipe === 'Pemasukan')
                                    Pembayaran {{ $item->paymentCategory->pym_name ?? '-' }}
                                @else
                                    Pengeluaran untuk {{ ucfirst($item->pyn_sys_note) }}
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->tipe == 'Pemasukan' ? 'success' : 'danger' }}">
                                    {{ $item->tipe }}
                                </span>
                            </td>
                            <td>{{ $item->kategori }}</td>
                            <td>Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($item->metode_bayar) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ringkasan --}}
    @php
        $totalMasuk = $payments->where('tipe', 'Pemasukan')->sum('jumlah_bayar');
        $totalKeluar = $payments->where('tipe', 'Pengeluaran')->sum('jumlah_bayar');
        $saldoAkhir = $totalMasuk - $totalKeluar;
    @endphp

    <div class="mt-4">
        <div class="alert alert-info">
            <strong>Total Pemasukan:</strong> Rp {{ number_format($totalMasuk, 0, ',', '.') }} <br>
            <strong>Total Pengeluaran:</strong> Rp {{ number_format($totalKeluar, 0, ',', '.') }} <br>
            <strong>Saldo Akhir:</strong> Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
        </div>
    </div>
</div>

{{-- MODAL TAMBAH PEMASUKAN --}}
<div class="modal fade" id="modalTambahPemasukan" tabindex="-1" aria-labelledby="modalTambahPemasukanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('treasurer.finance.payment.store') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pemasukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="household_id" class="form-label">KK / Rumah Tangga</label>
                    <select name="household_id" class="form-select" required>
                        @foreach($households as $householdId)
                            <option value="{{ $householdId }}">ID KK: {{ $householdId }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pyn_payment_category_id" class="form-label">Kategori Pembayaran</label>
                    <select name="pyn_payment_category_id" class="form-select" required>
                        @foreach($paymentCategories as $category)
                            <option value="{{ $category->pym_id }}">{{ $category->pym_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit">Simpan</button>
            </div>
        </div>
    </form>
  </div>
</div>

{{-- MODAL TAMBAH PENGELUARAN --}}
<div class="modal fade" id="modalTambahPengeluaran" tabindex="-1" aria-labelledby="modalTambahPengeluaranLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('treasurer.finance.expense.store') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="jumlah_bayar" class="form-label">Jumlah Pengeluaran</label>
                    <input type="number" name="jumlah_bayar" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Kategori</label>
                    <select name="keterangan" class="form-select" required>
                        <option value="air">Air</option>
                        <option value="sampah">Sampah</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="submit">Simpan</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection


{{-- @extends('treasurer.master_treasurer')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4 fw-bold">Keuangan Lingkup Wilayah</h4>

    {{-- Ringkasan Keuangan 
    <div class="row">
        {{-- Air 
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title">Retribusi Air</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Total Pemasukan: <strong>Rp {{ number_format($airTotal, 0, ',', '.') }}</strong></li>
                        <li class="list-group-item">Potongan Bendahara (10%): Rp {{ number_format($airPotongan, 0, ',', '.') }}</li>
                        <li class="list-group-item">Pengeluaran Air: Rp {{ number_format($airPengeluaran, 0, ',', '.') }}</li>
                        <li class="list-group-item">Saldo Akhir Air: <strong class="text-success">Rp {{ number_format($airSaldo, 0, ',', '.') }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Sampah 
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title">Retribusi Sampah</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Total Pemasukan: <strong>Rp {{ number_format($sampahTotal, 0, ',', '.') }}</strong></li>
                        <li class="list-group-item">Pengeluaran Sampah: Rp {{ number_format($sampahPengeluaran, 0, ',', '.') }}</li>
                        <li class="list-group-item">Saldo Akhir Sampah: <strong class="text-success">Rp {{ number_format($sampahSaldo, 0, ',', '.') }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Tambah Pembayaran Manual 
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Tambah Pembayaran Warga (Offline)</div>
        <div class="card-body">
            <form action="{{ route('treasurer.finance.payment.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label>Household</label>
                        <select name="household_id" class="form-select" required>
                            <option value="">-- Pilih Household --</option>
                            @foreach($households as $id)
                                <option value="{{ $id }}">{{ $id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Jenis Pembayaran</label>
                        <select name="pyn_payment_category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($paymentCategories as $cat)
                                <option value="{{ $cat->pym_id }}">{{ $cat->pym_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control" required>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-success">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tambah Pengeluaran 
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">Tambah Pengeluaran</div>
        <div class="card-body">
            <form action="{{ route('treasurer.finance.expense.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Jumlah Pengeluaran</label>
                        <input type="number" name="jumlah_bayar" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Keterangan (air/sampah)</label>
                        <select name="keterangan" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="air">Perbaikan Air</option>
                            <option value="sampah">Gaji Petugas Sampah</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-warning">Simpan Pengeluaran</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Pembayaran 
    <div class="card mb-4">
        <div class="card-header bg-light fw-bold">Daftar Pembayaran Warga</div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Household</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $pay)
                        <tr>
                            <td>{{ $pay->pyn_periode }}</td>
                            <td>{{ $pay->pyn_household_id }}</td>
                            <td>{{ $pay->paymentCategory->pym_name ?? '-' }}</td>
                            <td>Rp {{ number_format($pay->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($pay->status) }}</td>
                            <td>{{ ucfirst($pay->metode_bayar) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection --}}
