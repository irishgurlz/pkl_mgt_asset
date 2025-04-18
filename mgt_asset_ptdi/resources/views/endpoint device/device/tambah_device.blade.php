<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tambah Perangkat Komputer</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')

<!-- TITLE -->
<div class="container section-title" data-aos="fade-up">
    <h2>Tambah Perangkat Komputer</h2>
</div><!-- End Section Title -->
  <div class="container">
    <div class="row g-5 d-flex justify-content-center">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive" style="overflow:hidden">
                    <form action="{{route('device.store')}}" id="form-add-device" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3">
                                <label for="no_pmn" class="form-label">Nomor PMN</label>
                                <input type="text" name="no_pmn" id="no_pmn" value="{{ old('no_pmn') }}" placeholder="Masukkan Nomor PMN" class="form-control" required>
                                    <div id="no_pmn-status" class="text-danger"></div> 
                                    @error('no_pmn')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                        </div>

                        <div class="row">
                        <div class=" col col-6">
                            <div>
                            <!-- Card Perangkat -->
                            <div class="card shadow mb-3">
                                <div class="card-header py-3 text-center">
                                    <h6 class="m-0 font-weight-bold text-gray">Perangkat</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Nomor IT -->
                                        <div class="form-group mb-3">
                                            <label for="nomor_it" class="form-label">Nomor Asset</label>
                                            <input type="text" name="nomor_it" id="nomor_it" class="form-control" value="{{ old('nomor_it') }}" placeholder="Masukkan Nomor Asset" class="form-control" required>
                                            <div id="nomor-it-status" class="text-danger"></div>
                                            @error('nomor_it')
                                                <div class="alert alert-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                            <!-- Kategori -->
                                            <div class="form-group mb-3">
                                                <label for="id_kategori" class="form-label">Kategori</label>
                                                <select id="id_kategori" name="id_kategori" class="form-control" required>
                                                    <option value="" disabled {{ old('id_kategori') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                                    @foreach ($kategori as $item)  {{-- Assuming you have a $kategori collection --}}
                                                        <option value="{{ $item->id }}" {{ old('id_kategori') == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
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
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownTipe" style="min-width: 585px;">
                                                        <li><input type="text" class="form-control" placeholder="Cari Sub Kategori..." onkeyup="filterOptions(event, 'tipe')"></li>
                                                        <div id="tipe-list"></div>
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
                                        </div>
                                        <!-- Kolom Pertama -->
                                        <div class="row">
                                            <div class=" col col-6">
                                                <!-- Processor -->
                                                <div class="dropdown mb-3">
                                                    <label for="processor" class="form-label">Processor</label>
                                                    <button class="btn text-start dropdown-toggle" type="button" id="dropdownProcessor" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if(old('processor'))
                                                            {{ $processor->find(old('processor'))->nama ?? '-- Pilih Processor --' }}
                                                        @else
                                                            -- Pilih Processor --
                                                        @endif
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownProcessor">
                                                        <li>
                                                            <input type="text" id="search-processor" class="form-control" placeholder="Cari Processor..." onkeyup="filterOptions(event, 'processor')">
                                                        </li>
                                                        <div id="processor-list">
                                                            @forelse ($processor as $item)
                                                                <li><a class="dropdown-item @if(old('processor') == $item->id) active @endif" href="#" name="processor" data-value="{{ $item->id }}">{{ $item->nama }}</a></li>
                                                            @empty
                                                                <li class="no-data"><a class="dropdown-item" href="#">Tidak Ada Data</a></li>
                                                            @endforelse
                                                        </div>
                                                    </ul>
                                                </div>
                                                <input type="hidden" id="selected-processor" name="processor" value="{{ old('processor') }}">

                                                <div class="dropdown mb-3">
                                                    <label for="storage_type" class="form-label">Storage Type</label>
                                                    <button class="btn text-start dropdown-toggle" type="button" id="dropdownStorage" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if(old('storage_type'))
                                                            {{ $storageType->find(old('storage_type'))->nama ?? '-- Pilih Storage Type --' }}
                                                        @else
                                                            -- Pilih Storage Type --
                                                        @endif
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownStorage">
                                                        <li>
                                                            <input type="text" id="search-storage" class="form-control" placeholder="Cari Storage Type..." onkeyup="filterOptions(event, 'storage')">
                                                        </li>
                                                        <div id="storage-list">
                                                            @forelse ($storageType as $item)
                                                                <li><a class="dropdown-item @if(old('storage_type') == $item->id) active @endif" href="#" name="storage_type" data-value="{{ $item->id }}">{{ $item->nama }}</a></li>
                                                            @empty
                                                                <li class="no-data"><a class="dropdown-item" href="#">Tidak Ada Data</a></li>
                                                            @endforelse
                                                        </div>
                                                    </ul>
                                                </div>
                                                <input type="hidden" id="selected-storage" name="storage_type" value="{{ old('storage_type') }}">

                                                <div class="dropdown mb-3">
                                                    <label for="memory_type" class="form-label">Memory Type</label>
                                                    <button class="btn text-start dropdown-toggle" type="button" id="dropdownMemory" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if(old('memory_type'))
                                                            {{ $memoryType->find(old('memory_type'))->nama ?? '-- Pilih Memory Type --' }}
                                                        @else
                                                            -- Pilih Memory Type --
                                                        @endif
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMemory">
                                                        <li>
                                                            <input type="text" id="search-memory" class="form-control" placeholder="Cari Memory Type..." onkeyup="filterOptions(event, 'memory')">
                                                        </li>
                                                        <div id="memory-list">
                                                            @forelse ($memoryType as $item)
                                                                <li><a class="dropdown-item @if(old('memory_type') == $item->id) active @endif" href="#" name="memory_type" data-value="{{ $item->id }}">{{ $item->nama }}</a></li>
                                                            @empty
                                                                <li class="no-data"><a class="dropdown-item" href="#">Tidak Ada Data</a></li>
                                                            @endforelse
                                                        </div>
                                                    </ul>
                                                </div>
                                                <input type="hidden" id="selected-memory" name="memory_type" value="{{ old('memory_type') }}">

                                                <!-- VGA Type -->
                                                <div class="dropdown mb-3">
                                                    <label for="vga_type" class="form-label">VGA Type</label>
                                                    <button class="btn text-start dropdown-toggle" type="button" id="dropdownVGA" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if(old('vga_type'))
                                                            {{ $VGAType->find(old('vga_type'))->nama ?? '-- Pilih VGA Type --' }} 
                                                        @else
                                                            -- Pilih VGA Type --
                                                        @endif
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownVGA">
                                                        <li>
                                                            <input type="text" id="search-vga" class="form-control" placeholder="Cari VGA Type..." onkeyup="filterOptions(event, 'vga')">
                                                        </li>
                                                        <div id="vga-list">
                                                            @forelse ($VGAType as $item)
                                                                <li><a class="dropdown-item @if(old('vga_type') == $item->id) active @endif" href="#" name="vga_type" data-value="{{ $item->id }}">{{ $item->nama }}</a></li>
                                                            @empty
                                                                <li class="no-data"><a class="dropdown-item" href="#">Tidak Ada Data</a></li>
                                                            @endforelse
                                                        </div>
                                                    </ul>
                                                </div>
                                                <input type="hidden" id="selected-vga" name="vga_type" value="{{ old('vga_type') }}">
                                           </div>

                                            <!-- Kolom Kedua -->
                                            <div class="col col-6">
                                                <!-- Serial Number -->
                                                <div class="form-group mb-3">
                                                    <label for="serial_number" class="form-label">Serial Number</label>
                                                    <input type="text" name="serial_number" id="serial_number" value="{{old('serial_number')}}" placeholder="Masukkan Serial Number" class="form-control" required>
                                                    @error('serial_number')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <!-- Storage Capacity -->
                                                <div class="form-group mb-3">
                                                    <label for="storage_capacity" class="form-label">Storage Capacity</label>
                                                    <input type="text" name="storage_capacity" id="storage_capacity" value="{{old('storage_capacity')}}" placeholder="Storage Capacity                           GB" class="form-control" required>
                                                    @error('storage_capacity')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <!-- Memory Capacity -->
                                                <div class="form-group mb-3">
                                                        <label for="memory_capacity" class="form-label">Memory Capacity</label>
                                                        <input type="text" name="memory_capacity" id="memory_capacity" value="{{old('memory_capacity')}}" placeholder="Memory Capacity                          GB" class="form-control" required>
                                                        @error('memory_capacity')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                </div>
                                                <!-- VGA Capacity -->
                                                <div class="form-group mb-3">
                                                    <label for="vga_capacity" class="form-label">VGA Capacity</label>
                                                    <input type="text" name="vga_capacity" id="vga_capacity" value="{{old('vga_capacity')}}" placeholder="VGA Capacity                                 GB" class="form-control" required>
                                                    @error('vga_capacity')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col col-6">
                            
                            <!-- Card Aplikasi -->
                            <div class="card shadow mb-3">
                                    <div class="card-header py-3 text-center">
                                        <h6 class="m-0 font-weight-bold text-gray">Aplikasi</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Kolom Pertama -->
                                            <div class="row">
                                                <div class=" col col-6">
                                                    <!-- Operation System -->
                                                    <div class="dropdown mb-3">
                                                    <label for="operation_system" class="form-label">Operation System</label>
                                                    <button class="btn text-start dropdown-toggle" type="button" id="dropdownOS" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if(old('operation_system'))
                                                            {{ $osType->find(old('operation_system'))->nama ?? '-- Pilih Operation System --' }} 
                                                        @else
                                                            -- Pilih Operation System --
                                                        @endif
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownOS">
                                                        <li>
                                                            <input type="text" id="search-os" class="form-control" placeholder="Cari Operation System..." onkeyup="filterOptions(event, 'os')">
                                                        </li>
                                                        <div id="os-list">
                                                            @forelse ($osType as $item)
                                                                <li><a class="dropdown-item @if(old('operation_system') == $item->id) active @endif" href="#" name="operation_system" data-value="{{ $item->id }}">{{ $item->nama }}</a></li>
                                                            @empty
                                                                <li class="no-data"><a class="dropdown-item" href="#">Tidak Ada Data</a></li>
                                                            @endforelse
                                                        </div>
                                                    </ul>
                                                </div>
                                                <input type="hidden" id="selected-os" name="operation_system" value="{{old('operation_system')}}">

                                                <!-- Office Type -->
                                                <div class="dropdown mb-3">
                                                    <label for="office" class="form-label">Office Type</label>
                                                    <button class="btn text-start dropdown-toggle" type="button" id="dropdownOffice" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if(old('office'))
                                                            {{ $officeType->find(old('office'))->nama ?? '-- Pilih Office Type --' }} 
                                                        @else
                                                            -- Pilih Office Type --
                                                        @endif
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownOffice">
                                                        <li>
                                                            <input type="text" id="search-office" class="form-control" placeholder="Cari Office Type..." onkeyup="filterOptions(event, 'office')">
                                                        </li>
                                                        <div id="office-list">
                                                            @forelse ($officeType as $item)
                                                            <li><a class="dropdown-item @if(old('office_type') == $item->id) active @endif" href="#" name="office_type" data-value="{{ $item->id }}">{{ $item->nama }}</a></li>
                                                                @empty
                                                                <li class="no-data"><a class="dropdown-item" href="#">Tidak Ada Data</a></li>
                                                            @endforelse
                                                        </div>
                                                    </ul>
                                                </div>
                                                </div>
                                                <input type="hidden" id="selected-office" name="office" value="{{old('office')}}">
                                                <!-- Kolom Kedua -->
                                                <div class="col col-6">
                                                   <!-- OS License -->
                                                   <div class="form-group mb-3">
                                                        <label for="os_license" class="form-label">Operation Sytem License</label>
                                                        <select name="os_license" class="form-control">
                                                            <option value="" disabled {{ old('os_license') ? '' : 'selected' }}>-- Pilih OS License --</option>
                                                            @forelse ($license as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                                            @empty
                                                                <option value="">Tidak Ada License</option>
                                                            @endforelse
                                                        </select>
                                                        @error('os_license')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <!-- Office License -->
                                                    <div class="form-group mb-3">
                                                        <label for="office_license" class="form-label">Office License</label>
                                                        <select name="office_license" class="form-control">
                                                            <option value="" disabled {{ old('office_license') ? '' : 'selected' }}>-- Pilih Office License --</option>
                                                            @forelse ($license as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                                            @empty
                                                                <option value="">Tidak Ada License</option>
                                                            @endforelse
                                                        </select>
                                                        @error('office_license')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div> 
                                         <!-- Aplikasi Lainnya-->
                                        <div class="form-group mb-3">
                                            <label for="aplikasi_lainnya" class="form-label">Aplikasi Lainnya</label>
                                            <input type="text" name="aplikasi_lainnya" id="apk_lain" value="{{old('aplikasi_lainnya')}}" placeholder="Aplikasi Lainnya" class="form-control" required>
                                            @error('aplikasi_lainnya')
                                                <div class="alert alert-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                         </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Keterangan Tambahan -->
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-gray text-center">Keterangan Tambahan</h6>
                                </div>
                                <div class="card-body">
                                    <textarea class="col-lg-12" name="keterangan_tambahan" value="{{old('keterangan_tambahan')}}" placeholder="Keterangan Tambahan" style="height:100px;" required></textarea>
                                </div>
                            </div>
                            
                            <!-- Kondisi Device -->
                            <div class="card shadow mb-3">
                                 <div class="form-group mb-3">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-gray text-center">Kondisi Perangkat Komputer</h6>
                                    </div>
                                    <div class="card-body">
                                        <label for="kondisi" class="form-label">Kondisi</label>
                                        <select name="kondisi" id="kondisi" class="form-select" required>
                                            <option value="" disabled {{ old('kondisi') ? '' : 'selected' }}>-- Pilih Kondisi --</option>
                                            <option value="1" {{ old('kondisi') == '1' ? 'selected' : '' }}>Baik</option>
                                            <option value="0" {{ old('kondisi') == '0' ? 'selected' : '' }}>Rusak</option>
                                        </select>
                                        <!-- Upload dokumen -->
                                        <div class="col pt-3">
                                            <small class="text-muted">Foto Kondisi Perangkat</small>
                                            <input 
                                                type="file" name="foto_kondisi" class="form-control" accept=".jpg, .jpeg, .png" placeholder="Upload foto kondisi perangkat">
                                            @error('foto_kondisi')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>      
                </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href = "/device" type="button" class="btn btn-danger me-2" style="width: 120px;">Batal</a>
                        <button type="submit" id="submit-btn" class="btn btn-primary" style="width: 120px;">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>



$(document).ready(function () {
$('#no_pmn').on('keyup blur', function () {
    fetchNoPMN();
});

function fetchNoPMN() {
    let no_pmn = $('#no_pmn').val(); 

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
}
});

$(document).ready(function() {
    $('#nomor_it').on('input', function() {
        var nomor_it = $(this).val();

        if (nomor_it) {
            $.ajax({
                url: "{{ route('checkNomorIT') }}",
                type: "POST",
                data: {
                    nomor_it: nomor_it,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === "available") {
                        $('#nomor-it-status').text('Nomor Asset tersedia');
                        $('#nomor-it-status').removeClass('text-danger').addClass('text-success');
                        $('#submit-btn').prop('disabled', false);
                    } else if (response.status === "taken") {
                        $('#nomor-it-status').text('Nomor Asset sudah terdaftar');
                        $('#nomor-it-status').removeClass('text-success').addClass('text-danger');
                        $('#submit-btn').prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    $('#nomor-it-status').text('Terjadi kesalahan, coba lagi nanti');
                    $('#nomor-it-status').removeClass('text-success').addClass('text-danger');
                    $('#submit-btn').prop('disabled', true);
                }
            });
        }
    });
});

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

    $(document).ready(function () {
    $('.dropdown-menu').on('click', '.dropdown-item', function (event) {
        event.preventDefault();
        var selectedText = $(this).text();
        var selectedValue = $(this).data('value');
        var dropdownId = $(this).closest('.dropdown').find('.btn').attr('id');

        if (selectedValue !== undefined) {
            if (dropdownId === 'dropdownProcessor') {
                $('#selected-processor').val(selectedValue);
                $('#dropdownProcessor').text(selectedText);
            } else if (dropdownId === 'dropdownStorage') {
                $('#selected-storage').val(selectedValue);
                $('#dropdownStorage').text(selectedText);
            } else if (dropdownId === 'dropdownMemory') {
                $('#selected-memory').val(selectedValue);
                $('#dropdownMemory').text(selectedText);
            } else if (dropdownId === 'dropdownVGA') {
                $('#selected-vga').val(selectedValue);
                $('#dropdownVGA').text(selectedText);
            } else if (dropdownId === 'dropdownOS') {
                $('#selected-os').val(selectedValue);
                $('#dropdownOS').text(selectedText);
            } else if (dropdownId === 'dropdownOffice') {
                $('#selected-office').val(selectedValue);
                $('#dropdownOffice').text(selectedText);
            } else if (dropdownId === 'dropdownOSLicense') {
                $('#selected-osLicense').val(selectedValue);
                $('#dropdownOSLicense').text(selectedText);
            } else if (dropdownId === 'dropdownOfficeLicense') {
                $('#selected-officeLicense').val(selectedValue);
                $('#dropdownOfficeLicense').text(selectedText);
            }
        }
    });

    $('.form-control').on('click', function (event) {
        event.stopPropagation();
    });
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