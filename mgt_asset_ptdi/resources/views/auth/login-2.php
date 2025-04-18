<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom transition for card switching */
    .card-transition-enter {
      transform: translateX(100%);
      opacity: 0;
      transition: all 0.5s ease-in-out;
    }

    .card-transition-enter-active {
      transform: translateX(0);
      opacity: 1;
    }

    .card-transition-exit {
      transform: translateX(0);
      opacity: 1;
      transition: all 0.5s ease-in-out;
    }

    .card-transition-exit-active {
      transform: translateX(-100%);
      opacity: 0;
    }
    .sticky-footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 80px 0;
    z-index: 1000;
  }
  </style>

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

  <main class="main">
  <section id="pricing" class="pricing section light-background">
   
   <!-- Section Title -->
   <div class="container section-title" data-aos="fade-up">
        <h2>Login to your account!</h2>
      </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row g-4 justify-content-center">
        <!-- Basic Plan -->
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div id= "login-card" class="pricing-card">
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
                <label for="nik" class="form-label">NIK</label>
                <input type="text" id="nik" name="nik" class="form-control" placeholder="Masukkan NIK" required>
                @error('nik')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Password Input -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Remember Me -->
              <div class="form-check mb-3">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Remember Me</label>
              </div>
              <!-- Submit Button -->
              <div class="d-grid">
                <button id="btn-login" type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
            <!-- End Login Form -->

            <div class="text-center mt-3">
              <a href="" class="text-decoration-none">Forgot your password?</a>
            </div>

          </div>
      <!-- Card 2: Role Selection -->
      <div id="role-card" class="pricing-card d-none">
          <h3 class="text-center mb-4">Select your role</h3>
          <div class="d-flex flex-column gap-3">
            <button class="btn btn-cta">Admin</button>
            <button class="btn btn-cta">Karyawan</button>
          </div>
          <div class="mt-4 text-center">
            <button id="back-to-login" class="btn btn-link">Back to Login</button>
          </div>
        </div>
        
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
document.addEventListener('DOMContentLoaded', () => {
  const loginCard = document.getElementById('login-card');
  const roleCard = document.getElementById('role-card');
  const btnLogin = document.getElementById('btn-login');
  const backToLogin = document.getElementById('back-to-login');

  roleCard.classList.add('d-none'); // Pastikan roleCard disembunyikan di awal

  btnLogin.addEventListener('click', (event) => {
    event.preventDefault(); // Mencegah form melakukan submit
    loginCard.classList.add('card-transition-exit-active');
    setTimeout(() => {
      loginCard.classList.add('d-none');
      loginCard.classList.remove('card-transition-exit-active');
      roleCard.classList.remove('d-none');
      roleCard.classList.add('card-transition-enter');
      setTimeout(() => roleCard.classList.remove('card-transition-enter'), 500);
    }, 500);
  });

  backToLogin.addEventListener('click', (event) => {
    event.preventDefault(); // Mencegah form melakukan submit
    roleCard.classList.add('card-transition-exit-active');
    setTimeout(() => {
      roleCard.classList.add('d-none');
      roleCard.classList.remove('card-transition-exit-active');
      loginCard.classList.remove('d-none');
      loginCard.classList.add('card-transition-enter');
      setTimeout(() => loginCard.classList.remove('card-transition-enter'), 500);
    }, 500);
  });
});
  </script>

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
</html>