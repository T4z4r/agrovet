<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/"
  data-template="vertical-menu-template-starter"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@section('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" /> -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" /> -->

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/introjs.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->



        @include('layouts.components.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page ">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="navbar-nav align-items-center">
              <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);" id="tour-navbar-style-switcher">
                <i class="bx bx-sm"></i>
              </a>
            </div>

            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" id="tour-navbar-menu-toggle">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" id="tour-navbar-user-toggle">
                    <div class="avatar avatar-online">
                      {{-- <img src="../../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" /> --}}
                      <div class="bg-light w-px-40 h-px-40 rounded-circle shadow-sm border-2 border-white d-flex align-items-center justify-content-center">
                        <i class="bx bx-user bx-md text-primary"></i>
                      </div>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#" id="tour-navbar-profile-summary">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <i class="bx bx-user bx-lg"></i>
                            </div>
                          </div>
                          <div class="flex-grow-1">
                           <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                           <small class="text-muted">{{ Auth::user()->getRoleNames()->first() ?? 'User' }}</small>
                         </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    {{-- <li>
                      <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li> --}}
                    <li>
                      <a class="dropdown-item" href="{{ route('settings.index') }}" id="tour-navbar-settings-link">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    {{-- <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                      </a>
                    </li> --}}
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" id="tour-navbar-logout-link">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper p-2">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              {{-- <h4 class="fw-bold py-3 mb-4">Page 1</h4>
              <small>
                Sample page.<br />For more layout options use
                <a href="https://themeselection.com/tools/generator/sneat/html" target="_blank" class="fw-bold"
                  >HTML starter template generator</a
                >
                and refer
                <a
                  href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation//layouts.html"
                  target="_blank"
                  class="fw-bold"
                  >Layout docs</a
                >.
              </small>
              <hr> --}}

              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              @yield('content')
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">Apex Team</a>
                </div>
                <div>
                  <a
                    href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Help</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/intro.min.js"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @php
      $shouldRunTour = auth()->check() && ! auth()->user()->hasCompletedOnboardingTour();
    @endphp

    @if ($shouldRunTour)
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          if (typeof introJs !== 'function') {
            return;
          }

          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
          const tourCompleteUrl = @json(route('tour.complete'));
          const sidebarParentToggles = [
            '#tour-sidebar-user-management-toggle',
            '#tour-sidebar-subscriptions-toggle',
            '#tour-sidebar-common-products-toggle'
          ];
          const openedSidebarParents = [];
          const userDropdownToggle = document.querySelector('#tour-navbar-user-toggle');
          let openedUserDropdown = false;
          let savedTourCompletion = false;
          const isVisible = (element) => Boolean(element && element.getClientRects().length > 0);

          sidebarParentToggles.forEach((selector) => {
            const toggle = document.querySelector(selector);
            const parent = toggle?.closest('.menu-item');

            if (toggle && parent && !parent.classList.contains('open')) {
              toggle.click();
              openedSidebarParents.push(toggle);
            }
          });

          if (userDropdownToggle) {
            const dropdown = userDropdownToggle.closest('.dropdown');

            if (dropdown && !dropdown.classList.contains('show')) {
              userDropdownToggle.click();
              openedUserDropdown = true;
            }
          }

          const stepDefinitions = [
            { selector: '#tour-welcome-card', intro: 'This is your dashboard overview. It gives you a quick feel for what is happening right now.' },
            { selector: '#tour-sidebar-dashboard-link', intro: 'Start here anytime to return to the dashboard.' },
            { selector: '#tour-sidebar-staff-link', intro: 'Manage staff members from this menu if your role allows it.' },
            { selector: '#tour-sidebar-pos-link', intro: 'Use POS to make new sales quickly.' },
            { selector: '#tour-sidebar-products-link', intro: 'Add and manage products from here.' },
            { selector: '#tour-sidebar-suppliers-link', intro: 'Keep supplier records organized in this section.' },
            { selector: '#tour-sidebar-sales-link', intro: 'Review sales history and transactions here.' },
            { selector: '#tour-sidebar-expenses-link', intro: 'Track business expenses from this menu.' },
            { selector: '#tour-sidebar-stock-transactions-link', intro: 'Follow stock movement and inventory changes here.' },
            { selector: '#tour-sidebar-reports-link', intro: 'Open reports for deeper analysis and summaries.' },
            { selector: '#tour-sidebar-user-management-toggle', intro: 'Some menus expand to reveal more options. This one groups user management tools.' },
            { selector: '#tour-sidebar-users-link', intro: 'View and manage users from here.' },
            { selector: '#tour-sidebar-roles-toggle', intro: 'This submenu holds role and permission tools.' },
            { selector: '#tour-sidebar-roles-link', intro: 'Roles help control access levels in the system.' },
            { selector: '#tour-sidebar-permissions-link', intro: 'Permissions let you fine-tune access rules.' },
            { selector: '#tour-sidebar-privacy-policies-link', intro: 'Manage privacy policy content from this section.' },
            { selector: '#tour-sidebar-shops-link', intro: 'Shop settings and records live here.' },
            { selector: '#tour-sidebar-subscriptions-toggle', intro: 'Subscription tools are grouped together here.' },
            { selector: '#tour-sidebar-subscription-packages-link', intro: 'Create or manage subscription packages.' },
            { selector: '#tour-sidebar-subscriptions-link', intro: 'Review active subscriptions here.' },
            { selector: '#tour-sidebar-subscription-payments-link', intro: 'Track subscription payments from this screen.' },
            { selector: '#tour-sidebar-features-link', intro: 'Manage subscription features here.' },
            { selector: '#tour-sidebar-database-admin-link', intro: 'Administrative database tools are available here.' },
            { selector: '#tour-sidebar-audits-link', intro: 'System activity logs are stored here.' },
            { selector: '#tour-sidebar-guides-link', intro: 'Use guides for help and training material.' },
            { selector: '#tour-sidebar-common-products-toggle', intro: 'Common product templates are grouped here for quick setup.' },
            { selector: '#tour-sidebar-common-categories-link', intro: 'Browse standardized product categories here.' },
            { selector: '#tour-sidebar-common-products-link', intro: 'Browse standardized product templates here.' },
            { selector: '#tour-navbar-style-switcher', intro: 'This button lets you switch the visual style or theme controls.' },
            { selector: '#tour-navbar-menu-toggle', intro: 'Use this to collapse or expand the sidebar on smaller screens.' },
            { selector: '#tour-navbar-user-toggle', intro: 'Open this menu to access your account options.' },
            { selector: '#tour-navbar-settings-link', intro: 'From here you can open your settings.' },
            { selector: '#tour-navbar-logout-link', intro: 'Use this to log out when you are finished.' },
            { selector: '#tour-total-products-card', intro: 'This card shows your total product count.' },
            { selector: '#tour-total-sales-card', intro: 'This card summarizes total sales.' },
            { selector: '#tour-total-expenses-card', intro: 'This card shows total expenses.' },
            { selector: '#tour-today-sales-card', intro: 'Here you can see today’s sales performance.' },
            { selector: '#tour-stock-value-card', intro: 'This card shows the current stock value.' },
            { selector: '#tour-net-position-card', intro: 'This card shows your overall net position.' },
            { selector: '#tour-sales-expenses-chart', intro: 'This chart compares sales and expenses over the last 30 days.' },
            { selector: '#tour-today-expenses-card', intro: 'This card shows today’s expenses.' },
            { selector: '#tour-monthly-sales-card', intro: 'This card shows monthly sales performance.' },
            { selector: '#tour-total-sales-count-card', intro: 'This card counts all sales transactions.' },
            { selector: '#tour-today-net-performance-card', intro: 'This card shows today’s net performance.' },
            { selector: '#tour-monthly-net-performance-card', intro: 'This card shows your monthly net performance.' },
            { selector: '#tour-recent-sales-table', intro: 'Recent sales appear here for quick review.' },
            { selector: '#tour-start-selling-button', intro: 'Use this button to jump straight into POS and start selling.' }
          ];

          const steps = stepDefinitions
            .map((step) => {
              const element = document.querySelector(step.selector);
              return isVisible(element) ? { element, intro: step.intro } : null;
            })
            .filter(Boolean);

          if (!steps.length) {
            return;
          }

          const saveTourCompletion = async () => {
            if (savedTourCompletion) {
              return;
            }

            savedTourCompletion = true;

            if (csrfToken) {
              try {
                await fetch(tourCompleteUrl, {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                  },
                  credentials: 'same-origin',
                  body: JSON.stringify({ completed: true })
                });
              } catch (error) {
                console.warn('Unable to save onboarding tour completion.', error);
              }
            }

            if (openedUserDropdown && userDropdownToggle) {
              userDropdownToggle.click();
            }

            openedSidebarParents.forEach((toggle) => {
              const parent = toggle.closest('.menu-item');
              if (parent && parent.classList.contains('open')) {
                toggle.click();
              }
            });
          };

          const tour = introJs();
          tour.setOptions({
            steps,
            showProgress: true,
            showBullets: false,
            exitOnOverlayClick: false,
            exitOnEsc: true,
            scrollToElement: true,
            tooltipClass: 'agrovet-tour-tooltip',
            nextLabel: 'Next',
            prevLabel: 'Back',
            skipLabel: 'Skip',
            doneLabel: 'Finish'
          });

          tour.oncomplete(saveTourCompletion);
          tour.onexit(saveTourCompletion);
          tour.start();
        });
      </script>
    @endif

    @yield('scripts')
    <!-- Page JS -->

    <script>
      document.addEventListener('click', function (event) {
        const button = event.target.closest('.toggle-password');
        if (!button) {
          return;
        }

        const input = document.getElementById(button.dataset.target);
        if (!input) {
          return;
        }

        const icon = button.querySelector('i');
        if (input.type === 'password') {
          input.type = 'text';
          if (icon) {
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
          } else {
            button.textContent = 'Hide';
          }
        } else {
          input.type = 'password';
          if (icon) {
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
          } else {
            button.textContent = 'Show';
          }
        }
      });
    </script>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('logout') }}" class="modal-content">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">{{ __('Confirm Logout') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            {{ __('Are you sure you want to log out?') }}
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
            <button class="btn btn-danger" type="submit">{{ __('Log Out') }}</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
