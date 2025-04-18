<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="/admin/dashboard" class="logo d-flex align-items-center me-auto me-xl-0">
      <img src="{{ asset('img/ptdi.png') }}" alt="Logo PTDI" width="40px" height="50px">

        <h1 class="sitename">Dirgantara Indonesia</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/admin/dashboard" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">Home</a></li>
          <li><a href="/pendanaan" class="{{ Request::is('pendanaan') || Request::is('pendanaan/*') ? 'active' : '' }}">Pendanaan</a></li>
          <li class="dropdown"><a href="#" class="{{ (Request::is('kategori')|| Request::is('kategori/*')|| Request::is('sub-kategori') || Request::is('sub-kategori/*') || Request::is('device')|| Request::is('device/*') || Request::is('asset'))|| Request::is('asset/*') ? 'active' : '' }}"><span>Endpoint Device</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="/kategori" class="{{ Request::is('kategori') || Request::is('kategori/*') ? 'active' : '' }}">Kategori</a></li>
              <li><a href="/sub-kategori">Sub Kategori</a></li>
              <li><a href="/device">Master Perangkat Komputer</a></li>
              <li><a href="/asset">Master Perlengkapan Kantor</a></li>
              <li><a href="/asset/barang-rusak">Daftar Asset Rusak</a></li>
            </ul>
          </li>

          
          <li class="dropdown"><a href="#" class="{{ (Request::is('employee')|| Request::is('employee/*')|| Request::is('organisasi') || Request::is('organisasi/*') || Request::is('jabatan'))|| Request::is('jabatan/*') ? 'active' : '' }}"><span>Employee</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="/employee">Daftar Employee</a></li>
              <li><a href="/organisasi">Organisasi</a></li>
              <li><a href="/jabatan">Jabatan</a></li>
            </ul>
          </li>

          <li class="dropdown"><a href="#" class="{{ (Request::is('distribusi')|| Request::is('distribusi/*')|| Request::is('history') ||Request::is('history-pengajuan') || Request::is('history/*') || Request::is('historyAsset/*')) ? 'active' : '' }}"><span>Daftar Pengguna</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="/distribusi">Daftar Asset dan Pengguna</a></li>
              <li><a href="/history">History Distribusi Asset</a></li>
              <li><a href="/history-pengajuan">History Pengajuan Rusak</a></li>
            </ul>
          </li>
          <li>
            <a  href="{{ route('auth.logout') }}" class="nav-link">
                <div type="button" class="btn btn-primary" style="border-radius:20px;">Logout
                </div>
            </a>
          </li>

          
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>