@extends('citizen.master_citizen')

@push('link')
<link rel="stylesheet" href="{{ asset('vuexy/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('modernize/assets/libs/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
@endpush

@section('content')
<div class="body-wrapper mt-4">
  <div class="container-fluid">
    <br>
    {{-- Header Selamat Datang --}}
    <div class="d-flex align-items-center gap-4 mb-4">
      <div class="position-relative">
        <div class="border border-2 border-primary rounded-circle">
          <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('vuexy/assets/img/avatars/16.jpg') }}" class="rounded-circle object-fit-cover" alt="user1" width="60" height="60"/>
        </div>
      </div>
      <div>
        <h3 class="fw-semibold mb-1">Selamat Datang {{ auth()->user()->name }}!</h3>
        @php
          \Carbon\Carbon::setLocale('id');
          $tanggal = \Carbon\Carbon::now();
        @endphp
        <span>Semangat beraktivitas dan jangan lupa membayar retribusi - {{ $tanggal->translatedFormat('d F Y') }}</span>
      </div>
    </div>
<br>

    {{-- Row Utama --}}
    <div class="row">
      
      {{-- KIRI: Air + Profil + Hubungi RT --}}
      <div class="col-lg-6 d-flex flex-column gap-3">
        
        {{-- Profil Singkat --}}
      


        {{-- Status Layanan Air --}}
        <div class="card card-body position-relative" style="background: #fff; border-left: 4px solid #7352ff;">
          <span class="side-stick" style="position:absolute; left:0; top:0; height:100%; width:4px; background:#7352ff;"></span>
          <h5 class="mb-1">Status Layanan Air Bersih</h5>
          <br>
          @if($airRegistration)
            @if($airRegistration->rgw_status == 'Menunggu Verifikasi')
              <p class="mb-0">🚧 Permohonan kamu sedang <strong>menunggu verifikasi</strong> oleh Ketua RT.</p>
              <p class="text-muted small mt-1">
                Hubungi RT melalui 
                <a href="https://wa.me/{{ $airRegistration->verifier?->phone_number ?? '6281234567890' }}" target="_blank">WhatsApp</a> 
                atau 
                <a href="mailto:{{ $airRegistration->verifier?->email ?? 'rt@example.com' }}">email</a>.
              </p>
            @elseif($airRegistration->rgw_status == 'Sedang Proses Pemasangan')
              <p>🔧 Sedang proses <strong>pemasangan</strong>. Harap bersabar 💧</p>
            @elseif($airRegistration->rgw_status == 'Aktif')
              <p>✅ Selamat! Layanan Air kamu <strong>AKTIF</strong>.</p>
            @else
              <p>Status: {{ $airRegistration->rgw_status }}</p>
            @endif
          @else
            <p class="mb-0">Belum daftar layanan air 💧</p>
            <a href="/citizen/water/register" class="btn btn-sm btn-primary mt-2">
              <i class="bi bi-pencil-square me-1"></i> Daftar Sekarang
            </a>
          @endif
        </div>

        @php
        $user = Auth::user();
        $invoices = $invoices ?? collect(); 
    @endphp
    
    <div class="card card-body" style="border-left: 4px solid #28a745;">
        <h5 class="mb-3">Tagihan Retribusi</h5>
    
        @if($invoices->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->periode }}</td>
                                <td>Rp{{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                {{-- <td>
                                    <span class="badge bg-{{ $invoice->status == 'lunas' ? 'success' : ($invoice->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td> --}}
                                <td>{{ $invoice->paymentCategory->pym_name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('citizen.invoices.show', $invoice->inv_id) }}" class="btn btn-sm btn-primary">
                                        Lihat Invoice
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Belum ada tagihan retribusi.</p>
        @endif
    </div>
    
        {{-- Hubungi Ketua RT --}}
        @if($ketuaRT)
        <div class="card card-body position-relative" style="background: #fff; border-left: 4px solid #7352ff;">
          <span class="side-stick" style="position:absolute; left:0; top:0; height:100%; width:4px; background:#7352ff;"></span>
          <h5 class="mb-1">Sebelum mendaftar layanan air bersama,</h5>
          <h5 class="mb-1">Silahkan hubungi Ketua RT Anda</h5>
          <br>
          <p class="mb-1"><strong>Nama:</strong> {{ $ketuaRT->name }}</p>
          <p class="mb-1"><strong>No. HP:</strong> {{ $ketuaRT->phone ?? '-' }}</p>
          <p class="mb-2"><strong>Email:</strong> {{ $ketuaRT->email ?? '-' }}</p>

          @php
            $phone = preg_replace('/[^0-9]/', '', $ketuaRT->phone);
            if (str_starts_with($phone, '0')) $phone = '62' . substr($phone, 1);
          @endphp

          <div class="d-flex flex-wrap gap-2">
            @if($ketuaRT->phone)
              <a href="https://wa.me/{{ $phone }}" target="_blank" class="btn btn-success btn-sm">
                <i class="bi bi-whatsapp"></i> WhatsApp
              </a>
            @endif
            {{-- @if($ketuaRT->email)
              <a href="mailto:{{ $ketuaRT->email }}" class="btn btn-primary btn-sm">
                <i class="bi bi-envelope"></i> Email
              </a>
            @endif --}}
          </div>
        </div>
        @endif
      </div>

      {{-- KANAN: Tabungan Bank Sampah --}}
      <div class="col-lg-6">
        <div class="card text-bg-primary border-0 w-100 h-100">
          <div class="card-body pb-0">
            <h4 class="fw-semibold mb-1 text-white">Tabungan Bank Sampah</h4>
            <p class="fs-3 mb-3 text-white">Tahun {{ date('Y') }}</p>
            <div class="text-center mt-3">
              <img src="{{ asset('vuexy/assets/img/backgrounds/1.png') }}" class="img-fluid" alt="Tabungan" />
            </div>
          </div>
          <div class="card mx-2 mb-2 mt-n2 bg-white text-dark">
            <div class="card-body">
              <h6 class="mb-1 fs-4 fw-semibold">Total Uang yang ditabung</h6>
              <p class="fs-3 mb-3">Rp{{ number_format($saldoBankSampah, 0, ',', '.') }}</p>
              <br>
              <br>
              <h6 class="mb-1 fs-4 fw-semibold">Total Sampah yang diserahkan</h6>
              <p class="fs-3">{{ number_format($totalBeratSampah, 2, ',', '.') }} kg</p>
            </div>
          </div>
        </div>
      </div>

    </div> {{-- End row --}}
  </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('modernize/assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $('.owl-carousel').owlCarousel({
      loop: false,
      margin: 10,
      nav: false,
      dots: true,
      autoplay: false, 
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
