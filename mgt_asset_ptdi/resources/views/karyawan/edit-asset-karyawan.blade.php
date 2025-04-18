<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Ajukan Kerusakan Asset</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
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
</head>

<body class="index-page light-background">

@include("sidebar-karyawan")
<main class="main">

<section class="section" style="margin-top:4%">

    <!-- TITLE -->
    <div class="container" data-aos="fade-up">
        <div class="section-title mt-3" data-aos="fade-up">
            <h2>Ajukan Kerusakan Perlengkapan Kantor</h2>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            @if(isset($status))
            <div class="alert alert-warning" role="alert">
                {{ $status }}
            </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('updateRusak', $disDetail->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nomor_asset" class="form-label">Nomor Asset</label>
                            <input type="text" id="nomor_asset" class="form-control" value="{{ $disDetail->nomor_asset }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" id="kategori" class="form-control" value="{{ $disDetail->asset->kategori->nama }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="sub_kategori" class="form-label">Sub Kategori</label>
                            <input type="text" id="sub_kategori" class="form-control" value="{{ $disDetail->asset->subKategori->nama }}" disabled>
                        </div>

                        @if($disDetail->status_pengajuan == 1)
                        <div class="mb-3">
                            <label for="deskripsi_pengajuan" class="form-label">Deskripsi Kerusakan</label>
                            <textarea name="deskripsi_pengajuan" id="deskripsi_pengajuan" class="form-control" disabled>{{ $disDetail->deskripsi_pengajuan }}</textarea>
                        </div>
                        @else
                        <div class="mb-3">
                            <label for="deskripsi_pengajuan" class="form-label">Deskripsi Kerusakan</label>
                            <textarea name="deskripsi_pengajuan" id="deskripsi_pengajuan" class="form-control" required></textarea>
                        </div>
                        @endif
                        
                        @if($disDetail->status_pengajuan != 1)
                        <button type="submit" class="btn btn-primary">Ajukan</button>
                        @endif

                        <a href="{{ route('karyawan.dashboard') }}" class="btn btn-danger">Batal</a>
                    </form>
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

<script src="assets/js/main.js"></script>

</body>
</html>