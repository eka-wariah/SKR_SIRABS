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
          <div class="d-flex justify-content-center align-items-start min-vh-100 py-5">
          <div class="chat-container w-75 w-xs-100">
            <div class="invoice-inner-part h-100">
                <div class="invoiceing-box">
                    <div class="invoice-header d-flex align-items-center border-bottom p-3">
                        <h4 class="text-uppercase mb-0">Bukti Pembayaran</h4>
                        <div class="ms-auto">
                            <h4 class="invoice-number">#INV{{ $payment->pyn_id }}</h4>
                        </div>
                    </div>
                    <div class="p-3" id="custom-invoice">
                        <div class="invoice-123" id="printableArea">
                            <div class="row pt-3">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <address>
                                        <h6>Dari:</h6>
                                        <h6 class="fw-bold">{{ $payment->treasurer->name ?? '-' }}</h6>
                                        <p class="ms-1">
                                            RW 04 - Sistem Informasi Retribusi<br>
                                            Email: {{ $payment->treasurer->email ?? '-' }}
                                        </p>
                                    </address>
                                  </div>
                                  <div class="text-end">
                                    <address class="text-end">
                                        <h6>Kepada:</h6>
                                        <h6 class="fw-bold">{{ $user->name }}</h6>
                                        {{-- <p class="ms-1">
                                            NIK: {{ $user->nik ?? '-' }}<br>
                                            No. KK: {{ $user->household->no_kk ?? '-' }}
                                        </p> --}}
                                        <p class="mt-2 mb-1">
                                            <strong>Tanggal Pembayaran:</strong>
                                            {{ \Carbon\Carbon::parse($payment->created_at)->format('d-m-Y H:i') }}
                                        </p>
                                        <p>
                                            <strong>Periode:</strong> {{ $payment->pyn_periode }}
                                        </p>
                                    </address>
                                </div>
        
                                <div class="col-md-12 mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kategori Pembayaran</th>
                                                    <th>Jumlah</th>
                                                    <th>Metode</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @php $no = 1; @endphp
                                                <tr>
                                                  <td>{{ $no++ }}</td>
                                                    <td>{{ $payment->paymentCategory->pym_name ?? '-' }}</td>
                                                    <td>Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                                                    <td class="text-capitalize">{{ str_replace('_', ' ', $payment->metode_bayar) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $payment->status == 'lunas' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($payment->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
        
                                <div class="col-md-12 mt-4 text-end">
                                    {{-- <p><strong>Status Penyerahan Dana:</strong> {{ $payment->pyn_status_submission }}</p> --}}
                                    <hr>
                                    <h5><b>Total Dibayar:</b> Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</h5>
                                </div>
        
                                <div class="col-md-12 text-end mt-4">
                                  <a href="/citizen/payment" class="btn btn-primary me-2 d-print-none">
                                    <i class="ti ti-arrow-left"></i> Kembali ke Beranda
                                  </a>
                                    <button class="btn btn-primary print-page d-print-none" type="button">
                                        <i class="ti ti-printer fs-5"></i> Cetak Bukti
                                    </button>
                                   
                                </div>


                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
            

           
@endsection



@push('script')
<script>
    function handleColorTheme(e) {
      document.documentElement.setAttribute("data-color-theme", e);
    }
  </script>
    <script src="{{ asset('modernize/assets/js/vendor.min.js')}}"></script>
    <!-- Import Js Files -->
    <script src="{{ asset('modernize/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('modernize/assets/libs/simplebar/dist/simplebar.min.js')}}"></script>
    <script src="{{ asset('modernize/assets/js/theme/app.init.js')}}"></script>
    <script src="{{ asset('modernize/assets/js/theme/theme.js')}}"></script>
    <script src="{{ asset('modernize/assets/js/theme/app.min.js')}}"></script>
    <script src="{{ asset('modernize/assets/js/theme/sidebarmenu.js')}}"></script>
  
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('modernize/assets/libs/fullcalendar/index.global.min.js')}}"></script>
    <script src="{{ asset('modernize/assets/js/apps/invoice.js')}}"></script>
    <script src="{{ asset('modernize/assets/js/apps/jquery.PrintArea.js')}}"></script>
@endpush