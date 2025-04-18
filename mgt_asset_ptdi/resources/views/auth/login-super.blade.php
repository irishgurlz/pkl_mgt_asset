<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>Login</title>
<meta name="description" content="">
<meta name="keywords" content="">

<!-- Favicons -->
<link href="{{asset('template/assets/img/favicon.png')}}" rel="icon">
<link href="{{asset('template/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

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

<!-- =======================================================
* Template Name: iLanding
* Template URL: https://bootstrapmade.com/ilanding-bootstrap-landing-page-template/
* Updated: Nov 12 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
======================================================== -->
</head>

<body class="index-page light-background">

<main class="main">
<section id="pricing" class="pricing section light-background">
@if (session('success'))
<div class="d-flex justify-content-center">
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
</div>
@endif
<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
    <h2>Login to your account!</h2>
</div><!-- End Section Title -->

<div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row g-4 justify-content-center">
        <!-- Basic Plan -->
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="pricing-card">
            <!-- Login Form -->
            <form action="{{ route('auth.verify') }}" method="POST">
            @csrf

            <div class="row mb-4 justify-content-center">
                <div class="col col-1">
                    <img src="{{ asset('img/ptdi.png') }}" alt="Logo PTDI" width="45px" height="45px">
                </div>
                <div class="col col-10 text-center mt-2">
                    <h3>Dirgantara Indonesia</h3>
                </div>
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="super_user" class="form-label">User</label>
                <input type="text" id="super_user" name="super_user" class="form-control" placeholder="Masukkan super_user" required>
                @error('super_user')
                    <div class="alert alert-danger text-center">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                @if ($errors->has('login_error'))
                    <div class="alert alert-danger text-center">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-3 d-flex justify-content-between mt-3">
                <div>
                    <input type="checkbox" id="remember" name="remember" class="form-check-input">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <div>
                    <a href="/password-super/reset" class="text-decoration-none text-secondary">Forgot your password?</a>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            </form>
            <!-- End Login Form -->

            <div class="d-flex justify-content-center mt-3">
                <div class="d-flex justify-content-between">
                    <small> Don't have an account? 
                        <a class="" href="/register-super" class="text-decoration-none">Register now</a>
                    </small>
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
<script src="assets/js/main.js"></script>

<!-- Footer -->
    <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; DIRGANTARA INDONESIA 2024</span>
                    </div>
                </div>
            </footer>
        <!-- End of Footer -->
</body>