<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
      <img src="{{ asset('img/ptdi.png') }}" alt="Logo PTDI" width="40px" height="50px">

        <h1 class="sitename">Dirgantara Indonesia</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/super-admin/dashboard" class="{{ Request::is('super-admin/dashboard') ? 'active' : '' }}">Home</a></li>
          
          <li>
            <a  href="{{ route('auth.logout') }}" id="logout-button" class="nav-link">
                <div type="button" class="btn btn-primary">Logout
                </div>
            </a>
          </li>

          
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>