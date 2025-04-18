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
    <script src="{{ asset('template/assets/js/main.js') }}"></script>
    {{-- <script src="assets/js/main.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="index-page light-background">

@include("sidebar-karyawan")
<main class="main">

<section class="section" style="margin-top:4%">

    <!-- TITLE -->
    <div class="container" data-aos="fade-up">
        <div class="section-title mt-3" data-aos="fade-up">
            <h2>History Pengajuan Device Rusak</h2>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="card shadow mb-4">
                <div class="card-header py-3">

                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="m-0 font-weight-bold">
                                {{-- <a class="btn btn-primary" href="/employee/create">+ Tambah Employee</a> --}}
                            </h6>
                        </div>
                        
                        <form id="searchForm" method="GET">
                            <div class="mb-3 d-flex justify-content-between"">
                                <div class="input-group me-2">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search History" value="{{ request('search') }}">
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Penyerahan</th>
                                <th>Nomor Asset</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Pengajuan</th>
                                <th>Status</th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                        @include('karyawan.table-history-device-rusak')
                        
                    </table>
                    @include('paginate', ['paginator' => $history])
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');

    searchInput.addEventListener('keyup', function () {
        let searchQuery = searchInput.value;

        fetch("{{ route('history-device-rusak') }}?search=" + searchQuery, {
            method: 'GET',
            headers: {
                'Accept': 'text/html',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            // Update hanya tbody
            document.querySelector('#tableData tbody').innerHTML = data;
        });
    });
});

</script>
</body>
</html>