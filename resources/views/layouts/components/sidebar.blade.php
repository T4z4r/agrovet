   <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
       <div class="app-brand demo">
           <a href="{{ route('dashboard') }}" class="app-brand-link">
               <span class="app-brand-logo demo">
                   <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 25px; width: auto;">
               </span>
               <span class="app-brand-text demo menu-text fw-bolder ms-2">{{ config('app.name', 'Apex') }}</span>
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

           @can('manage staff')
               <!-- Staff -->
               <li class="menu-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                   <a href="{{ route('staff.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-group"></i>
                       <div>{{ __('Staff') }}</div>
                   </a>
               </li>
           @endcan

           @can('create sales')
               <!-- POS -->
               <li class="menu-item {{ request()->routeIs('web.pos.*') ? 'active' : '' }}">
                   <a href="{{ route('web.pos.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-calculator"></i>
                       <div>{{ __('POS') }}</div>
                   </a>
               </li>
           @endcan
           @can('view products')
               <!-- Products -->
               <li class="menu-item {{ request()->routeIs('web.products.*') ? 'active' : '' }}">
                   <a href="{{ route('web.products.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-package"></i>
                       <div>{{ __('Products') }}</div>
                   </a>
               </li>
           @endcan

           @can('view suppliers')
               <!-- Suppliers -->
               <li class="menu-item {{ request()->routeIs('web.suppliers.*') ? 'active' : '' }}">
                   <a href="{{ route('web.suppliers.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-user"></i>
                       <div>{{ __('Suppliers') }}</div>
                   </a>
               </li>
           @endcan

           @can('view sales')
               <!-- Sales -->
               <li class="menu-item {{ request()->routeIs('web.sales.*') ? 'active' : '' }}">
                   <a href="{{ route('web.sales.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                       <div>{{ __('Sales') }}</div>
                   </a>
               </li>
           @endcan



           @can('view expenses')
               <!-- Expenses -->
               <li class="menu-item {{ request()->routeIs('web.expenses.*') ? 'active' : '' }}">
                   <a href="{{ route('web.expenses.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-money"></i>
                       <div>{{ __('Expenses') }}</div>
                   </a>
               </li>
           @endcan

           @can('view products')
               {{-- Assuming stock transactions relate to products --}}
               <!-- Stock Transactions -->
               <li class="menu-item {{ request()->routeIs('web.stock-transactions.*') ? 'active' : '' }}">
                   <a href="{{ route('web.stock-transactions.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-transfer"></i>
                       <div>{{ __('Stock Transactions') }}</div>
                   </a>
               </li>
           @endcan

           @can('view reports')
               <!-- Reports -->
               <li class="menu-item {{ request()->routeIs('web.reports.*') ? 'active' : '' }}">
                   <a href="{{ route('web.reports.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                       <div>{{ __('Reports') }}</div>
                   </a>
               </li>
           @endcan

           @can('view users')
              <!-- User Management -->
               <li class="menu-item {{ request()->routeIs('web.users.*') ? 'active open' : '' }}">
                   <a href="javascript:void(0);" class="menu-link menu-toggle">
                       <i class="menu-icon tf-icons bx bx-user-check"></i>
                       <div>{{ __('User Management') }}</div>
                   </a>
                   <ul class="menu-sub">
                       <li
                           class="menu-item {{ request()->routeIs('web.users.index', 'web.users.show', 'web.users.edit') ? 'active' : '' }}">
                           <a href="{{ route('web.users.index') }}" class="menu-link">
                               <div>{{ __('Users') }}</div>
                           </a>
                       </li>
                       @can('manage roles')
                           <li
                               class="menu-item {{ request()->routeIs('web.users.roles', 'web.users.permissions', 'web.roles.*', 'web.permissions.*') ? 'active' : '' }}">
                               <a href="javascript:void(0);" class="menu-link menu-toggle">
                                   <div>{{ __('Roles & Permissions') }}</div>
                               </a>
                               <ul class="menu-sub">
                                   <li class="menu-item {{ request()->routeIs('web.roles.*') ? 'active' : '' }}">
                                       <a href="{{ route('web.roles.index') }}" class="menu-link">
                                           <div>{{ __('Roles') }}</div>
                                       </a>
                                   </li>
                                   <li class="menu-item {{ request()->routeIs('web.permissions.*') ? 'active' : '' }}">
                                       <a href="{{ route('web.permissions.index') }}" class="menu-link">
                                           <div>{{ __('Permissions') }}</div>
                                       </a>
                                   </li>
                               </ul>
                           </li>
                       @endcan
                       
                   </ul>
               </li>
           @endcan

           @can('view privacy policies')
               <!-- Privacy Policies -->
               <li class="menu-item {{ request()->routeIs('web.privacy-policies.*') ? 'active' : '' }}">
                   <a href="{{ route('web.privacy-policies.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-shield"></i>
                       <div>{{ __('Privacy Policies') }}</div>
                   </a>
               </li>
           @endcan

           @can('view shops')
               <!-- Shops -->
               <li class="menu-item {{ request()->routeIs('web.shops.*') ? 'active' : '' }}">
                   <a href="{{ route('web.shops.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-store"></i>
                       <div>{{ __('Shops') }}</div>
                   </a>
               </li>
           @endcan

           @can('manage subscriptions')
               <!-- Subscriptions -->
               <li class="menu-item {{ request()->routeIs('admin.subscription-packages.*', 'admin.subscriptions.*', 'admin.subscription-payments.*') ? 'active open' : '' }}">
                   <a href="javascript:void(0);" class="menu-link menu-toggle">
                       <i class="menu-icon tf-icons bx bx-credit-card"></i>
                       <div>{{ __('Subscriptions') }}</div>
                   </a>
                   <ul class="menu-sub">
                       <li class="menu-item {{ request()->routeIs('admin.subscription-packages.*') ? 'active' : '' }}">
                           <a href="{{ route('admin.subscription-packages.index') }}" class="menu-link">
                               <div>{{ __('Packages') }}</div>
                           </a>
                       </li>
                       <li class="menu-item {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                           <a href="{{ route('admin.subscriptions.index') }}" class="menu-link">
                               <div>{{ __('Subscriptions') }}</div>
                           </a>
                       </li>
                       <li class="menu-item {{ request()->routeIs('admin.subscription-payments.*') ? 'active' : '' }}">
                           <a href="{{ route('admin.subscription-payments.index') }}" class="menu-link">
                               <div>{{ __('Payments') }}</div>
                           </a>
                       </li>
                       <li class="menu-item {{ request()->routeIs('admin.features.*') ? 'active' : '' }}">
                           <a href="{{ route('admin.features.index') }}" class="menu-link">
                               <div>{{ __('Features') }}</div>
                           </a>
                       </li>
                   </ul>
               </li>
           @endcan

           @can('access admin')
               <!-- Admin -->
               <li class="menu-item {{ request()->routeIs('web.admin.*') ? 'active' : '' }}">
                   <a href="{{ route('web.admin.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-data"></i>
                       <div>{{ __('Database Admin') }}</div>
                   </a>
               </li>
           @endcan

           @can('view audits')
               <!-- Audits -->
               <li class="menu-item {{ request()->routeIs('admin.audits.*') ? 'active' : '' }}">
                   <a href="{{ route('admin.audits.index') }}" class="menu-link">
                       <i class="menu-icon tf-icons bx bx-history"></i>
                       <div>{{ __('System Logs') }}</div>
                   </a>
               </li>
           @endcan

           <!-- Language Switcher -->
           {{-- <li class="menu-item">
               <a href="javascript:void(0);" class="menu-link menu-toggle">
                   <i class="menu-icon tf-icons bx bx-globe"></i>
                   <div>{{ strtoupper(app()->getLocale()) }}</div>
               </a>
               <ul class="menu-sub">
                   <li class="menu-item">
                       <a href="{{ route('lang.switch', 'en') }}" class="menu-link">
                           <div>{{ __('EN - English') }}</div>
                       </a>
                   </li>
                   <li class="menu-item">
                       <a href="{{ route('lang.switch', 'sw') }}" class="menu-link">
                           <div>{{ __('SW - Swahili') }}</div>
                       </a>
                   </li>
               </ul>
           </li> --}}
       </ul>
   </aside>
