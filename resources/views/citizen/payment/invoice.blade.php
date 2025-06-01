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
    
        {{-- <div class="container">
            <table>
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead>
                        <!-- start row -->
                        <tr>
                            <th>Nama</th>
                            <th>Kategori Pembayaran</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Metode</th>
                            <th>Bendahara</th>
                            <th>Status</th>
                            
                        </tr>
                        <!-- end row -->
                    </thead>
                    <tbody>
                        <!-- start row -->
                        <tr>
                            
                            <td>{{$payment->user->name}}</td>
                            <td>{{$payment->paymentCategory->pym_name }}</td>
                            <td>Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->pyn_created_at)->format('d-m-Y H:i') }}</td>
                            <td>{{$payment->metode_bayar}}</td>
                            <td>{{$payment->treasurer->name}}</td>
                            <td>{{$payment->status}}</td>
                        

                            
                        </tr>
                        <!-- end row --> 
                        
                    </tbody>
            </table>
        </div> --}}
        {{-- <div class="body-wrapper">
            <div class="container-fluid">
            <div class="invoice-inner-part h-100">
              <div class="invoiceing-box">
                <div class="invoice-header d-flex align-items-center border-bottom p-3">
                  <h4 class=" text-uppercase mb-0">Invoice</h4>
                  <div class="ms-auto">
                    <h4 class="invoice-number"></h4>
                  </div>
                </div>
                <div class="p-3" id="custom-invoice">
                  <div class="invoice-123" id="printableArea">
                    <div class="row pt-3">
                      <div class="col-md-12">
                        <div>
                          <address>
                            <h6>&nbsp;From,</h6>
                            <h6 class="fw-bold">&nbsp;{{$payment->user->name}}</h6>
                          </address>
                        </div>
                        <div class="text-end">
                          <address>
                            <h6>To,</h6>
                            <h6 class="fw-bold invoice-customer">
                                {{$payment->treasurer->name}}
                            </h6>
                            <p class="mt-4 mb-1">
                              <span>Invoice Date :</span>
                              <i class="ti ti-calendar"></i>
                              23rd Jan 2021
                            </p>
                            <p>
                              <span>Due Date :</span>
                              <i class="ti ti-calendar"></i>
                              25th Jan 2021
                            </p>
                          </address>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="table-responsive mt-5">
                          <table class="table table-hover">
                            <thead>
                              <!-- start row -->
                              <tr>
                                <th class="text-center">#</th>
                                <th>Description</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Unit Cost</th>
                                <th class="text-end">Total</th>
                              </tr>
                              <!-- end row -->
                            </thead>
                            <tbody>
                              <!-- start row -->
                              <tr>
                                <td class="text-center">1</td>
                                <td>Milk Powder</td>
                                <td class="text-end">2</td>
                                <td class="text-end">$24</td>
                                <td class="text-end">$48</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">2</td>
                                <td>Air Conditioner</td>
                                <td class="text-end">5</td>
                                <td class="text-end">$500</td>
                                <td class="text-end">$2500</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">3</td>
                                <td>RC Cars</td>
                                <td class="text-end">30</td>
                                <td class="text-end">$600</td>
                                <td class="text-end">$18000</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">4</td>
                                <td>Down Coat</td>
                                <td class="text-end">62</td>
                                <td class="text-end">$5</td>
                                <td class="text-end">$310</td>
                              </tr>
                              <!-- end row -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right mt-4 text-end">
                          <p>Sub - Total amount: $20,858</p>
                          <p>vat (10%) : $2,085</p>
                          <hr />
                          <h3>
                            <b>Total :</b> $22,943
                          </h3>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="text-end">
                          <button class="btn bg-danger-subtle text-danger" type="submit">
                            Proceed to payment
                          </button>
                          <button class="btn btn-primary btn-default print-page ms-6" type="button">
                            <span>
                              <i class="ti ti-printer fs-5"></i>
                              Print
                            </span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- 2 -->
                  <div class="invoice-124" id="printableArea">
                    <div class="row pt-3">
                      <div class="col-md-12">
                        <div>
                          <address>
                            <h6>&nbsp;From,</h6>
                            <h6 class="fw-bold">&nbsp;Steve Jobs</h6>
                            <p class="ms-1">
                              1108, Clair Street,
                              <br />Massachusetts,
                              <br />Woods Hole - 02543
                            </p>
                          </address>
                        </div>
                        <div class="text-end">
                          <address>
                            <h6>To,</h6>
                            <h6 class="fw-bold invoice-customer">
                              Bianca Doe,
                            </h6>
                            <p class="ms-4">
                              455, Shobe Lane,
                              <br />Colorado,
                              <br />Fort
                              Collins - 80524
                            </p>
                            <p class="mt-4 mb-1">
                              <span>Invoice Date :</span>
                              <i class="ti ti-calendar"></i>
                              23rd Jan 2021
                            </p>
                            <p>
                              <span>Due Date :</span>
                              <i class="ti ti-calendar"></i>
                              25th Jan 2021
                            </p>
                          </address>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="table-responsive mt-5">
                          <table class="table table-hover">
                            <thead>
                              <!-- start row -->
                              <tr>
                                <th class="text-center">#</th>
                                <th>Description</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Unit Cost</th>
                                <th class="text-end">Total</th>
                              </tr>
                              <!-- end row -->
                            </thead>
                            <tbody>
                              <!-- start row -->
                              <tr>
                                <td class="text-center">1</td>
                                <td>Milk Powder</td>
                                <td class="text-end">2</td>
                                <td class="text-end">$24</td>
                                <td class="text-end">$48</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">2</td>
                                <td>Air Conditioner</td>
                                <td class="text-end">5</td>
                                <td class="text-end">$500</td>
                                <td class="text-end">$2500</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">3</td>
                                <td>RC Cars</td>
                                <td class="text-end">30</td>
                                <td class="text-end">$600</td>
                                <td class="text-end">$18000</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">4</td>
                                <td>Down Coat</td>
                                <td class="text-end">62</td>
                                <td class="text-end">$5</td>
                                <td class="text-end">$310</td>
                              </tr>
                              <!-- end row -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right mt-4 text-end">
                          <p>Sub - Total amount: $20,858</p>
                          <p>vat (10%) : $2,085</p>
                          <hr />
                          <h3>
                            <b>Total :</b> $22,943
                          </h3>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="text-end">
                          <button class="btn bg-danger-subtle text-danger" type="submit">
                            Proceed to payment
                          </button>
                          <button class="btn btn-primary btn-default print-page ms-6" type="button">
                            <span>
                              <i class="ti ti-printer fs-5"></i>
                              Print
                            </span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- 3 -->
                  <div class="invoice-125" id="printableArea">
                    <div class="row pt-3">
                      <div class="col-md-12">
                        <div>
                          <address>
                            <h6>&nbsp;From,</h6>
                            <h6 class="fw-bold">&nbsp;Steve Jobs</h6>
                            <p class="ms-1">
                              1108, Clair Street,
                              <br />Massachusetts,
                              <br />Woods Hole - 02543
                            </p>
                          </address>
                        </div>
                        <div class="text-end">
                          <address>
                            <h6>To,</h6>
                            <h6 class="fw-bold invoice-customer">
                              Angelina Rhodes,
                            </h6>
                            <p class="ms-4">
                              455, Shobe Lane,
                              <br />Colorado,
                              <br />Fort
                              Collins - 80524
                            </p>
                            <p class="mt-4 mb-1">
                              <span>Invoice Date :</span>
                              <i class="ti ti-calendar"></i>
                              23rd Jan 2021
                            </p>
                            <p>
                              <span>Due Date :</span>
                              <i class="ti ti-calendar"></i>
                              25th Jan 2021
                            </p>
                          </address>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="table-responsive mt-5">
                          <table class="table table-hover">
                            <thead>
                              <!-- start row -->
                              <tr>
                                <th class="text-center">#</th>
                                <th>Description</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Unit Cost</th>
                                <th class="text-end">Total</th>
                              </tr>
                              <!-- end row -->
                            </thead>
                            <tbody>
                              <!-- start row -->
                              <tr>
                                <td class="text-center">1</td>
                                <td>Milk Powder</td>
                                <td class="text-end">2</td>
                                <td class="text-end">$24</td>
                                <td class="text-end">$48</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">2</td>
                                <td>Air Conditioner</td>
                                <td class="text-end">5</td>
                                <td class="text-end">$500</td>
                                <td class="text-end">$2500</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">3</td>
                                <td>RC Cars</td>
                                <td class="text-end">30</td>
                                <td class="text-end">$600</td>
                                <td class="text-end">$18000</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">4</td>
                                <td>Down Coat</td>
                                <td class="text-end">62</td>
                                <td class="text-end">$5</td>
                                <td class="text-end">$310</td>
                              </tr>
                              <!-- end row -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right mt-4 text-end">
                          <p>Sub - Total amount: $20,858</p>
                          <p>vat (10%) : $2,085</p>
                          <hr />
                          <h3>
                            <b>Total :</b> $22,943
                          </h3>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="text-end">
                          <button class="btn bg-danger-subtle text-danger" type="submit">
                            Proceed to payment
                          </button>
                          <button class="btn btn-primary btn-default print-page ms-6" type="button">
                            <span>
                              <i class="ti ti-printer fs-5"></i>
                              Print
                            </span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- 4 -->
                  <div class="invoice-126" id="printableArea">
                    <div class="row pt-3">
                      <div class="col-md-12">
                        <div>
                          <address>
                            <h6>&nbsp;From,</h6>
                            <h6 class="fw-bold">&nbsp;Steve Jobs</h6>
                            <p class="ms-1">
                              1108, Clair Street,
                              <br />Massachusetts,
                              <br />Woods Hole - 02543
                            </p>
                          </address>
                        </div>
                        <div class="text-end">
                          <address>
                            <h6>To,</h6>
                            <h6 class="fw-bold invoice-customer">
                              Samuel Smith,
                            </h6>
                            <p class="ms-4">
                              455, Shobe Lane,
                              <br />Colorado,
                              <br />Fort
                              Collins - 80524
                            </p>
                            <p class="mt-4 mb-1">
                              <span>Invoice Date :</span>
                              <i class="ti ti-calendar"></i>
                              23rd Jan 2021
                            </p>
                            <p>
                              <span>Due Date :</span>
                              <i class="ti ti-calendar"></i>
                              25th Jan 2021
                            </p>
                          </address>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="table-responsive mt-5">
                          <table class="table table-hover">
                            <thead>
                              <!-- start row -->
                              <tr>
                                <th class="text-center">#</th>
                                <th>Description</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Unit Cost</th>
                                <th class="text-end">Total</th>
                              </tr>
                              <!-- end row -->
                            </thead>
                            <tbody>
                              <!-- start row -->
                              <tr>
                                <td class="text-center">1</td>
                                <td>Milk Powder</td>
                                <td class="text-end">2</td>
                                <td class="text-end">$24</td>
                                <td class="text-end">$48</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">2</td>
                                <td>Air Conditioner</td>
                                <td class="text-end">5</td>
                                <td class="text-end">$500</td>
                                <td class="text-end">$2500</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">3</td>
                                <td>RC Cars</td>
                                <td class="text-end">30</td>
                                <td class="text-end">$600</td>
                                <td class="text-end">$18000</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">4</td>
                                <td>Down Coat</td>
                                <td class="text-end">62</td>
                                <td class="text-end">$5</td>
                                <td class="text-end">$310</td>
                              </tr>
                              <!-- end row -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right mt-4 text-end">
                          <p>Sub - Total amount: $20,858</p>
                          <p>vat (10%) : $2,085</p>
                          <hr />
                          <h3>
                            <b>Total :</b> $22,943
                          </h3>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="text-end">
                          <button class="btn bg-danger-subtle text-danger" type="submit">
                            Proceed to payment
                          </button>
                          <button class="btn btn-primary btn-default print-page ms-6" type="button">
                            <span>
                              <i class="ti ti-printer fs-5"></i>
                              Print
                            </span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- 5 -->
                  <div class="invoice-127" id="printableArea">
                    <div class="row pt-3">
                      <div class="col-md-12">
                        <div>
                          <address>
                            <h6>&nbsp;From,</h6>
                            <h6 class="fw-bold">&nbsp;Steve Jobs</h6>
                            <p class="ms-1">
                              1108, Clair Street,
                              <br />Massachusetts,
                              <br />Woods Hole - 02543
                            </p>
                          </address>
                        </div>
                        <div class="text-end">
                          <address>
                            <h6>To,</h6>
                            <h6 class="fw-bold invoice-customer">
                              Gabriel Jobs,
                            </h6>
                            <p class="ms-4">
                              455, Shobe Lane,
                              <br />Colorado,
                              <br />Fort
                              Collins - 80524
                            </p>
                            <p class="mt-4 mb-1">
                              <span>Invoice Date :</span>
                              <i class="ti ti-calendar"></i>
                              23rd Jan 2021
                            </p>
                            <p>
                              <span>Due Date :</span>
                              <i class="ti ti-calendar"></i>
                              25th Jan 2021
                            </p>
                          </address>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="table-responsive mt-5">
                          <table class="table table-hover">
                            <thead>
                              <!-- start row -->
                              <tr>
                                <th class="text-center">#</th>
                                <th>Description</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Unit Cost</th>
                                <th class="text-end">Total</th>
                              </tr>
                              <!-- end row -->
                            </thead>
                            <tbody>
                              <!-- start row -->
                              <tr>
                                <td class="text-center">1</td>
                                <td>Milk Powder</td>
                                <td class="text-end">2</td>
                                <td class="text-end">$24</td>
                                <td class="text-end">$48</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">2</td>
                                <td>Air Conditioner</td>
                                <td class="text-end">5</td>
                                <td class="text-end">$500</td>
                                <td class="text-end">$2500</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">3</td>
                                <td>RC Cars</td>
                                <td class="text-end">30</td>
                                <td class="text-end">$600</td>
                                <td class="text-end">$18000</td>
                              </tr>
                              <!-- end row -->
                              <!-- start row -->
                              <tr>
                                <td class="text-center">4</td>
                                <td>Down Coat</td>
                                <td class="text-end">62</td>
                                <td class="text-end">$5</td>
                                <td class="text-end">$310</td>
                              </tr>
                              <!-- end row -->
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right mt-4 text-end">
                          <p>Sub - Total amount: $20,858</p>
                          <p>vat (10%) : $2,085</p>
                          <hr />
                          <h3>
                            <b>Total :</b> $22,943
                          </h3>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="text-end">
                          <button class="btn bg-danger-subtle text-danger" type="submit">
                            Proceed to payment
                          </button>
                          <button class="btn btn-primary btn-default print-page ms-6" type="button">
                            <span>
                              <i class="ti ti-printer fs-5"></i>
                              Print
                            </span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> --}}
        <div class="container py-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-8">
                <div class="card shadow-sm border-0">
                  <div class="card-body p-5 text-center">
                    <div class="mb-4">
                      <i class="ti ti-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="mb-3 text-success">Pembayaran Berhasil!</h2>
                    <p class="mb-4 fs-5">
                      Terima kasih {{ $user->name }}, pembayaran Anda telah kami terima dan diproses.<br>
                      Invoice Anda sudah berstatus <strong>Lunas</strong>.
                    </p>
          
                    {{-- Tabel detail pembayaran --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-nowrap mb-0">
                          <thead class="table-light">
                          <tr>
                            <th>Kategori Pembayaran</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{ $payment->paymentCategory->pym_name }}</td>
                            <td>Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($payment->pyn_created_at)->format('d-m-Y H:i') }}</td>
                            <td><span class="badge bg-success">{{ ucfirst($payment->status) }}</span></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
          
                    {{-- Tombol aksi --}}
                    <a href="/citizen/payment" class="btn btn-primary me-2">
                      <i class="ti ti-arrow-left"></i> Kembali ke Beranda
                    </a>
          {{--
                    <a href="{{ route('invoice.show', $payment->pyn_id) }}" class="btn btn-outline-primary">
                      Lihat Detail Invoice
                    </a> --}}
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