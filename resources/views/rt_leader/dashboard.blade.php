@extends('rt_leader.master_rt-leader')

@push('link')
<link rel="stylesheet" href="{{ asset('vuexy/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
@endpush

@section('content')
<div class="body-wrapper mt-4">
  <div class="container-fluid">
    <div class="d-flex align-items-center gap-4 mb-4">
      <div class="position-relative">
        <div class="border border-2 border-primary rounded-circle">
          <img src="{{ asset('modernize/assets/images/profile/user-1.jpg') }}" class="rounded-circle m-1" alt="user1" width="60" />
        </div>
      </div>
      <div>
        <h3 class="fw-semibold">Selamat Datang {{ auth()->user()->name }}!</h3>
        @php
        \Carbon\Carbon::setLocale('id');
        $tanggal = \Carbon\Carbon::now();
        @endphp
        <span>Semangat beraktivitas - {{ $tanggal->translatedFormat('d F Y') }}</span>
      </div>
    </div>

    <div class="owl-carousel counter-carousel owl-theme mt-4">
      <div class="item">
        <div class="card border-0 zoom-in bg-primary-subtle shadow-none">
          <div class="card-body text-center">
            <img src="{{ asset('modernize/assets/images/svgs/icon-user-male.svg') }}" width="50" height="50" class="mb-3" alt="icon" />
            <p class="fw-semibold fs-3 text-primary mb-1">Employees</p>
            <h5 class="fw-semibold text-primary mb-0">96</h5>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
          <div class="card-body text-center">
            <img src="{{ asset('modernize/assets/images/svgs/icon-briefcase.svg') }}" width="50" height="50" class="mb-3" alt="icon" />
            <p class="fw-semibold fs-3 text-warning mb-1">Clients</p>
            <h5 class="fw-semibold text-warning mb-0">3,650</h5>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="card border-0 zoom-in bg-info-subtle shadow-none">
          <div class="card-body text-center">
            <img src="{{ asset('modernize/assets/images/svgs/icon-mailbox.svg') }}" width="50" height="50" class="mb-3" alt="icon" />
            <p class="fw-semibold fs-3 text-info mb-1">Projects</p>
            <h5 class="fw-semibold text-info mb-0">356</h5>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="card border-0 zoom-in bg-danger-subtle shadow-none">
          <div class="card-body text-center">
            <img src="{{ asset('modernize/assets/images/svgs/icon-favorites.svg') }}" width="50" height="50" class="mb-3" alt="icon" />
            <p class="fw-semibold fs-3 text-danger mb-1">Events</p>
            <h5 class="fw-semibold text-danger mb-0">696</h5>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="card border-0 zoom-in bg-primary-subtle shadow-none">
          <div class="card-body text-center">
            <img src="{{ asset('modernize/assets/images/svgs/icon-user-male.svg') }}" width="50" height="50" class="mb-3" alt="icon" />
            <p class="fw-semibold fs-3 text-primary mb-1">Jumlah Warga</p>
            <h5 class="fw-semibold text-primary mb-0">{{ $jumlahWarga }}</h5>
          </div>
        </div>
      </div>
      
      <div class="item">
        <div class="card border-0 zoom-in bg-info-subtle shadow-none">
          <div class="card-body text-center">
            <img src="{{ asset('modernize/assets/images/svgs/icon-home.svg') }}" width="50" height="50" class="mb-3" alt="icon" />
            <p class="fw-semibold fs-3 text-info mb-1">Jumlah KK</p>
            <h5 class="fw-semibold text-info mb-0">{{ $jumlahKK }}</h5>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="card border-0 zoom-in bg-success-subtle shadow-none">
          <div class="card-body text-center">
            <img src="{{ asset('modernize/assets/images/svgs/icon-speech-bubble.svg') }}" width="50" height="50" class="mb-3" alt="icon" />
            <p class="fw-semibold fs-3 text-success mb-1">Payroll</p>
            <h5 class="fw-semibold text-success mb-0">$96k</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('modernize/assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 10,
      nav: false,
      dots: true,
      autoplay: true,
      autoplayTimeout: 3000,
      responsive: {
        0: { items: 1 },
        576: { items: 2 },
        768: { items: 3 },
        992: { items: 4 },
        1200: { items: 5 }
      }
    });
  });
</script>
@endpush
