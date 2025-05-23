@extends('citizen.master_citizen')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
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
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                          <div class="row align-items-center">
                            <div class="col-9">
                              <h4 class="fw-semibold mb-8">Detail Sampah yang Dikumpulkan</h4>
                              <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                  <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/citizen/waste_bank/">Kembali</a>
                                  </li>
                                  <li class="breadcrumb-item" aria-current="page">Detail Sampah yang Dikumpulkan</li>
                                </ol>
                              </nav>
                            </div>
                            <div class="col-3">
                              <div class="text-center mb-n5">
                                <img src="{{ asset('modernize/assets/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <p class="card-subtitle mb-3">
                    
                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Kategori Sampah</th>
                                <th>Berat</th>
                                <th>Harga</th>
                                
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            <!-- start row -->
                            @php $no = 1; @endphp
                            @foreach($waste_bank->details as $detail)
                            <tr>
                                
                                <td>{{$no++}}</td>
                                <td>{{ $detail->trashCategory->trc_name ?? 'Tidak ada' }}</td>
                                <td>{{ $detail->berat }}</td>
                                <td>Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                                
                            </tr>
                            @endforeach
                            <!-- end row -->
                            
                        </tbody>
                        <tfoot>
                            <!-- start row -->
                            

                            <tr>
                                <th width="10%"></th>
                                <th></th>
                                <th>Total Harga</th>
                                <th>Rp {{ number_format($waste_bank->wtb_total_money, 0, ',', '.') }}</th>
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
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>
@endpush


<!-- resources/views/wastebank/show.blade.php -->
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Setoran Sampah
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4">Informasi Setoran Sampah</h3>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Kategori Sampah</th>
                            <th class="border px-4 py-2">Berat (kg)</th>
                            <th class="border px-4 py-2">Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($waste_bank->details as $detail)
                            <tr>
                                <td class="border px-4 py-2">{{ $detail->trashCategory->trc_name ?? 'Tidak ada' }}</td>
                                <td class="border px-4 py-2">{{ $detail->berat }}</td>
                                <td class="border px-4 py-2">Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> --}}
