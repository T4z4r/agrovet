<!DOCTYPE html>

<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets') }}/"
  data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Register | {{ config('app.name', 'Agrovet') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
  </head>

  <body>
    <div class="container-xl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner" style="max-width: 750px; width: 100%; margin: 0 auto;">
          <!-- Register -->
          <div class="card">
            <div class="card-body p-4 p-md-5">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-2">
                <a href="{{ url('/') }}" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height:80px; width: auto;">
                  </span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1 text-center">{{ __('Create an Account') }}</h4>
              <p class="mb-4 text-center text-muted">{{ __('Register your shop to get started') }}</p>

              <form id="formRegister" class="mb-3" action="{{ route('register') }}" method="POST">
                @csrf

                <div class="row g-3">

                  <!-- Name -->
                  <div class="col-md-6">
                    <label for="name" class="form-label">{{ __('Full Name') }}</label>
                    <input
                      type="text"
                      class="form-control @error('name') is-invalid @enderror"
                      id="name"
                      name="name"
                      value="{{ old('name') }}"
                      placeholder="{{ __('Enter your full name') }}"
                      autofocus
                    />
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Email -->
                  <div class="col-md-6">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input
                      type="email"
                      class="form-control @error('email') is-invalid @enderror"
                      id="email"
                      name="email"
                      value="{{ old('email') }}"
                      placeholder="{{ __('Enter your email') }}"
                    />
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Shop Name -->
                  <div class="col-md-6">
                    <label for="shop_name" class="form-label">{{ __('Shop Name') }}</label>
                    <input
                      type="text"
                      class="form-control @error('shop_name') is-invalid @enderror"
                      id="shop_name"
                      name="shop_name"
                      value="{{ old('shop_name') }}"
                      placeholder="{{ __('Enter your shop name') }}"
                    />
                    @error('shop_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Shop Location -->
                  <div class="col-md-6">
                    <label for="shop_location" class="form-label">
                      {{ __('Shop Location') }} <span class="text-muted">({{ __('optional') }})</span>
                    </label>
                    <input
                      type="text"
                      class="form-control @error('shop_location') is-invalid @enderror"
                      id="shop_location"
                      name="shop_location"
                      value="{{ old('shop_location') }}"
                      placeholder="{{ __('Enter shop location') }}"
                    />
                    @error('shop_location')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Password -->
                  <div class="col-md-6">
                    <label class="form-label" for="password">{{ __('Password') }}</label>
                    <div class="input-group input-group-merge form-password-toggle">
                      <input
                        type="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      />
                      <button class="input-group-text cursor-pointer toggle-password" type="button" data-target="password" aria-label="Show password">
                        <i class="bx bx-hide"></i>
                      </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Confirm Password -->
                  <div class="col-md-6">
                    <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <div class="input-group input-group-merge form-password-toggle">
                      <input
                        type="password"
                        id="password_confirmation"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      />
                      <button class="input-group-text cursor-pointer toggle-password" type="button" data-target="password_confirmation" aria-label="Show password">
                        <i class="bx bx-hide"></i>
                      </button>
                    </div>
                  </div>

                  <!-- Submit -->
                  <div class="col-12 mt-2">
                    <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Create Account') }}</button>
                  </div>

                  <div class="col-12">
                    <p class="text-center mb-0">
                      <span>{{ __('Already have an account?') }}</span>
                      <a href="{{ route('login') }}"> {{ __('Sign in instead') }}</a>
                    </p>
                  </div>

                </div><!-- /row -->
              </form>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- Core JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/i18next/21.9.2/i18next.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

    <!-- Vendors JS -->
    <script src="https://cdn.jsdelivr.net/npm/formvalidation@1.10.0/dist/js/FormValidation.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/formvalidation@1.10.0/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/formvalidation@1.10.0/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
  </body>
</html>
