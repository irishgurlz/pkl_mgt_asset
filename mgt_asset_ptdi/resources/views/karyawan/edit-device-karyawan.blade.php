<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Edit Perangkat Komputer</title>
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
        <div class ="section-title mt-3" data-aos="fade-up" style="padding-bottom: 10px">
            <h2>Edit Perangkat Komputer</h2>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="md-6 d-flex justify-content-center">
            <div class="card shadow mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('updateDevice', $device->nomor_it) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3">
                                <label for="nomor_it" class="form-label">Nomor Asset</label>
                                <input type="text" name="nomor_it" id="nomor_it" class="form-control" value="{{ $device->nomor_it }}" disabled>    
                            </div>
                            <div class="mb-3">
                                <label for="kategori_text" class="form-label">Kategori</label>
                                <input type="text" id="kategori_text" class="form-control" value="{{ $device->kategori->nama }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="sub_kategori_text" class="form-label">Tipe Perangkat</label>
                                <input type="text" id="sub_kategori_text" class="form-control" value="{{ $device->subKategori->nama }}" disabled>
                            </div>
                        </div>
                                            
                        <div class="row">
                            <div class = "col col-6">
                                <!-- Storage Type -->
                                <div class="form-group mb-3">
                                    <label for="storage_type" class="form-label">Storage Type</label>
                                    <select name="storage_type" id="storage_type" class="form-control">
                                        <option value="" disabled {{ old('storage_type') ? '' : 'selected' }}>-- Pilih Storage Type --</option>
                                        @foreach ($storageType as $item)
                                            <option value="{{$item->id}}" {{ old('storage_type', $device->storage_type) == $item->id ? 'selected' : '' }}>
                                                {{$item->nama}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Memory Type -->
                                <div class="form-group mb-3">
                                    <label for="memory_type" class="form-label">Memory Type</label>
                                    <select name="memory_type" id="memory_type" class="form-control">
                                        <option value="" disabled {{ old('memory_type') ? '' : 'selected' }}>-- Pilih Memory Type --</option>
                                        @foreach ($memoryType as $item)
                                            <option value="{{$item->id}}" {{ old('memory_type', $device->memory_type) == $item->id ? 'selected' : '' }}>
                                                {{$item->nama}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- VGA Type -->
                                <div class="form-group mb-3">
                                    <label for="vga_type" class="form-label">VGA Type</label>
                                    <select name="vga_type" id="vga_type" class="form-control">
                                        <option value="" disabled {{ old('vga_type') ? '' : 'selected' }}>-- Pilih VGA Type --</option>
                                        @foreach ($VGAType as $item)
                                            <option value="{{$item->id}}" {{ old('vga_type', $device->vga_type) == $item->id ? 'selected' : '' }}>
                                                {{$item->nama}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>

                                <div class="col col-6">
                                <!-- Storage Capacity -->
                                <div class="form-group mb-3">
                                    <label for="storage_capacity" class="form-label">Storage Capacity</label>
                                    <input type="text" name="storage_capacity" id="storage_capacity" value="{{old('storage_capacity', $device->storage_capacity)}}" placeholder="Storage Capacity                                     GB" class="form-control" required>
                                    @error('storage_capacity')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <!-- Memory Capacity -->
                                <div class="form-group mb-3">
                                    <label for="memory_capacity" class="form-label">Memory Capacity</label>
                                    <input type="text" name="memory_capacity" id="memory_capacity" value="{{old('memory_capacity', $device->memory_capacity)}}" placeholder="Memory Capacity                                    GB" class="form-control" required>
                                    @error('memory_capacity')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <!-- VGA Capacity -->
                                <div class="form-group mb-3">
                                    <label for="vga_capacity" class="form-label">VGA Capacity</label>
                                    <input type="text" name="vga_capacity" id="vga_capacity" value="{{old('vga_capacity', $device->vga_capacity)}}" placeholder="VGA Capacity                                           GB" class="form-control" required>
                                    @error('vga_capacity')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col col-6"></div>
                            <div class="col col-6 d-flex gap-2 justify-content-end">
                                <a href="{{ route('karyawan.dashboard') }}" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </div>
            </form>
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

<script src="assets/js/main.js"></script>
