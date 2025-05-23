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

<div class="row">

<div class="col-xl-4 d-flex align-items-stretch" style="padding: 35px">
    <div class="card w-100">
      <div class="card-body p-4">
        <h4 class="card-title fw-semibold">Pembayaran Digital</h4>
        <p class="card-subtitle">Pembayaran Digital Melalui Bank</p>
        <div class="card overflow-hidden mt-9">
          <img src="{{ asset('modernize/assets/images/backgrounds/my-card.jpg')}}" alt="bg-card" height="220">
          <div class="card-img-overlay text-white">
            <div class="d-flex align-items-start flex-column h-100">
              <div>
                <img src="{{ asset('modernize/assets/images/nft/mastercard.png')}}" width="40" alt="mastercard" />
                <span class="opacity-75 fs-2 d-block mt-3">CARD NUMBER</span>
                <h4 class="text-white fw-normal">2500 1520 2315 4500</h4>
              </div>
              <div class="d-flex align-items-center justify-content-between mt-auto w-100">
                <div>
                  <span class="opacity-75 fs-2 text-uppercase">Card Holder Name</span>
                  <h6 class="text-white mb-0">HR John</h6>
                </div>
                <div>
                  <span class="opacity-75 fs-2 text-uppercase">Expires On</span>
                  <h6 class="text-white mb-0">09/25</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h4 class="card-title fw-semibold">Saldo Bank Sampah</h4>
        <p class="card-subtitle">Total Saldo Anda : </p>
        <div class="card shadow-none mb-0">
          <div class="card-body p-0">
            <br>
            <div class="d-flex align-items-center mb-3">
              <h2 class="fw-semibold mb-0">Rp{{ number_format($saldoBankSampah, 0, ',', '.') }}</h2>
              <div class="ms-auto">
              </div>
            </div>
            <button class="btn bg-primary-subtle text-primary w-100 mt-3"> View Balance </button>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="col-xl-8 d-flex align-items-stretch"style="padding: 25px">
    <div class="card w-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <h4 class="card-title fw-semibold">Status Pembayaran</h4>
            <p class="card-subtitle">Status Pembayaran men </p>
          </div>
        </div>
        <div class="card mt-4 mb-0 shadow-none">
          <div class="table-responsive">
            <table class="table align-middle text-nowrap mb-0">
              <thead>
                <tr>
                  <th scope="col">Nama</th>
                  <th scope="col">Kategori Pembayaran</th>
                  <th scope="col">Status</th>
                  <th scope="col">Total</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody class="text-dark ">
              
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
function handleColorTheme(e) {
document.documentElement.setAttribute("data-color-theme", e);
}
</script>

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
