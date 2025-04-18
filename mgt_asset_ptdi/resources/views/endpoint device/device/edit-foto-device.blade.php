<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Perangkat Komputer</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')
<!-- TITLE -->
<div class="container section-title" data-aos="fade-up">
    <h2>Edit Perangkat Komputer</h2>
</div><!-- End Section Title -->
  <div class="container">
    <div class="row g-5 d-flex justify-content-center">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive" style="overflow:hidden">
                    <form action="/update-foto-device/{{$device->id}}" id="form-edit-device" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group mb-3">
                                <label for="no_pmn" class="form-label">Nomor PMN</label>
                                <input type="text" name="no_pmn" id="no_pmn" value="{{ old('no_pmn', $device->no_pmn) }}" class="form-control bg-light" {{ isset($device->no_pmn) ? 'readonly' : '' }} required>
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
                                            <input type="text" name="nomor_it" id="nomor_it" value="{{ old('nomor_it', $device->nomor_it) }}" class="form-control bg-light" {{ isset($device->nomor_it) ? 'readonly' : '' }} required>
                                            @error('nomor_it')
                                                <div class="alert alert-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <!-- Kategori -->
                                        <div class="form-group mb-3">
                                            <label for="id_kategori" class="form-label bg-light">Kategori</label>
                                            <select id="id_kategori" name="id_kategori" class="form-control bg-light" disabled>
                                                <option value="" disabled {{ old('id_kategori') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                                @foreach ($kategori as $item)
                                                    <option value="{{ $item->id }}" {{ old('id_kategori', $device->id_kategori ?? '') == $item->id ? 'selected' : '' }}>
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
                                            <select id="id_tipe" name="id_tipe" class="form-control bg-light" disabled>
                                                <option value="" disabled {{ old('id_tipe') ? '' : 'selected' }}>-- Pilih Sub Kategori --</option>
                                            </select>
                                            <input id="old_id_tipe" value="{{ old('id_tipe', $device->id_tipe ?? '') }}" type="hidden">
                                        </div>

                                        <!-- Umur -->
                                        <div class="form-group mb-3">
                                            <label for="umur" class="form-label">Umur</label>
                                            <input type="date" name="umur" id="umur" placeholder="Masukkan Tanggal" class="form-control bg-light" disabled value="{{old('umur', $device->umur)}}"required>
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
                                            <div class="form-group mb-3">
                                                <label for="processor" class="form-label">Processor</label>
                                                <select name="processor" class="form-control bg-light" disabled>
                                                    <option value="" disabled {{ old('processor') ? '' : 'selected' }}>-- Pilih Processor --</option>
                                                    @forelse ($processor as $item)
                                                        <option value="{{$item->id}}"
                                                        {{ old('processor', $device->processor) == $item->id ? 'selected' : '' }}>
                                                        {{$item->nama}}</option>
                                                    @empty
                                                        <option value="">Tidak Ada Processor</option>
                                                    @endforelse
                                                </select>
                                                @error('processor')
                                                    <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <!-- Storage Type -->
                                            <div class="form-group mb-3">
                                                <label for="storage_type" class="form-label">Storage Type</label>
                                                <select name="storage_type" class="form-control bg-light" disabled>
                                                    <option value="" disabled {{ old('storage_type') ? '' : 'selected' }}>-- Pilih Storage Type --</option>
                                                    @forelse ($storageType as $item)
                                                    <option value="{{$item->id}}"
                                                        {{ old('storage_type', $device->storage_type) == $item->id ? 'selected' : '' }}>
                                                        {{$item->nama}}</option>
                                                    @empty
                                                        <option value="">Tidak Ada Storage Type</option>
                                                    @endforelse
                                                </select>
                                                @error('storage_type')
                                                    <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <!-- Memory Type -->
                                            <div class="form-group mb-3">
                                                <label for="memory_type" class="form-label">Memory Type</label>
                                                <select name="memory_type" class="form-control bg-light" disabled>
                                                    <option value="" disabled {{ old('memory_type') ? '' : 'selected' }}>-- Pilih Memory Type --</option>
                                                    @forelse ($memoryType as $item)
                                                    <option value="{{$item->id}}"
                                                        {{ old('memory_type', $device->memory_type) == $item->id ? 'selected' : '' }}>
                                                        {{$item->nama}}</option>
                                                    @empty
                                                        <option value="">Tidak Ada Memory Tape</option>
                                                    @endforelse
                                                </select>
                                                @error('memory_type')
                                                    <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <!-- VGA Type -->
                                            <div class="form-group mb-3">
                                                <label for="vga_type" class="form-label">VGA Type</label>
                                                <select name="vga_type" class="form-control bg-light" disabled>
                                                    <option value="" disabled {{ old('vga_type') ? '' : 'selected' }}>-- Pilih VGA Type --</option>
                                                    @forelse ($VGAType as $item)
                                                    <option value="{{$item->id}}"
                                                        {{ old('vga_type', $device->vga_type) == $item->id ? 'selected' : '' }}>
                                                        {{$item->nama}}</option>
                                                    @empty
                                                        <option value="">Tidak Ada VGA Type</option>
                                                    @endforelse
                                                </select>
                                                @error('vga_type')
                                                    <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Kolom Kedua -->
                                        <div class="col col-6">
                                            <!-- Serial Number -->
                                            <div class="form-group mb-3">
                                                    <label for="serial_number" class="form-label">Serial Number</label>
                                                    <input type="text" name="serial_number" id="serial_number" value="{{old('serial_number', $device->serial_number)}}" placeholder="Masukkan Serial Number" class="form-control bg-light" required readonly>
                                                    @error('serial_number')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <!-- Storage Capacity -->
                                            <div class="form-group mb-3">
                                                    <label for="storage_capacity" class="form-label">Storage Capacity</label>
                                                    <input type="text" name="storage_capacity" id="storage_capacity" value="{{old('storage_capacity', $device->storage_capacity)}}" placeholder="Storage Capacity                           GB" class="form-control bg-light" required readonly>
                                                    @error('storage_capacity')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <!-- Memory Capacity -->
                                            <div class="form-group mb-3">
                                                    <label for="memory_capacity" class="form-label">Memory Capacity</label>
                                                    <input type="text" name="memory_capacity" id="memory_capacity" value="{{old('memory_capacity', $device->memory_capacity)}}" placeholder="Memory Capacity                          GB" class="form-control bg-light" required readonlyd>
                                                    @error('memory_capacity')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                            </div>
                                            <!-- VGA Capacity -->
                                            <div class="form-group mb-3">
                                                    <label for="vga_capacity" class="form-label">VGA Capacity</label>
                                                    <input type="text" name="vga_capacity" id="vga_capacity" value="{{old('vga_capacity', $device->vga_capacity)}}" placeholder="VGA Capacity                                 GB" class="form-control bg-light" required readonly>
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
                                                <div class="form-group mb-3">
                                                    <label for="operation_system" class="form-label">Operation System</label>
                                                    <select name="operation_system" class="form-control bg-light" disabled>
                                                        <option value="" disabled {{ old('operation_system') ? '' : 'selected' }}>-- Pilih Operation System --</option>
                                                        @forelse ($osType as $item)
                                                        <option value="{{$item->id}}"
                                                            {{ old('operation_system', $device->operation_system) == $item->id ? 'selected' : '' }}>
                                                            {{$item->nama}}</option>
                                                        @empty
                                                            <option value="">Tidak Ada Operation System</option>
                                                        @endforelse
                                                    </select>
                                                    @error('operation_system')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <!-- Office Type -->
                                                <div class="form-group mb-3">
                                                    <label for="office" class="form-label">Office Type</label>
                                                    <select name="office" class="form-control bg-light" disabled>
                                                        <option value="" disabled {{ old('office') ? '' : 'selected' }}>-- Pilih Office Type --</option>
                                                        @forelse ($officeType as $item)
                                                            <option value="{{$item->id}}"
                                                            {{ old('office', $device->office) == $item->id ? 'selected' : '' }}>
                                                            {{$item->nama}}</option>
                                                        @empty
                                                            <option value="">Tidak Ada Office Type</option>
                                                        @endforelse
                                                    </select>
                                                    @error('office')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Kolom Kedua -->
                                            <div class="col col-6">
                                                <!-- OS license -->
                                                <div class="form-group mb-3">
                                                    <label for="os_license" class="form-label">Operation Sytem license</label>
                                                    <select name="os_license" class="form-control bg-light" disabled>
                                                        <option value="" disabled {{ old('os_license') ? '' : 'selected' }}>-- Pilih OS license --</option>
                                                        @forelse ($license as $item)
                                                            <option value="{{$item->id}}"
                                                            {{ old('os_license', $device->os_license) == $item->id ? 'selected' : '' }}>
                                                            {{$item->nama}}</option>
                                                        @empty
                                                            <option value="">Tidak Ada license</option>
                                                        @endforelse
                                                    </select>
                                                    @error('os_license')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <!-- Office License -->
                                                <div class="form-group mb-3">
                                                    <label for="office_license" class="form-label">Office license</label>
                                                    <select name="office_license" class="form-control bg-light" disabled>
                                                        <option value="" disabled {{ old('office_license') ? '' : 'selected' }}>-- Pilih Office license --</option>
                                                        @forelse ($license as $item)
                                                            <option value="{{$item->id}}"
                                                            {{ old('office_license', $device->office_license) == $item->id ? 'selected' : '' }}>
                                                            {{$item->nama}}</option>
                                                        @empty
                                                            <option value="">Tidak Ada License</option>
                                                        @endforelse
                                                    </select>
                                                    @error('office_license')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                    </div>  
                                        <!-- Aplikasi Lainnya-->
                                    <div class="form-group mb-3">
                                        <label for="aplikasi_lainnya" class="form-label">Aplikasi Lainnya</label>
                                        <input type="text" name="aplikasi_lainnya" id="apk_lain" value="{{old('aplikasi_lainnya', $device->aplikasi_lainnya)}}" placeholder="Aplikasi Lainnya" class="form-control bg-light" required readonly>
                                        @error('aplikasi_lainnya')
                                            <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
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
                                <textarea class="col-lg-12" name="keterangan_tambahan" placeholder="Keterangan Tambahan" style="height:100px;" class="form-control bg-light" required readonly>{{ old('keterangan_tambahan', $device->keterangan_tambahan) }}</textarea>
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
                                    <select name="kondisi" id="kondisi" class="form-select" class="form-control bg-light" disabled required>
                                         <option value="" disabled {{ old('kondisi') ? '' : 'selected' }}>-- Pilih Kondisi --</option>
                                        <option value="1" {{ old('kondisi', $device->kondisi) == '1' ? 'selected' : '' }}>Baik</option>
                                        <option value="0" {{ old('kondisi', $device->kondisi) == '0' ? 'selected' : '' }}>Rusak</option>
                                    </select>
                                    <!-- Upload dokumen -->
                                    <div class="col pt-3">
                                        <small class="text-muted">Foto Kondisi Perangkat (.jpg)</small>
                                        <input 
                                            type="file" name="foto_kondisi" class="form-control" accept=".jpg, .jpeg, .png" required placeholder="Upload foto kondisi perangkat">
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
                    <a href="/device" type="button" class="btn btn-danger me-2" style="width: 120px;">Batal</a>
                    <button type="submit" class="btn btn-primary" style="width: 120px;">Edit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const kategoriDropdown = document.getElementById('id_kategori');
    const tipeDropdown = document.getElementById('id_tipe');
    const oldSubKategoriId = document.getElementById('old_id_tipe').value;

    const loadSubKategori = (kategoriId, selectedId = null) => {
        tipeDropdown.innerHTML = '<option value="" disabled selected>-- Pilih Sub Kategori --</option>';

        if (kategoriId) {
            fetch(`/get-sub-by-kategori/${kategoriId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.nama;

                            if (item.id == selectedId) {
                                option.selected = true;
                            }

                            tipeDropdown.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Tidak Ada Sub Kategori';
                        tipeDropdown.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    };

    const oldKategoriId = kategoriDropdown.value;
    if (oldKategoriId) {
        loadSubKategori(oldKategoriId, oldSubKategoriId);
    }

    kategoriDropdown.addEventListener('change', function () {
        loadSubKategori(this.value);
    });
});

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
            },
            error: function (xhr) {
                console.error(xhr.responseJSON);
                $('#no_pmn-status').text('Terjadi kesalahan pada server').removeClass('text-success').addClass('text-danger');
            }
        });
    }
});
</script>

@endsection