<!doctype html>
<html lang="en" class="layout-wide customizer-hide" dir="ltr" data-skin="default" data-assets-path="{{ asset('vuexy/assets/') }}" data-template="vertical-menu-template" data-bs-theme="light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Register Warga - Multi Step | Vuexy</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('vuexy/assets/img/favicon/favicon.ico')}}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/css/core.css')}}" />
  <link rel="stylesheet" href="{{ asset('vuexy/assets/css/demo.css')}}" />
  <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />
  <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/fonts/iconify-icons.css')}}" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/css/pages/page-auth.css')}}" />
  <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />

  <!-- Helpers -->
  <script src="{{ asset('vuexy/assets/vendor/js/helpers.js')}}"></script>
  <script src="{{ asset('vuexy/assets/js/config.js')}}"></script>
</head>

<body>
  <div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row">
      <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-center p-5">
        <img src="{{ asset('modernize/assets/images/backgrounds/regis.png') }}" alt="auth" width="280" />
      </div>
      <div class="d-flex col-lg-8 align-items-center justify-content-center authentication-bg p-5">
        <div class="w-px-700">
          <div id="multiStepsValidation" class="bs-stepper">
            <!-- Header Stepper -->
            <div class="bs-stepper-header">
              <div class="step" data-target="#step1">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle">1</span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Akun</span>
                    <span class="bs-stepper-subtitle">Data Login</span>
                  </span>
                </button>
              </div>
              <div class="line"></div>
              <div class="step" data-target="#step2">
                <button type="button" class="step-trigger">
                  <span class="bs-stepper-circle">2</span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Data Diri</span>
                    <span class="bs-stepper-subtitle">Informasi Pribadi</span>
                  </span>
                </button>
              </div>
            </div>

            <!-- Content Stepper -->
            <div class="bs-stepper-content">
              @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Ups!</strong> Ada kesalahan pada input Anda:
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
              <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Step 1 -->
                <div id="step1" class="content">
                  <div class="row">
                    <div class="col-sm-6 mb-3">
                      <label class="form-label">Username</label>
                      <input 
                        id="name"
                        type="text"
                        name="name"
                        placeholder="Contoh: kaa_123"
                        value="{{ old('name') }}"
                        class="form-control"
                        required
                        pattern="^(?!.*[_.]{2})(?![_.])[a-zA-Z0-9._]{4,20}(?<![_.])$"
                        title="Username harus 4-20 karakter, hanya huruf, angka, titik, atau underscore. Tidak diawali/diaakhiri titik/underscore dan tidak boleh berurutan." 
                      />
                      <div id="name-error" class="text-danger mt-1"></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" value="{{ old('email') }}" class="form-control" required />
                    </div>
                    <div class="col-sm-6 form-password-toggle form-control-validation">
                      <label class="form-label" for="password">Password</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="password"
                          id="password"
                          name="password"
                          class="form-control"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                          aria-describedby="toggle-password" />
                        <span class="input-group-text cursor-pointer" id="toggle-password">
                          <i class="icon-base ti tabler-eye-off"></i>
                        </span>
                      </div>
                    </div>
                    <div class="col-sm-6 form-password-toggle form-control-validation">
                      <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="password"
                          id="password_confirmation"
                          name="password_confirmation"
                          class="form-control"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                          aria-describedby="toggle-password-confirm" />
                        <span class="input-group-text cursor-pointer" id="toggle-password-confirm">
                          <i class="icon-base ti tabler-eye-off"></i>
                        </span>
                      </div>
                      <div id="password-error" class="text-danger mt-1"></div>
                    </div>
                    
                  </div>
                  <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary btn-next">Selanjutnya</button>
                  </div>
                </div>

                <!-- Step 2 -->
                <div id="step2" class="content">
                  <div class="row">
                    <div class="col-sm-6 mb-3">
                      <label class="form-label">Nomor KK</label>
                      <input type="text"
                             name="no_kk"
                             value="{{ old('no_kk') }}"
                             class="form-control"
                             inputmode="numeric"
                             pattern="[0-9]*"
                             maxlength="16"
                             oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)"
                             required />
                             @error('no_kk')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
  @enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                      <label class="form-label">NIK</label>
                      <input type="text"
                             name="nik"
                             value="{{ old('nik') }}"
                             class="form-control"
                             inputmode="numeric"
                             pattern="[0-9]*"
                             maxlength="16"
                             oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)"
                             required />
                    </div>
                    <div class="col-sm-6 mb-3">
                      <label class="form-label">Nama Depan</label>
                      <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" required />
                    </div>
                    <div class="col-sm-6 mb-3">
                      <label class="form-label">Nama Belakang</label>
                      <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" />
                    </div>
                    <div class="col-sm-6 mb-3">
                      <label class="form-label">Nomor HP</label>
                      <div class="input-group">
                        <span class="input-group-text">+62</span>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="form-control"
                               inputmode="numeric"
                               pattern="[0-9]*"
                               maxlength="16"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)"
                               required />
                      </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                      <label class="form-label">Pilih RT</label>
                      <select name="usr_scope_id" class="form-select" required>
                        <option value="">-- Pilih RT --</option>
                        @foreach ($areaScopes as $area)
                          <option value="{{ $area->asc_id }}">{{ $area->asc_level }} {{ $area->asc_number }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-12 mb-3">
                      <label class="form-label">Alamat Lengkap</label>
                      <textarea name="address" rows="3" class="form-control" required>{{ old('address') }}</textarea>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary btn-prev">Sebelumnya</button>
                    <button type="submit" class="btn btn-success">Daftar</button>
                  </div>
                </div>
                <p class="text-center">
                  <span>Apakah sudah memiliki akun?</span>
                  <a href="/login">
                    <span>Login</span>
                  </a>
                </p>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS Dependencies -->
  <script src="{{ asset('vuexy/assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('vuexy/assets/vendor/libs/bootstrap/bootstrap.js') }}"></script>
  <script src="{{ asset('vuexy/assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggles = document.querySelectorAll('.input-group-text.cursor-pointer');
  
      toggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
          const input = this.parentElement.querySelector('input');
          const icon = this.querySelector('i');
  
          if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('tabler-eye-off');
            icon.classList.add('tabler-eye');
          } else {
            input.type = 'password';
            icon.classList.remove('tabler-eye');
            icon.classList.add('tabler-eye-off');
          }
        });
      });
    });
  </script>

  <!-- VALIDASI DAN STEPPER -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const stepperEl = document.querySelector('#multiStepsValidation');
      const stepper = new Stepper(stepperEl, { linear: false, animation: true });

      const btnNext = document.querySelector('.btn-next');
      const btnPrev = document.querySelector('.btn-prev');

      btnNext.addEventListener('click', function (e) {
        const name = document.getElementById('name').value.trim();
        const nameError = document.getElementById('name-error');
        const password = document.getElementById('password').value.trim();
        const confirmPassword = document.getElementById('password_confirmation').value.trim();
        const errorDiv = document.getElementById('password-error');
        let errors = [];

        nameError.innerHTML = '';
        errorDiv.innerHTML = '';

        const nameRegex = /^(?!.*[_.]{2})(?![_.])[a-zA-Z0-9._]{4,20}(?<![_.])$/;
  if (!nameRegex.test(name)) {
    nameError.innerHTML = 'Username harus 4-20 karakter, hanya huruf, angka, titik, atau underscore. Tidak diawali/diaakhiri titik/underscore dan tidak boleh berurutan.';
    return; // Stop stepper
  }

        if (password.length < 8) {
          errors.push('Password minimal 8 karakter.');
        }

        if (password !== confirmPassword) {
          errors.push('Password dan konfirmasi tidak cocok.');
        }

        if (errors.length > 0) {
          errorDiv.innerHTML = errors.join('<br>');
        } else {
          stepper.next();
        }
      });

      btnPrev.addEventListener('click', () => stepper.previous());
    });
  </script>
</body>
</html>
