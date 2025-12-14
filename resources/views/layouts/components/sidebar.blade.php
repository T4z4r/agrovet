   <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="{{ route('dashboard') }}" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 25px; width: auto;">
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ config('app.name', 'Agrovet') }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>{{ __('Dashboard') }}</div>
              </a>
            </li>

            <!-- Products -->
            <li class="menu-item {{ request()->routeIs('web.products.*') ? 'active' : '' }}">
              <a href="{{ route('web.products.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div>{{ __('Products') }}</div>
              </a>
            </li>

            <!-- Suppliers -->
            <li class="menu-item {{ request()->routeIs('web.suppliers.*') ? 'active' : '' }}">
              <a href="{{ route('web.suppliers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>{{ __('Suppliers') }}</div>
              </a>
            </li>

            <!-- Sales -->
            <li class="menu-item {{ request()->routeIs('web.sales.*') ? 'active' : '' }}">
              <a href="{{ route('web.sales.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                <div>{{ __('Sales') }}</div>
              </a>
            </li>

            <!-- Expenses -->
            <li class="menu-item {{ request()->routeIs('web.expenses.*') ? 'active' : '' }}">
              <a href="{{ route('web.expenses.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div>{{ __('Expenses') }}</div>
              </a>
            </li>

            <!-- Stock Transactions -->
            <li class="menu-item {{ request()->routeIs('web.stock-transactions.*') ? 'active' : '' }}">
              <a href="{{ route('web.stock-transactions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-transfer"></i>
                <div>{{ __('Stock Transactions') }}</div>
              </a>
            </li>


            <!-- Reports -->
            <li class="menu-item {{ request()->routeIs('web.reports.*') ? 'active' : '' }}">
              <a href="{{ route('web.reports.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                <div>{{ __('Reports') }}</div>
              </a>
            </li>

            @if(auth()->user()->role === 'owner')
            <!-- Users -->
            <li class="menu-item {{ request()->routeIs('web.users.*') ? 'active' : '' }}">
              <a href="{{ route('web.users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>{{ __('Users') }}</div>
              </a>
            </li>

            <!-- Shops -->
            <li class="menu-item {{ request()->routeIs('web.shops.*') ? 'active' : '' }}">
              <a href="{{ route('web.shops.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div>{{ __('Shops') }}</div>
              </a>
            </li>
            @endif

            <!-- Language Switcher -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-globe"></i>
                <div>{{ strtoupper(app()->getLocale()) }}</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{ route('lang.switch', 'en') }}" class="menu-link">
                    <div>EN - English</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ route('lang.switch', 'sw') }}" class="menu-link">
                    <div>SW - Swahili</div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </aside>

