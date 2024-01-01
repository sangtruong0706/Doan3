<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
        <img src="{{ asset('admin/assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">Admin Page</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white  {{ request()->routeIs('dashboard')?'active bg-gradient-primary':'' }} " href="{{ route('dashboard') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">home</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('category.*')?'active bg-gradient-primary':'' }} " href="{{ route('category.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">category</i>
            </div>
            <span class="nav-link-text ms-1">Category</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->routeIs('product.*')?'active bg-gradient-primary':'' }} " href="{{ route('product.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">devices_other</i>
            </div>
            <span class="nav-link-text ms-1">Product</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->routeIs('coupon.*')?'active bg-gradient-primary':'' }} " href="{{ route('coupon.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">qr_code_scanner</i>
            </div>
            <span class="nav-link-text ms-1">Coupon</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.order.*')?'active bg-gradient-primary':'' }} " href="{{ route('admin.order.index') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">note_alt</i>
            </div>
            <span class="nav-link-text ms-1">Order</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('users.*')?'active bg-gradient-primary':'' }}" href="{{ route('users.index') }}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">account_circle</i>
              </div>
              <span class="nav-link-text ms-1">User</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('roles.*')?'active bg-gradient-primary':'' }} " href="{{ route('roles.index') }}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">border_color</i>
              </div>
              <span class="nav-link-text ms-1">Role</span>
            </a>
          </li>
      </ul>
    </div>
  </aside>
