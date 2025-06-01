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

  <div class="row justify-content-center">
<div class="col-xl-4 d-flex align-items-stretch" style="padding: 35px">
    <div class="card w-100">
      <div class="card-body p-4">
        <h4 class="card-title fw-semibold">Pembayaran Digital</h4>
        <p class="card-subtitle">Pembayaran Digital Melalui Bank</p>
        <div class="card overflow-hidden mt-9">
          <img src="{{ asset('modernize/assets/images/backgrounds/payment.svg')}}" alt="bg-card" height="220">
          <div class="card-img-overlay text-white">
            <div class="d-flex align-items-start flex-column h-100">
              <div>
                {{-- <img src="{{ asset('modernize/assets/images/nft/mastercard.png')}}" width="40" alt="mastercard" />
                <span class="opacity-75 fs-2 d-block mt-3">CARD NUMBER</span>
                <h4 class="text-white fw-normal">2500 1520 2315 4500</h4> --}}
              </div>
              <div class="d-flex align-items-center justify-content-between mt-auto w-100">
                {{-- <div>
                  <span class="opacity-75 fs-2 text-uppercase">Card Holder Name</span>
                  <h6 class="text-white mb-0">{{ auth()->user()->name }}</h6>
                </div>
                <div>
                  <span class="opacity-75 fs-2 text-uppercase">Expires On</span>
                  <h6 class="text-white mb-0">09/25</h6>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
        <div class="card shadow-none mb-0">
          <div class="card-body p-0">
            <button class="btn bg-primary-subtle text-primary w-100 mt-3"> View Balance </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4 d-flex align-items-stretch" style="padding: 35px">
    <div class="card w-100">
      <div class="card-body p-4">
        <h4 class="card-title fw-semibold">Saldo Bank Sampah</h4>
        <p class="card-subtitle">Pembayaran Melalui Saldo Bank Sampah</p>
        <div class="card overflow-hidden mt-3">
          <img src="{{ asset('modernize/assets/images/backgrounds/my-card1.png')}}" alt="bg-card" height="220">
          <div class="card-img-overlay text-white">
            <div class="d-flex align-items-start flex-column h-100">
              <div>
                {{-- <img src="{{ asset('modernize/assets/images/nft/mastercard.png')}}" width="40" alt="mastercard" /> --}}
                {{-- <span class="opacity-75 fs-2 d-block mt-3">CARD NUMBER</span>
                <h4 class="text-white fw-normal">2500 1520 2315 4500</h4> --}}
              </div>
              <div class="d-flex align-items-center justify-content-between mt-auto w-100">
                 <div>
                  <span class="opacity-75 fs-2 text-uppercase">Saldo Anda :</span>
                  <h6 class="text-black mb-0">Rp{{ number_format($saldoBankSampah, 0, ',', '.') }}</h6>
                </div>
                {{--<div>
                  <span class="opacity-75 fs-2 text-uppercase">Expires On</span>
                  <h6 class="text-white mb-0">09/25</h6>
                </div> --}}
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow-none mb-0">
          <div class="card-body p-6">
            @if($saldoBankSampah >= $biayaYangDibutuhkan)
              <a href="/citizen/payment/create_via_Waste_Bank" class="btn bg-primary-subtle text-primary w-100 mt-1"> View Balance</a>
            @else
              <button class="btn bg-primary-subtle text-primary w-100 mt-1" disabled>Saldo Tidak Cukup</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="col-xl-20 d-flex align-items-stretch" style="padding: 35px;">
    <div class="card w-100 shadow-sm rounded-4">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <div>
            <h4 class="card-title fw-semibold mb-1">Menunggu Pembayaran</h4>
            <p class="card-subtitle text-muted small">Pembayaran yang prosesnya belum selesai</p>
          </div>
        </div>
  
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle text-nowrap mb-0">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori Pembayaran</th>
                <th>Status</th>
                <th>Total</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pendingPayments as $no=> $payment)
              <tr>
                <td>{{$no+1}}</td>
                <td>{{$payment->user->name}}</td>
                <td>{{$payment->paymentCategory->pym_name }}</td>
                <td>{{$payment->status }}</td>
                <td>Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                  <td>
                       <a href="/citizen/payment/create_via_Bank/{{ $payment->pyn_id}}" class="btn btn-danger">lanjut pembayaran</a> 
                  </td>                 
              </tr>
              @endforeach
            </tbody>
          </table>
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
