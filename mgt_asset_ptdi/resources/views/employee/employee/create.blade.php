<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Employee</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

@extends('employee.master')

@section('content')
<div class="container section-title" data-aos="fade-up">
    <h2>Tambah Employee</h2>
</div><!-- End Section Title -->

<div class="container">
    <div class="row g-5 d-flex justify-content-center">
        <div class="col-lg-10 col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-gray">Tambah Employee</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden;">
                        <form action="/employee" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Left Section -->
                                <div class="col-12 col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama" class="form-label">Nama Employee</label>
                                            <input type="text" name="nama" id="nama" placeholder="Masukkan Nama" class="form-control" value="{{ old('nama') }}" required>
                                        </div>
                                        @error('nama')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                  
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nik" class="form-label">NIK Employee</label>
                                            <input type="text" name="nik" id="nik" placeholder="Masukkan NIK" class="form-control" value="{{ old('nik') }}"  required>
                                            <div id="nik-status" class="text-danger"></div> 
                                        </div>
                                        @error('nik')
                                            <div class="alert alert-danger text-center">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password Employee</label>
                                            <input type="password" name="password" id="password" placeholder="Masukkan Password" class="form-control" value="{{ old('password') }}"  required>
                                        </div>
                                        @error('password')
                                            <div class="alert alert-danger text-center">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Section -->
                                <div class="col-12 col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="kode_org" class="form-label">Organisasi</label>
                                            <div class="dropdown">
                                                <button class="btn text-start dropdown-toggle" type="button" id="dropdownMenuButtonOrg" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{ old('kode_org', isset($item) ? $item->kode_org . ' - ' . $item->org->nama : '-- Pilih Organisasi --') }}
                                                </button>
                                                <ul class="dropdown-menu" name="org" aria-labelledby="dropdownMenuButtonOrg">
                                                    <input type="text" id="search-org" class="form-control mt-2" placeholder="Cari Organisasi..." onkeyup="filterOptionsOrg(event)">
                                                    @forelse ($org as $item)
                                                        <li><a class="dropdown-item" href="#" name="kode_org" data-value="{{ $item->kode_org }}">{{ $item->kode_org }} - {{ $item->nama }}</a></li>
                                                    @empty
                                                        <li><a class="dropdown-item" href="#">Tidak Ada Organisasi</a></li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                    
                                            <input type="hidden" id="selected-kode-org" name="kode_org" value="">
                                        </div>
                                        @error('kode_org')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="kode_jabatan" class="form-label">Jabatan</label>
                                            <div class="dropdown">
                                                <button class="btn text-start dropdown-toggle" type="button" id="dropdownMenuButtonJabatan" data-bs-toggle="dropdown" aria-expanded="false">
                                                    -- Pilih Jabatan --
                                                </button>
                                                <ul class="dropdown-menu" name="jabatan" aria-labelledby="dropdownMenuButtonJabatan">
                                                    <input type="text" id="search-jabatan" class="form-control mt-2" placeholder="Cari Jabatan..." onkeyup="filterOptionsJabatan()">
                                                    @forelse ($jabatan as $item)
                                                        <li><a class="dropdown-item" href="#" name="kode_jabatan" data-value="{{ $item->id }}">{{ $item->nama }}</a></li>
                                                    @empty
                                                        <li><a class="dropdown-item" href="#">Tidak Ada Jabatan</a></li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                            <input type="hidden" id="selected-kode-jabatan" name="kode_jabatan" value="">
                                        </div>
                                        @error('kode_jabatan')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end me-5" style="margin-top:20%; width:100%">
                                        <a href="/employee" class="btn btn-danger me-2" style="width:45%;">Cancel</a>
                                        <button type="submit" class="btn btn-primary me-2" style="width:45%;">Tambah</button>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('#nik').on('keyup blur', function () {
           let nik = $(this).val();
           if (nik.length === 0) {
               $('#nik-status').text('NIK harus diisi').removeClass('text-success').addClass('text-danger');
               return;
           }
   
           $.ajax({
               url: "{{ route('fetch-user-data') }}",
               type: 'GET',
               data: { nik: nik },
               success: function (response) {
                   if (response.success) {
                       $('#nik-status').text('NIK sudah ada').removeClass('text-success').addClass('text-danger');
                   } else {
                       $('#nik-status').text('NIK belum terdaftar').removeClass('text-danger').addClass('text-success');
                   }
               },
               error: function (xhr) {
                   $('#nik-status').text('Terjadi kesalahan pada server').removeClass('text-success').addClass('text-danger');
               }
           });
       }); 
       $(document).ready(function () {
    $('.dropdown-menu').on('click', '.dropdown-item', function () {
        var orgCode = $(this).data('value');
        if ($(this).attr("name") === "kode_org") {
            $('#selected-kode-org').val(orgCode);
            $('#dropdownMenuButton').text($(this).text());
        } else if ($(this).attr("name") === "kode_jabatan") {
            $('#selected-kode-jabatan').val(orgCode);
            $('#dropdownMenuJabatan').text($(this).text());
        }
    });
    $('#dropdownMenuButtonJabatan').on('click', function () {
        setTimeout(function () {
            $('#search-jabatan').focus();
        }, 200); 
    });

    $('#dropdownMenuButtonOrg').on('click', function () {
        setTimeout(function () {
            $('#search-org').focus();
        }, 200); 
    });


    document.querySelectorAll('.dropdown-menu[name="org"] .dropdown-item').forEach(item => {
        item.addEventListener('click', function() {
            var orgName = this.textContent;
            var orgCode = this.getAttribute('data-value');

            document.getElementById('dropdownMenuButtonOrg').textContent = orgName;
            document.getElementById('selected-kode-org').value = orgCode;
        });
    });

    document.querySelectorAll('.dropdown-menu[name="jabatan"] .dropdown-item').forEach(item => {
        item.addEventListener('click', function() {
            var jabatanName = this.textContent;
            var jabatanId = this.getAttribute('data-value');

            document.getElementById('dropdownMenuButtonJabatan').textContent = jabatanName;

            document.getElementById('selected-kode-jabatan').value = jabatanId;
        });
    });
    function filterOptionsOrg() {
        var searchValue = document.getElementById('search-org').value.toLowerCase();
        var options = document.querySelectorAll('.dropdown-menu[name="org"] .dropdown-item');
        filterDropdown(options, searchValue);
    }

    function filterOptionsJabatan() {
        var searchValue = document.getElementById('search-jabatan').value.toLowerCase();
        var options = document.querySelectorAll('.dropdown-menu[name="jabatan"] .dropdown-item');
        filterDropdown(options, searchValue);
    }

    function filterDropdown(options, searchValue) {
        var found = false;

        options.forEach(function(option) {
            var text = option.textContent || option.innerText;
            if (text.toLowerCase().indexOf(searchValue) > -1) {
                option.style.display = "";
                found = true;
            } else {
                option.style.display = "none";
            }
        });

        var noDataItem = document.querySelector('.no-data');
        if (!found) {
            if (!noDataItem) {
                var li = document.createElement('li');
                li.classList.add('dropdown-item', 'no-data');
                li.textContent = "Tidak Ada Data";
                options[0].parentNode.appendChild(li);
            }
        } else {
            if (noDataItem) {
                noDataItem.remove();
            }
        }
    }

    document.getElementById('search-org').addEventListener('keyup', filterOptionsOrg);
    document.getElementById('search-jabatan').addEventListener('keyup', filterOptionsJabatan);
});

</script>

@endsection
