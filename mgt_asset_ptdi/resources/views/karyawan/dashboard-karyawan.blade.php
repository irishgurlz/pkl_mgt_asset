<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
 <link href="{{asset('template/assets/img/ptdi.png')}}" rel="icon" type="image/png">
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('template/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('template/assets/vendor/aos/aos.css" rel="stylesheet')}}">
  <link href="{{asset('template/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{asset('template/assets/css/main.css')}}" rel="stylesheet">

</head>

<body class="index-page light-background">

  @include("sidebar-karyawan")
  <main class="main">
  <section id="hero" class="hero section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center">
        <div class="col-lg-4">
            <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <div>
                <h1 class="">Welcome Back</h1>
              </div>
            </div>
        </div>
        {{-- @dd(   $device  ) --}}
        <div class="col-lg-8">
          <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
            <div class="d-flex justify-content-start">
              <h1 class="accent-text" style="color:#0d83fd; margin-left:-40px;">{{$actor->employee->nama}}!</h1>
            </div>
          </div>
      </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row gap-3 mt-3" data-aos="fade-up" data-aos-delay="500">
      <div class="card" style=" border-color: white;  border-radius: 15px;">
          <div class="row" style="background-color: white; border-radius: 15px;">
              <a class="stat-item" href="javascript:void(0);" id="show-device-table">
                  <div class="stat-icon">
                      <i class="bi bi-pc-display"></i>
                  </div>
                  <div class="stat-content">
                      <h4>Perangkat Komputer</h4>
                      <p class="h6 mb-0">Jumlah Perangkat: {{$device}}</p>
                  </div>
              </a>
          </div>
          <div   class="m-3"id="device-table-container" style="display: none; margin-top: 20px;">
              @include('karyawan.table-device-karyawan')
          </div>
      </div>

      <div class="card" style=" border-color: white;  border-radius: 15px;">
          <div class="row mb-3" style="background-color: white; border-radius: 15px;">
              <a class="stat-item" href="javascript:void(0);" id="show-asset-table">
                  <div class="stat-icon">
                    <i class="bi bi-inboxes-fill"></i></i>
                  </div>
                  <div class="stat-content">
                      <h4>Perlengkapan Kantor</h4>
                      <p class="h6 mb-0">Jumlah Perlengkapan: {{$asset}}</p>
                  </div>
              </a>
          </div>
          <div class="m-3" id="asset-table-container" style="display: none; margin-top: 20px;">
              <!-- Include Tabel -->
              @include('karyawan.table-asset-karyawan')
          </div>
      </div>
    </div>

    </div>

    </div>

    </section>

  </main>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{asset('template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('template/assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{asset('template/assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('template/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('template/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('template/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
<script src="{{asset('template/assets/js/main.js')}}"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const showDeviceButton = document.getElementById('show-device-table');
    const deviceTableContainer = document.getElementById('device-table-container');

    const showAssetButton = document.getElementById('show-asset-table');
    const assetTableContainer = document.getElementById('asset-table-container');

    function loadTableState() {
        const deviceState = sessionStorage.getItem('deviceTableVisible');
        if (deviceState === 'true') {
            deviceTableContainer.style.display = 'block';
            showDeviceButton.querySelector('.stat-icon i').classList.add('text-primary');
        } else {
            deviceTableContainer.style.display = 'none';
            showDeviceButton.querySelector('.stat-icon i').classList.remove('text-primary');
        }

        const assetState = sessionStorage.getItem('assetTableVisible');
        if (assetState === 'true') {
            assetTableContainer.style.display = 'block';
            showAssetButton.querySelector('.stat-icon i').classList.add('text-primary');
        } else {
            assetTableContainer.style.display = 'none';
            showAssetButton.querySelector('.stat-icon i').classList.remove('text-primary');
        }
    }

    function saveTableState(key, state) {
        sessionStorage.setItem(key, state);
    }

    showDeviceButton.addEventListener('click', function () {
        const icon = showDeviceButton.querySelector('.stat-icon i');
        if (deviceTableContainer.style.display === 'none') {
            deviceTableContainer.style.display = 'block';
            icon.classList.add('text-primary');
            saveTableState('deviceTableVisible', true); 
        } else {
            deviceTableContainer.style.display = 'none';
            icon.classList.remove('text-primary');
            saveTableState('deviceTableVisible', false); 
        }
    });

    showAssetButton.addEventListener('click', function () {
        const icon = showAssetButton.querySelector('.stat-icon i');
        if (assetTableContainer.style.display === 'none') {
            assetTableContainer.style.display = 'block';
            icon.classList.add('text-primary');
            saveTableState('assetTableVisible', true); 
        } else {
            assetTableContainer.style.display = 'none';
            icon.classList.remove('text-primary');
            saveTableState('assetTableVisible', false); 
        }
    });

    loadTableState();
});

document.getElementById('logout-button').addEventListener('click', function() {
    sessionStorage.removeItem('deviceTableVisible');
    sessionStorage.removeItem('assetTableVisible');


    window.location.href = '/logout'; 
});


</script>



  
</body>
</html>