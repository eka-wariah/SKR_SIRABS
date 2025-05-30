<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  dir="ltr"
  data-skin="default"
  data-assets-path="../../assets/"
  data-template="horizontal-menu-template-no-customizer"
  data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Demo: Register Basic - Pages | Vuexy - Bootstrap Dashboard PRO</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('vuexy/assets/img/favicon/favicon.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/fonts/iconify-icons.css')}}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/libs/node-waves/node-waves.css')}}" />

    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/css/core.css')}}" />
    <link rel="stylesheet" href="{{ asset ('vuexy/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />
    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/libs/@form-validation/form-validation.css')}}" />


    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- endbuild -->

    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/libs/@form-validation/form-validation.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset ('vuexy/assets/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{ asset ('vuexy/assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset ('vuexy/assets/js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-6">
                <a href="index.html" class="app-brand-link">
                  <span class="app-brand-logo demo">
                    <span class="text-primary">
                      <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                          fill="currentColor" />
                        <path
                          opacity="0.06"
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                          fill="#161616" />
                        <path
                          opacity="0.06"
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                          fill="#161616" />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                          fill="currentColor" />
                      </svg>
                    </span>
                  </span>
                  <span class="app-brand-text demo text-heading fw-bold">Vuexy</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1">Adventure starts here 🚀</h4>
              <p class="mb-6">Make your app management easy and fun!</p>

              <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-6 form-control-validation">
                  <label for="name" class="form-label":value="__('Name')">Username</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name" :value="old('name')" required autofocus autocomplete="name"
                    placeholder="Enter your username"
                    autofocus />
                </div>
                <div class="mb-6 form-control-validation">
                  <label for="email" class="form-label" :value="__('Email')" >Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" :value="old('email')" required autocomplete="username" />
                </div>
                <div class="mb-6 form-password-toggle form-control-validation">
                  <label class="form-label" for="password" :value="__('Password')" >Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                      required autocomplete="new-password" />
                    <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
                  </div>
                </div>
                <div class="mb-6 form-password-toggle form-control-validation">
                    <label class="form-label" for="password_confirmation" :value="__('Confirm Password')" >Confirm Password</label>
                    <div class="input-group input-group-merge">
                      <input
                        type="password"
                        id="password_confirmation"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password"
                        required autocomplete="new-password" />
                      <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
                    </div>
                  </div>
                  <div class="mb-6 form-password-toggle form-control-validation">
                    <label class="form-label" for="usr_scope_id":value="__('Pilih RT')">State</label>
                    <select name="usr_scope_id" id="usr_scope_id" class="select2 form-select">
                      <option value="">-- Pilih RT --</option>
                      @foreach ($areaScopes as $area)
                      <option value="{{ $area->asc_id }}">
                          {{ $area->asc_level }} {{ $area->asc_number }}
                      </option>
                  @endforeach
                    </select>
                    @error('usr_scope_id')
    <div class="text-danger mt-1">{{ $message }}</div>
@enderror
                  </div>
                <div class="my-8 form-control-validation">
                  <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                      I agree to
                      <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                  </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                  <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                      {{ __('Already registered?') }}
                  </a>
                <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Register') }}</button>
                </div>
              </form>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="auth-login-basic.html">
                  <span>Sign in instead</span>
                </a>
              </p>

              <div class="divider my-6">
                <div class="divider-text">or</div>
              </div>

              <div class="d-flex justify-content-center">
                <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook me-1_5">
                  <i class="icon-base ti tabler-brand-facebook-filled icon-20px"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter me-1_5">
                  <i class="icon-base ti tabler-brand-twitter-filled icon-20px"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github me-1_5">
                  <i class="icon-base ti tabler-brand-github-filled icon-20px"></i>
                </a>

                <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
                  <i class="icon-base ti tabler-brand-google-filled icon-20px"></i>
                </a>
              </div>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js -->

    <script src="{{ asset ('vuexy/assets/vendor/libs/jquery/jquery.js')}}"></script>

    <script src="{{ asset ('vuexy/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset ('vuexy/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset ('vuexy/assets/vendor/libs/node-waves/node-waves.js')}}"></script>

    <script src="{{ asset ('vuexy/assets/vendor/libs/@algolia/autocomplete-js.js')}}"></script>

    <script src="{{ asset ('vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{ asset ('vuexy/assets/vendor/libs/hammer/hammer.js')}}"></script>

    <script src="{{ asset ('vuexy/assets/vendor/libs/i18n/i18n.js')}}"></script>

    <script src="{{ asset ('vuexy/assets/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset ('vuexy/assets/vendor/libs/@form-validation/popular.js')}}"></script>
    <script src="{{ asset ('vuexy/assets/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{ asset ('vuexy/assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{ asset ('vuexy/assets/vendor/libs/@form-validation/auto-focus.js')}}"></script>

    <!-- Main JS -->

    <script src="{{ asset ('vuexy/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset ('vuexy/assets/js/pages-auth.js')}}"></script>
  </body>
</html>



{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Area Scope Selection -->
<div class="mt-4">
    <x-input-label for="usr_scope_id" :value="__('Pilih RT')" />
    <select name="usr_scope_id" id="usr_scope_id" class="block mt-1 w-full">
        <option value="">-- Pilih RT --</option>
        @foreach ($areaScopes as $area)
            <option value="{{ $area->asc_id }}">
                {{ $area->asc_level }} {{ $area->asc_number }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('usr_scope_id')" class="mt-2" />
</div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
