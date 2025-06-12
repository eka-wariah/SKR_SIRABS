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
<div class="datatables" style="padding: 25px">
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
<div class="form-group mt-3">
    <label for="filter-rt" class="form-label">Filter RT</label>
    <select id="filter-rt" class="form-select" style="width: 200px">
        <option value="">-- Semua RT --</option>
        @foreach($scope as $scope)
            <option value="{{ $scope->id }}">RT {{ $scope->name }}</option>
        @endforeach
    </select>
</div>

        <div class="card">
            <div class="card-body">
                <div class="mb-5 position-relative">
                    <h4 class="card-title mb-0">Daftar Kategori</h4>
                </div>
                <p class="card-subtitle mb-3">
                    
                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th width="10%">No</th>
                                <th>Warga</th>
                                <th>Jumlah</th>
                                <th>Status Penyerahan</th>
                                <th>Aksi</th>
                                
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            <!-- start row -->
                        @php $no = 0; @endphp
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $payment->user->name}}</td>
                                <td>Rp{{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                                <td>
                                    @if ($payment->pyn_status_submission)
                                        <span class="badge bg-warning">{{ $payment->pyn_status_submission }}</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Diserahkan</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($payment->pyn_status_submission === 'Belum Diserahkan')
                                        <form action="{{ route('submission.mark_submitted', $payment->pyn_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Tandai Sudah Diserahkan</button>
                                        </form>
                                        @elseif ($payment->pyn_status_submission === 'Menunggu Konfirmasi')
                                        <span class="badge bg-info">Menunggu Konfirmasi</span>
                                    @elseif ($payment->pyn_status_submission === 'Sudah Dikonfirmasi')
                                        <span class="badge bg-success">Sudah Dikonfirmasi</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                            <!-- end row --> 
                            
                        </tbody>
                        <tfoot>
                            <!-- start row -->
                            

                            {{-- <tr>
                                <th></th>
                                <th>Total Keseluruhan</th>
                                <th>Rp {{ number_format($total_uang, 0, ',', '.') }}</th>
                                <th></th>
                            </tr> --}}
                            <!-- end row -->
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
