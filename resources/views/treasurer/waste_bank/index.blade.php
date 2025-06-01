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
        {{-- @php
    $years = range(date('Y'), date('Y') - 2); // Tampilkan 3 tahun terakhir
@endphp

<div class="flex flex-col gap-1 mb-9">
    @foreach ($years as $y)
        <a href="{{ route('waste_bank.index', ['year' => $y]) }}"
           class="px-4 py-2 border-b-2 {{ $year == $y ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-600' }}">
            {{ $y }}
        </a>
    @endforeach
</div>
<div class="flex flex-wrap justify-start gap-2 mb-2">
    @for ($m = 1; $m <= 12; $m++)
        <a href="{{ route('waste_bank.index', ['year' => $year, 'month' => $m]) }}"
           class="px-3 py-1 rounded {{ $month == $m ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
        </a>
    @endfor
</div> --}}
{{-- Tahun Tabs --}}
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
                                <th>Nama</th>
                                <th>Jumlah Uang</th>
                                <th>Aksi</th>
                                
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            <!-- start row -->
                            @foreach ( $waste_bank as $no=> $waste_bank)
                            <tr>
                                
                                <td>{{$no+1}}</td>
                                <td>{{ $waste_bank->user->name}}</td>
                                {{-- <td>{{ $waste_bank->trash_categories->trc_name}}</td> --}}
                                {{-- <td>{{ $waste_bank->wtb_total_wate}}</td> --}}
                                <td>Rp {{ number_format($waste_bank->wtb_total_money, 0, ',', '.') }}</td>
                                <td>
                                     <a href="/treasurer/waste_bank/{{ $waste_bank->id}}" class="btn btn-danger">Detail</a>

                                </td>


                                
                            </tr>
                            @endforeach
                            <!-- end row --> 
                            
                        </tbody>
                        <tfoot>
                            <!-- start row -->
                            

                            <tr>
                                <th></th>
                                <th>Total Keseluruhan</th>
                                <th>Rp {{ number_format($total_uang, 0, ',', '.') }}</th>
                                <th></th>
                            </tr>
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
