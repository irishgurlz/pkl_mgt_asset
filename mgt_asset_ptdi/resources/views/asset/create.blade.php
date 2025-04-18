<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tambah Perlengkapan Kantor</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

@extends('endpoint device.endpointLayout')

@section('content')
    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class="section-title" data-aos="fade-up">
            <h2>Tambah Perlengkapan kantor</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <div class="row g-5 d-flex justify-content-center">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow:hidden">
                            <!-- TAMBAH PERLENGKAPAN -->
                            <div class="mt-3">
                                <form action="/asset" id="form-add-asset" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                            
                                
                                    <div class="row">
                                        <form action="/distribution-asset" id="form-add-asset" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif
                                        
                                        
                                            <div class="row">
                                                <div class="card-body">
                                                        <!-- Nomor PMN -->
                                                        <div class="form-group mb-3">
                                                        <label for="no_pmn" class="form-label">Nomor PMN</label>
                                                        <input type="text" id="no_pmn" name="no_pmn" value="{{ old('no_pmn') }}" placeholder="Masukkan Nomor PMN" class="form-control" required>
                                                        <div id="no_pmn-status" class="text-danger"></div> 
                                                        @error('no_pmn')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Nomor Asset -->
                                                    <div class="form-group mb-3">
                                                        <label for="nomor_asset" class="form-label">Nomor Asset</label>
                                                        <input type="text" name="nomor_asset" id="nomor_asset"  value="{{ old('nomor_asset') }}" placeholder="Masukkan Nomor Asset" class="form-control" onkeyup="fetchAssetData()" required>
                                                        <div id="nomor-asset-status" class="text-danger"></div>
                                                        @error('nomor_asset')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                            

                                                    <div class="form-group">
                                                        <label for="id_kategori" class="form-label">Kategori</label>
                                                        <div class="dropdown">
                                                            <button class="btn text-start dropdown-toggle" type="button" id="dropdownMenuButtonKategori" data-bs-toggle="dropdown" aria-expanded="false">
                                                                @if(old('id_kategori'))
                                                                    {{ $kategori->find(old('id_kategori'))->nama ?? '-- Pilih Kategori --' }}  {{-- Display old value if exists and find the name, or default --}}
                                                                @else
                                                                    -- Pilih Kategori --
                                                                @endif
                                                            </button>
                                                            <ul class="dropdown-menu" name="id_kategori" aria-labelledby="dropdownMenuButtonKategori">
                                                                <input type="text" id="search-kategori" class="form-control mt-2" placeholder="Cari Organisasi..." onkeyup="filterOptionsKategori(event)">
                                                                @forelse ($kategori as $item)
                                                                    <li><a class="dropdown-item @if(old('id_kategori') == $item->id) active @endif" href="#" name="id_kategori" data-value="{{ $item->id }}">{{ $item->nama }}</a></li>
                                                                @empty
                                                                    <li><a class="dropdown-item" href="#">Tidak Ada Kategori</a></li>
                                                                @endforelse
                                                            </ul>
                                                        </div>
                                                
                                                        <input type="hidden" id="selected-id-kategori" name="id_kategori" value="">
                                                    </div>
                                                    @error('id_kategori')
                                                        <div class="error">{{ $message }}</div>
                                                    @enderror    
                                                    
                                                    <!-- Sub Kategori -->
                                                    <div class="form-group mb-3">
                                                        <label for="id_tipe" class="form-label">Sub Kategori</label>
                                                        <div class="dropdown">
                                                            <button class="btn text-start dropdown-toggle" type="button" id="dropdownTipe" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <span id="selected-tipe-text">-- Pilih Sub Kategori --</span>
                                                            </button>
                                                            <ul class="dropdown-menu"  name="id_tipe" aria-labelledby="dropdownTipe">
                                                                <li><input type="text" id="search-sub" class="form-control" placeholder="Cari Sub Kategori..." onkeyup="filterOptionsSub(event)"></li>
                                                                <div id="tipe-list">
                                                                </div>
                                                            </ul>
                                                        </div>
                                                        <input type="hidden" id="id_tipe" name="id_tipe" value="{{ old('id_tipe') }}">
                                                        @error('id_tipe')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                            
                                                    <!-- Umur -->
                                                    <div class="form-group mb-3">
                                                        <label for="umur" class="form-label">Umur</label>
                                                        <input type="date" name="umur" id="umur" placeholder="Masukkan Tanggal" class="form-control" value="{{old('umur')}}"required>
                                                        <input type="text" id="calculatedAge" placeholder="Umur dalam tahun" class="form-control mt-2" readonly>
                                                        @error('umur')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            const umurInput = document.getElementById('umur');
                                                            const calculatedAge = document.getElementById('calculatedAge');

                                                            if (umurInput.value) {
                                                                const inputDate = new Date(umurInput.value);
                                                                const today = new Date();
                                                                
                                                                if (inputDate > today) {
                                                                    calculatedAge.value = "Tanggal tidak valid";
                                                                    return;
                                                                }

                                                                let age = today.getFullYear() - inputDate.getFullYear();
                                                                const monthDiff = today.getMonth() - inputDate.getMonth();
                                                                const dayDiff = today.getDate() - inputDate.getDate();

                                                                if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                                                                    age--;
                                                                }

                                                                calculatedAge.value = age + " tahun";
                                                            }

                                                            umurInput.addEventListener('change', function () {
                                                                const inputDate = new Date(this.value);
                                                                const today = new Date();

                                                                if (inputDate > today) {
                                                                    calculatedAge.value = "Tanggal tidak valid";
                                                                    return;
                                                                }

                                                                let age = today.getFullYear() - inputDate.getFullYear();
                                                                const monthDiff = today.getMonth() - inputDate.getMonth();
                                                                const dayDiff = today.getDate() - inputDate.getDate();

                                                                if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                                                                    age--;
                                                                }

                                                                calculatedAge.value = age + " tahun";
                                                            });
                                                        });
                                                    </script>
                                                

                                                    <div class="form-group mt-3">
                                                        <label for="kondisi" class="form-label">Kondisi Perlengkapan</label>
                                                        <select name="kondisi" id="kondisi" class="form-select" required>
                                                            <option value="" disabled {{ old('kondisi') ? '' : 'selected' }}>-- Pilih Kondisi --</option>
                                                            <option value="1" {{ old('kondisi') == '1' ? 'selected' : '' }}>Baik</option>
                                                            <option value="0" {{ old('kondisi') == '0' ? 'selected' : '' }}>Rusak</option>
                                                        </select>
                                                        @error('kondisi')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    </div>
                                                    
                                                    <div class="form-group mt-3">
                                                        <label for="foto" class="form-label">Foto Kondisi (.jpg)</label>
                                                        <input type="file" name="foto" class="form-control" value="" accept=".jpg, .jpeg, .png">
                                                        @error('foto')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Tombol Submit -->
                                    <div id="tambah-asset-button">
                                        <div class="d-flex justify-content-end mb-3">
                                            <a href="/asset" type="button" class="btn btn-danger me-2" style="width: 120px;">Batal</a>
                                            <button type="submit" id="submit-btn" class="btn btn-primary" style="width: 120px;">Tambah</button>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
   </div>


   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Event listener untuk kategori
            document.querySelectorAll(".dropdown-menu a.dropdown-item").forEach(item => {
                item.addEventListener("click", function (e) {
                    e.preventDefault();

                    let selectedId = this.getAttribute("data-value");
                    let selectedText = this.textContent.trim();

                    document.getElementById("dropdownMenuButtonKategori").innerText = selectedText;
                    document.getElementById("selected-id-kategori").value = selectedId;

                    loadSubKategori(selectedId);
                });
            });
        });

        function loadSubKategori(idKategori) {
            fetch(`/get-sub-by-kategori/${idKategori}`)
                .then(response => response.json())
                .then(data => {
                    let tipeList = document.getElementById("tipe-list");
                    let selectedTipeText = document.getElementById("selected-tipe-text");
                    let tipeInput = document.getElementById("id_tipe");

                    tipeList.innerHTML = "";
                    tipeInput.value = "";
                    selectedTipeText.innerText = "-- Pilih Sub Kategori --";

                    if (data.length > 0) {
                        data.forEach(sub => {
                            let listItem = document.createElement("li");
                            listItem.innerHTML = `<a class="dropdown-item" href="#" data-value="${sub.id}">${sub.nama}</a>`;
                            listItem.addEventListener("click", function (e) {
                                e.preventDefault();
                                selectedTipeText.innerText = sub.nama;
                                tipeInput.value = sub.id;
                            });
                            tipeList.appendChild(listItem);
                        });
                    } else {
                        tipeList.innerHTML = `<li><a class="dropdown-item" href="#">Tidak Ada Sub Kategori</a></li>`;
                    }
                })
                .catch(error => console.error("Error:", error));
        }

       $('#no_pmn').on('keyup blur', function () {
           let no_pmn = $(this).val();
           if (no_pmn.length === 0) {
               $('#no_pmn-status').text('Nomor PMN harus diisi').removeClass('text-success').addClass('text-danger');
               return;
           }
   
           $.ajax({
               url: "{{ route('fetchNoPMN') }}",
               type: 'GET',
               data: { no_pmn: no_pmn },
               success: function (response) {
                   if (response.success) {
                       $('#no_pmn-status').text('Nomor PMN tersedia').removeClass('text-danger').addClass('text-success');
                   } else {
                       $('#no_pmn-status').text('Nomor PMN belum terdaftar').removeClass('text-success').addClass('text-danger');
                   }
               }
           });
       });
   
       $('#nomor_asset').on('input', function () {
           let nomor_asset = $(this).val();
   
           if (nomor_asset) {
               $.ajax({
                   url: '{{ route('checkNomorAsset') }}',
                   type: 'POST',
                   data: {
                       nomor_asset: nomor_asset,
                       _token: '{{ csrf_token() }}'
                   },
                   success: function (response) {
                       if (response.status === 'available') {
                           $('#nomor-asset-status').text('Nomor asset tersedia').removeClass('text-danger').addClass('text-success');
                           $('#submit-btn').prop('disabled', false);
                       } else if (response.status === 'taken') {
                           $('#nomor-asset-status').text('Nomor asset sudah terdaftar').removeClass('text-success').addClass('text-danger');
                           $('#submit-btn').prop('disabled', true);
                       }
                   }
               });
           } else {
               $('#nomor-asset-status').text('');
               $('#submit-btn').prop('disabled', false);
           }
       });
   
   $(document).ready(function () {
    $('.dropdown-menu').on('click', '.dropdown-item', function () {
        var orgCode = $(this).data('value');
        if ($(this).attr("name") === "id_kategori") { 
            $('#selected-id-kategori').val(orgCode);
            $('#dropdownMenuButtonKategori').text($(this).text());
        } else if ($(this).attr("name") === "id_tipe") {
            $('#id_tipe').val(orgCode);
            $('#dropdownTipe').text($(this).text());
        }
    });

    $('#dropdownMenuButtonKategori').on('click', function () {
        setTimeout(function () {
            $('#search-kategori').focus();
        }, 200); 
    });
    $('#dropdownTipe').on('click', function () {
        setTimeout(function () {
            $('#search-sub').focus();
        }, 200); 
    });


    function filterOptionsKategori() {
        var searchValue = document.getElementById('search-kategori').value.toLowerCase();
        var options = document.querySelectorAll('.dropdown-menu[name="id_kategori"] .dropdown-item');
        filterDropdown(options, searchValue);
    }

    function filterOptionsSub() {
        var searchValue = document.getElementById('search-sub').value.toLowerCase();
        var options = document.querySelectorAll('.dropdown-menu[name="id_tipe"] .dropdown-item');
        filterDropdown(options, searchValue);
    }

    function filterDropdown(options, searchValue) {
        var found = false;

        if (options.length > 0) {
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

                    if (options[0] && options[0].parentNode) {
                        options[0].parentNode.appendChild(li);
                    }
                }
            } else {
                if (noDataItem) {
                    noDataItem.remove();
                }
            }
        }
    }

    document.getElementById('search-kategori').addEventListener('keyup', filterOptionsKategori);
    document.getElementById('search-sub').addEventListener('keyup', filterOptionsSub);
});


   </script>
   
@endsection