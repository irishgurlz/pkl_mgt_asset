<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Choose Role</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style></style>

  <link href="{{asset('template/assets/img/ptdi.png')}}" rel="icon" type="image/png">


  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <link href="{{ asset('template/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('template/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('template/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('template/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('template/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <link href="{{ asset('template/assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page light-background">

  <main class="main">
    <section id="pricing" class="pricing section light-background">
      <div class="container section-title" data-aos="fade-up">
        <h2>Choose your role!</h2>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4 justify-content-center">
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div id="login-card" class="pricing-card">
              <form action="{{ route('role-selection') }}" method="POST">
                @csrf
                <div class="row mb-4 justify-content-center">
                  <div class="col col-1">
                    <img src="{{ asset('img/ptdi.png') }}" alt="Logo PTDI" width="45" height="45">
                  </div>
                  <div class="col col-10 text-center mt-2">
                    <h3>Dirgantara Indonesia</h3>
                  </div>
                </div>

                <div class="mb-3">
                  <button type="submit" name="role" class="btn btn-cta" value="admin">Admin</button>
                </div>
                <div class="mb-3">
                  <button type="submit" name="role" class="btn btn-cta" value="karyawan">Karyawan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </section>
  </main>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('template/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('template/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('template/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('template/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('template/assets/js/main.js') }}"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
