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

    <title>Verify OTP | {{ config('app.name', 'Agrovet') }}</title>

    <meta name="description" content="" />

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
  </head>

  <body>
    <div class="container-xl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner" style="max-width: 500px; width: 100%; margin: 0 auto;">
          <div class="card">
            <div class="card-body p-4 p-md-5">
              <div class="app-brand justify-content-center mb-2">
                <a href="{{ url('/') }}" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height:80px; width: auto;">
                  </span>
                </a>
              </div>

              <h4 class="mb-1 text-center">{{ __('Verify Your Email') }}</h4>
              <p class="mb-4 text-center text-muted">{{ __('Enter the 6-digit code sent to your email') }}</p>

              @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
              @endif

              @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              <form method="POST" action="{{ route('otp.verify') }}">
                @csrf

                <div class="mb-3">
                  <label for="otp_code" class="form-label">{{ __('OTP Code') }}</label>
                  <input
                    type="text"
                    class="form-control text-center"
                    id="otp_code"
                    name="otp_code"
                    maxlength="6"
                    placeholder="000000"
                    required
                    autofocus
                    style="letter-spacing: 0.5rem; font-size: 1.5rem;"
                  />
                </div>

                <div class="mb-3">
                  <button type="submit" class="btn btn-primary d-grid w-100">{{ __('Verify') }}</button>
                </div>
              </form>

              <form method="POST" action="{{ route('otp.resend') }}" class="text-center">
                @csrf
                <button type="submit" class="btn btn-link">{{ __('Resend OTP') }}</button>
              </form>

              <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-muted">{{ __('Back to Login') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/i18next/21.9.2/i18next.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/formvalidation@1.10.0/dist/js/FormValidation.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/formvalidation@1.10.0/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/formvalidation@1.10.0/dist/js/plugins/AutoFocus.min.js"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>

    <script>
      document.getElementById('otp_code').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
      });
    </script>
  </body>
</html>