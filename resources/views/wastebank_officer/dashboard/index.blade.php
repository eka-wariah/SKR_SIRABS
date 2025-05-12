@extends('wastebank_officer.master_officer')
@push('link')
<link rel="stylesheet" href="{{ asset('vuexy/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
<div class="body-wrapper mt-4">
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8 d-flex align-items-stretch">
      <div class="card w-100 bg-primary-subtle overflow-hidden shadow-none">
        <div class="card-body position-relative">
          <div class="row">
            <div class="col-sm-7">
              <div class="d-flex align-items-center mb-7">
                <div class="rounded-circle overflow-hidden me-6">
                  <img src="{{ asset('modernize\assets\images\profile\user-1.jpg')}}" alt="modernize-img" width="40" height="40')}}">
                </div>
                <h5 class="fw-semibold mb-0 fs-5">Welcome back Mathew Anderson!</h5>
              </div>
              <div class="d-flex align-items-center">
                <div class="border-end pe-4 border-muted border-opacity-10">
                  <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">$2,340<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
                  </h3>
                  <p class="mb-0 text-dark">Today’s Sales</p>
                </div>
                <div class="ps-4">
                  <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">35%<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
                  </h3>
                  <p class="mb-0 text-dark">Overall Performance</p>
                </div>
              </div>
            </div>
            <div class="col-sm-5">
                <div class="welcome-bg-img mb-n7 text-end">
                  <img src="{{ asset('modernize\assets\images\backgrounds\welcome-bg.svg')}}" alt="modernize-img" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
          </div>
        </div>
      </div>


{{-- <div class="col-xl-7">
<div class="card" style="width: 100%; height: 250px;">
  <div class="d-flex align-items-end row">
      <div class="col-7">
          <div class="card-body text-nowrap">
              <h5 class="card-title mb-0">Selamat Datang<span class="h4"> {{ Auth::user()->name }}  👋🏻</span></h5>
              <br>
              <p class="mb-2">Terima kasih telah aktif memantau kegiatan dan pelayanan warga di lingkungan Anda.</p>
              <p class="mb-2">Mari bersama wujudkan lingkungan yang bersih, sehat, dan tertib.</p>
              <h4 class="text-primary mb-1">$48.9k</h4>
              <a href="javascript:;" class="btn btn-primary">View Sales</a>
          </div>
      </div>
      <div class="col-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
              <img
                  src="{{asset ('vuexy/assets/img/illustrations/card-advance-sale.png')}}"
                  height="140"
                  alt="view sales" />
          </div>
      </div>
  </div>
</div>
</div> --}}

    @endsection
@push('script')
<script src="{{ asset('vuexy\assets\js\tables-datatables-advanced.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="{{ asset('modernize/assets/js/dashboards/dashboard2.js')}}"></script>

<script src="{{ asset('vuexy\assets/js/datatable/datatable-advanced.init.js') }}"></script>
<script>
    function handleColorTheme(e) {
      document.documentElement.setAttribute("data-color-theme", e);
    }
  </script>
@endpush
