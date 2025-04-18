<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Perlengkapan Kantor</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')
    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class="section-title" data-aos="fade-up">
            <h2>Edit Perlengkapan Kantor</h2>
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
                                <form action="/asset/{{$asset->id}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                            
                                
                                    <div class="row">
                                        <form action="/" id="form-add-asset" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif
                                        
                                        
                                            <div class="row">
                                                <div>
                                                    <div class="card shadow mb-3">
                                                        <div class="card-header py-3 text-center">
                                                            <h6 class="m-0 font-weight-bold text-gray">Perlengkapan Kantor</h6>
                                                        </div>
                                    
                                                        <div class="card-body">
                                                            <!-- Nomor Asset -->
                                                            <div class="form-group mb-3">
                                                                <label for="nomor_asset" class="form-label">Nomor Asset</label>
                                                                <input type="text" name="nomor_asset" id="nomor_asset" placeholder="Masukkan Nomor Asset" class="form-control bg-light" onkeyup="fetchAssetData()" value="{{ old('nomor_asset', $asset->nomor_asset) }}"readonly>
                                                                <div id="nomor_asset-status" style="color: red; font-size: 14px;"></div>
                                                                @error('nomor_asset')
                                                                    <div class="alert alert-danger">{{$message}}</div>
                                                                @enderror
                                                            </div>
                                    
                                                            <!-- Nomor PMN -->
                                                            <div class="form-group mb-3">
                                                                <label for="no_pmn" class="form-label">Nomor PMN</label>
                                                                <input type="text" id="no_pmn" name="no_pmn" class="form-control bg-light" value="{{ old('no_pmn', $asset->no_pmn) }}" readonly>
                                                                @error('no_pmn')
                                                                    <div class="alert alert-danger">{{$message}}</div>
                                                                @enderror
                                                            </div>
                                    
                                                            <!-- Kategori -->
                                                            <div class="form-group mb-3">
                                                                <label for="id_kategori" class="form-label">Kategori</label>
                                                                <select id="id_kategori" name="id_kategori" class="form-control" required>
                                                                    <option value="" disabled {{ old('id_kategori') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                                                    @foreach ($kategori as $item)
                                                                        <option value="{{ $item->id }}" {{ old('id_kategori', $asset->id_kategori ?? '') == $item->id ? 'selected' : '' }}>
                                                                            {{ $item->nama }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('id_kategori')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Sub Kategori -->
                                                            <div class="form-group mb-3">
                                                                <label for="id_tipe" class="form-label">Sub Kategori</label>
                                                                <div class="dropdown">
                                                                    <button class="btn text-start dropdown-toggle" type="button" id="dropdownTipe" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <span id="selected-tipe-text">-- Pilih Sub Kategori --</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownTipe" style="min-width: 1180px;">
                                                                        <li>
                                                                            <input type="text" class="form-control" placeholder="Cari Sub Kategori..." onkeyup="filterOptions(event, 'tipe')">
                                                                        </li>
                                                                        <div id="tipe-list"></div>
                                                                    </ul>
                                                                </div>
                                                                <input type="hidden" id="id_tipe" name="id_tipe" value="{{ old('id_tipe', $asset->id_tipe ?? '') }}">
                                                                @error('id_tipe')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                    
                                                            <div class="form-group mb-3">
                                                                <label for="umur" class="form-label">Umur</label>
                                                                <input type="date" name="umur" id="umur" placeholder="Masukkan Tanggal" class="form-control" value="{{old('umur', $asset->umur)}}"required>
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
                                                                <div>
                                                                <select name="kondisi" id="kondisi" class="form-select" required>
                                                                    <option value="" disabled {{ old('kondisi') ? '' : 'selected' }}>-- Pilih Kondisi --</option>
                                                                    <option value="1" {{ old('kondisi', $asset->kondisi) == '1' ? 'selected' : '' }}>Baik</option>
                                                                    <option value="0" {{ old('kondisi', $asset->kondisi) == '0' ? 'selected' : '' }}>Rusak</option>
                                                                </select>
                                                                </div>
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
                                            <button type="submit" class="btn btn-primary" style="width: 120px;">Tambah</button>
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
document.addEventListener('DOMContentLoaded', function() {  
    const kategoriDropdown = document.getElementById('id_kategori');
    const tipeDropdownButton = document.getElementById('dropdownTipe');
    const tipeDropdownList = document.getElementById('tipe-list');
    const selectedTipeInput = document.getElementById('id_tipe');
    const selectedTipeText = document.getElementById('selected-tipe-text');

    const oldValue = selectedTipeInput.value; 

    if (kategoriDropdown && kategoriDropdown.value) {
        loadSubcategories(kategoriDropdown.value, oldValue);
    }

    kategoriDropdown.addEventListener('change', function() {
        loadSubcategories(this.value);
    });

    tipeDropdownList.addEventListener('click', function(event) {
        if (event.target.classList.contains('dropdown-item')) {
            event.preventDefault();
            const selectedText = event.target.textContent;
            const selectedValue = event.target.dataset.value;

            selectedTipeText.textContent = selectedText;
            selectedTipeInput.value = selectedValue;

            const dropdown = tipeDropdownButton.closest('.dropdown');
            const bsDropdown = new bootstrap.Dropdown(dropdown);
            bsDropdown.hide();
        }
    });

    function loadSubcategories(kategoriId, oldValue = null) {
        tipeDropdownList.innerHTML = ''; 
        selectedTipeText.textContent = '-- Pilih Sub Kategori --'; 
        selectedTipeInput.value = '';

        if (kategoriId) {
            fetch(`/get-sub-by-kategori/${kategoriId}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        data.forEach(item => {
                            const li = document.createElement('li');
                            const a = document.createElement('a');
                            a.classList.add('dropdown-item');
                            a.href = '#';
                            a.dataset.value = item.id;
                            a.textContent = item.nama;
                            li.appendChild(a);
                            tipeDropdownList.appendChild(li);

                            if (oldValue && oldValue == item.id) {
                                selectedTipeText.textContent = item.nama;
                                selectedTipeInput.value = item.id;
                            }
                        });
                    } else {
                        const li = document.createElement('li');
                        const a = document.createElement('a');
                        a.classList.add('dropdown-item', 'disabled');
                        a.href = '#';
                        a.textContent = 'Tidak Ada Sub Kategori';
                        li.appendChild(a);
                        tipeDropdownList.appendChild(li);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }
});
    function filterOptions(event, type) {
    var searchValue = event.target.value.toLowerCase();
    var options = $('#' + type + '-list .dropdown-item').not('.no-data');
    var found = false;

    options.each(function () {
        var text = $(this).text().toLowerCase();
        if (text.includes(searchValue)) {
            $(this).parent().show();
            found = true;
        } else {
            $(this).parent().hide();
        }
    });

    if (!found) {
        if ($('#' + type + '-list .no-data').length === 0) {
            $('#' + type + '-list').append('<li class="no-data"><a class="dropdown-item" href="#">Tidak Ada Data</a></li>');
        }
    } else {
        $('#' + type + '-list .no-data').remove();
    }
}

</script>
@endsection
