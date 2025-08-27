<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="shortcut icon" type="image/png" href="{{ asset('modernize/assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css') }}" />

  <title>Akun Belum Diverifikasi</title>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="{{ asset('modernize/assets/images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
  </div>

  <div id="main-wrapper">
    <div class="position-relative overflow-hidden min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-lg-5 col-md-8">
            <div class="text-center">
              <h2 class="fw-semibold mb-3">Akun Belum Diverifikasi 👋</h2>
              <p class="mb-4 text-muted">
                Terima kasih telah mendaftar. Akun Anda sedang menunggu verifikasi dari Ketua RT.
                <br>Silakan kembali beberapa saat lagi.
              </p>
              <img src="{{ asset('modernize/assets/images/backgrounds/verifikasi.png') }}" alt="Verifikasi Ilustrasi" class="img-fluid mb-4" style="max-width: 400px;">
             
             

              @if(session('status'))
                <div class="alert alert-warning">
                  {{ session('status') }}
                </div>
              @endif

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-primary w-100">Kembali</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('modernize/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('modernize/assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
  <script src="{{ asset('modernize/assets/js/theme/app.init.js') }}"></script>
  <script src="{{ asset('modernize/assets/js/theme/theme.js') }}"></script>
  <script src="{{ asset('modernize/assets/js/theme/app.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
