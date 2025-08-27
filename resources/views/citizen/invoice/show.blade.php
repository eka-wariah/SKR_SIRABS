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
                        <h4 class="text-uppercase mb-0">Tagihan Pembayaran Retribusi</h4>
                        <div class="ms-auto">
                            <h4 class="invoice-number">#{{ $invoice->invoice_number }}</h4>
                        </div>
                    </div>
                    <div class="p-3" id="custom-invoice">
                        <div class="invoice-123" id="printableArea">
                            <div class="row pt-3">
                               <div class="col-md-12 d-flex justify-content-between">
                                    <address>
                                        <h6>Dari:</h6>
                                        <h6 class="fw-bold">{{ trim(($invoice->treasurer()?->first_name ?? '') . ' ' . ($invoice->treasurer()?->last_name ?? '')) ?: '-' }}</h6>
                                        @if($treasurer)
    <p>Bendahara RT {{ $treasurer->usr_scope_id }}</p>
@endif
                                        <p>
                                            RW 04 - Sistem Informasi Retribusi<br>
                                            {{-- Email: {{ $payment->treasurer->email ?? '-' }}  --}}
                                        </p>
                                    </address>
                                  </div>
                                  <div class="text-end">
                                    <address class="text-end" style="line-height: 1.4; margin: 0; padding: 0;">
                                        <h6 style="margin-bottom: 2px;">Kepada:</h6>
                                        <h6 class="fw-bold" style="margin-bottom: 4px;">
                                            {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) }}
                                        </h6>
                                        <p style="margin: 0 0 2px;">Anggota keluarga dengan no. KK :</p>
                                        <p style="margin: 0 0 4px;">{{ $household->no_kk }}</p>
                                        <p style="margin: 0 0 8px;">{{ $user->address }}</p>
                                <br>
                                        <p style="margin: 4px 0;">
                                            <span>Pembayaran untuk bulan :</span>
                                            <iconify-icon icon="tabler:calendar-clock" class="menu-icon align-middle me-1" style="font-size: 1.2rem;"></iconify-icon>
                                            {{ \Carbon\Carbon::parse($invoice->periode)->locale('id')->translatedFormat('F Y') }}
                                        </p>
                                        <p style="margin: 4px 0;">
                                            <span>Tanggal Invoice :</span>
                                            <iconify-icon icon="tabler:calendar-month" class="menu-icon align-middle me-1" style="font-size: 1.2rem;"></iconify-icon>
                                            {{ \Carbon\Carbon::parse($invoice->created_at)->locale('id')->translatedFormat('j F Y') }}
                                        </p>
                                        <p style="margin: 4px 0;">
                                            <span>Jatuh Tempo :</span>
                                            <iconify-icon icon="tabler:calendar-clock" class="menu-icon align-middle me-1" style="font-size: 1.2rem;"></iconify-icon>
                                            {{ \Carbon\Carbon::parse($invoice->due_date)->locale('id')->translatedFormat('j F Y') }}
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @php $no = 1; @endphp
                                                <tr>
                                                  <td>{{ $no++ }}</td>
                                                    <td>{{ $invoice->paymentCategory->pym_name ?? '-' }}</td>
                                                    <td>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="col-md-12 mt-4 text-end">
                                            <hr>
                                            <h5 style="font-weight: bold;">
                                                Jumlah yang harus dibayar:
                                                Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-md-12 mt-4 text-end">
                                    {{-- <p><strong>Status Penyerahan Dana:</strong> {{ $payment->pyn_status_submission }}</p> --}}
                                    <hr>
                                    {{-- <h5><b>Total Dibayar:</b> Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</h5> --}}
                                </div>
        
                                <div class="col-md-12 text-end mt-4">
                                    <a href="/citizen/payment" class="btn btn-primary me-2 d-print-none">
                                        <iconify-icon icon="tabler:credit-card-pay" class="menu-icon align-middle me-1" style="font-size: 1.2rem;"></iconify-icon>
                                        Proses Ke Pembayaran
                                      </a>
                                    <button class="btn btn-primary print-page d-print-none" type="button">
                                      <iconify-icon icon="line-md:cloud-down" class="menu-icon align-middle me-1" style="font-size: 1.2rem;"></iconify-icon>
                                      Cetak Bukti
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
