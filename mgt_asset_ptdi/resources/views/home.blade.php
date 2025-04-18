<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home</title>
  <meta name="description" content="">
  <meta name="keywords" content="">



  <link href="{{asset('template/assets/img/ptdi.png')}}" rel="icon" type="image/png">

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

<style>
  .notification-box {
    background-color: var(--surface-color);
    border-radius: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    padding: 20px;
    height: 100%; 
    max-height: 490px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .notification-box h4 {
    text-align: center;
    font-weight: bold;
  }
</style>

</head>

<body class="index-page light-background">

  @include("sidebar")
  <main class="main">
  <section id="hero" class="hero section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center">
        <div class="col-lg-6">
            <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                <h1 class="mb-4">
                Fixed Asset<br>
                <span class="accent-text">Management</span>
                </h1>
            </div>
        </div>
    </div>

    <div class = "row mb-4">
        <!-- Rekap Jumlah -->
        <div class="row stats-row ms-1" style = "width: 95%" data-aos="fade-up" data-aos-delay="500">
            <div class="col">
                <a class="stat-item" href="/employee">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-content">
                    <h4>Employee</h4>
                    <p class="h6 mb-0">{{ $empTot }} Employee</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a class="stat-item" href="/organisasi">
                    <div class="stat-icon">
                    <i class="bi bi-building-fill"></i>
                    </div>
                    <div class="stat-content">
                    <h4>Organization</h4>
                    <p class="h6 mb-0">{{$orgTot}} Organization</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a class="stat-item" href="/kategori">
                    <div class="stat-icon">
                    <i class="bi bi-tag-fill"></i>
                    </div>
                    <div class="stat-content">
                    <h4>Kategori & Sub Kategori</h4>
                    <p class="h6 mb-0">{{ $catTot }} Kategori & {{ $subTot }} Sub</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a class="stat-item" href="/sub-kategori">
                    <div class="stat-icon">
                    <i class="bi bi-list-ul"></i>
                    </div>
                    <div class="stat-content">
                    <h4>Perangkat Komputer</h4>
                    <p class="h6 mb-0">{{ $devTot }} Buah</p>
                    </div>
                </a>
            </div>
            <div class="col">
                <a class="stat-item" href="/device">
                    <div class="stat-icon">
                    <i class="bi bi-pc-display"></i>
                    </div>
                    <div class="stat-content">
                    <h4>Perlengkapan Kantor</h4>
                    <p class="h6 mb-0">{{ $assTot }} Buah</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row gap-5" data-aos="fade-up" data-aos-delay="500">
        <!-- Grafik -->
        <div class="col col-7">
            <div class="row stats-row" data-aos="fade-up" data-aos-delay="500">
                @include('component.grafik_umur_device')
            </div>
        </div>
                    
        <!-- Notifikasi -->
        <div class="col col-4">
            <div class="row stats-row notification-box text-center align-items-center" data-aos="fade-up" data-aos-delay="500" style="height: 69%; min-height: 335px;">
        
                <!-- Judul -->
                @if ($distributionCount > 0)                    
                    <div class="col-12 d-flex align-items-center mb-3" style="height: 10%;">
                        <div class="col-7 d-flex justify-content-start">
                            <h4 class="fw-bold" style="margin: 0; font-size: 1.5rem;">Notifikasi</h4>
                        </div>
                        <div class="col-5 d-flex align-items-center">
                            <a href="/detail-notifikasi" class="btn btn-primary d-flex align-items-center justify-content-center" style="height: 30px; width:100%; font-size: 0.9rem; padding-left: 15px; padding-right: 15px; border-radius: 10px;">
                                Detail
                            </a>
                        </div>
                    </div>
                @else
                    <div class="col-12 d-flex align-items-center d-flex justify-content-center mb-3" style="height: 10%;">
                        <h4 class="fw-bold" style="margin: 0; font-size: 1.5rem;">Notifikasi</h4>
                    </div>
                @endif
        
                <!-- List Notifikasi -->
                <div class="col-12" style="height: calc(100% - 50px); overflow-y: auto; padding-right: 10px;">
        
                    <!-- Notifikasi 1 -->

                    @forelse ($distribution as $item)
                    <div class="bg-light d-flex justify-content-between align-items-start ps-4 pt-3 pe-4 pb-2 mb-3" style="box-shadow: 0px 4px 15px rgba(0,0,0,0.1); border-radius: 10px; height: auto; transition: transform 0.2s ease-in-out; padding: 20px;">
                        <div class="d-flex flex-column">
                            <strong class="text-primary text-start" style="font-size: 1.1rem;">{{$item->employee->nama}}</strong>
                            <p class="text-muted mb-0 text-start">{{$item->deskripsi_pengajuan}}</p>
                        </div>

                        <div class="d-flex flex-column">
                            <strong class="text-muted mb-0 text-start">({{$item->nomor_asset ?? $item->nomor_it}})</strong>
                        </div>
        
                    </div>
                    @empty
                        
                    @endforelse
        
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

<!-- Main JS File -->
<script src="{{asset('template/assets/js/main.js')}}"></script>
</body>
</html>