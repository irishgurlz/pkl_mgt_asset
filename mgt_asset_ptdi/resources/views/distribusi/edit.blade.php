<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tambah Asset</title>
</head>

@extends('employee.master')

@section('content')
<!-- TITLE -->
<div class="container section-title" data-aos="fade-up">
    <h2>Tambah Asset</h2>
</div><!-- End Section Title -->
  <div class="container">
    <div class="row g-5 d-flex justify-content-center">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive" style="overflow:hidden">
                    <form action="/distribusi/{{ $asset->nomor_asset }}/device/{{ $device->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group mb-3">
                                <label for="nomor_asset" class="form-label">Nomor Asset</label>
                                <input type="text" name="nomor_asset" id="nomor_asset" placeholder="Masukkan Nomor Asset" class="form-control" value="{{ old('nomor_asset', $asset->nomor_asset) }}" style="background-color: #f2f2f2;" required readonly>
                                @error('nomor_asset')
                                    <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
                  
                        </div>

                        <div class="row">
                            <div class=" col col-6">
                                <div class="'row">

                                    <!-- Card Pengguna -->
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3 text-center">
                                            <h6 class="m-0 font-weight-bold text-gray">Pengguna</h6>
                                        </div>
                                        <div class="card-body">
        
                                            <!-- NIK Pemilik Asset -->
                                            <div class="form-group mb-3">
                                                <label for="nik" class="form-label">NIK</label>
                                                <input type="text" name="nik" id="nik" placeholder="Masukkan NIK" class="form-control" onkeyup="fetchUserData()" value="{{ old('nik', $asset->nik) }}" style="background-color: #f2f2f2;" required readonly>
                                                <div id="nik-status" style="color: blue; font-size: 14px;"></div>

                                                @error('nik')
                                                    <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
        
                                            <!-- Nama Pemilik Asset -->
                                            <div class="form-group mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" name="nama" id="nama" placeholder="Nama" class="form-control" value="{{ old('nama', $asset->employee->nama) }}" style="background-color: #f2f2f2;" required readonly>
                                                @error('nama')
                                                    <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                
                                            <!-- Organisasi -->
                                            <div class="form-group mb-3">
                                                <label for="kode_org" class="form-label">Organisasi</label>
                                                <input type="text" name="kode_org" id="kode_org" placeholder="Organisasi" class="form-control" value="{{ old('kode_org', $asset->employee->org->nama) }}" style="background-color: #f2f2f2;" required readonly>
                                                @error('kode_org')
                                                    <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                
                                            <!-- Lokasi -->
                                            <div class="form-group mb-3">
                                                <label for="lokasi" class="form-label">Lokasi</label>
                                                <input type="text" name="lokasi" id="lokasi" placeholder="Masukkan Lokasi" class="form-control" value="{{ old('lokasi', $asset->lokasi) }}" style="background-color: #f2f2f2;" required readonly>
                                                @error('lokasi')
                                                    <div class="alert alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Keterangan Tambahan -->
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-gray text-center">Keterangan Tambahan</h6>
                                        </div>
                                        <div class="card-body">
                                            <textarea class="col-lg-12" name="keterangan_tambahan" placeholder="Keterangan Tambahan" style="height:150px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class=" col col-6">
                                <div>
                                
                                     <!-- Card Perangkat -->
                                <div class="card shadow mb-3">
                                    <div class="card-header py-3 text-center">
                                        <h6 class="m-0 font-weight-bold text-gray">Perangkat</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                             <div class="form-group mb-3">
                                                    <label for="nomor_it" class="form-label">Nomor Asset</label>
                                                    <input type="text" name="nomor_it" id="nomor_it" placeholder="Masukkan Nomor Asset" class="form-control" value="{{ old('nomor_it', $asset->nomor_it) }}" style="background-color: #f2f2f2;" required readonly>
                                                    <input type="hidden" name="old_nomor_it" value="{{ old('nomor_it', $asset->nomor_it) }}">
                                                    @error('nomor_it')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                            </div>

                                                <!-- Kategori -->
                                                <div class="form-group mb-3">
                                                    <label for="id_kategori" class="form-label">Kategori</label>
                                                    <select id="id_kategori" name="id_kategori" class="form-control">
                                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                                        @forelse ($kategori as $item)
                                                            <option value="{{$item->id}}">{{$item->nama}}</option>
                                                        @empty
                                                            <option value="">Tidak Ada Kategori</option>
                                                        @endforelse
                                                    </select>
                                                    @error('id_kategori')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>

                                                <!-- Tipe Kategori -->
                                                <div class="form-group mb-3">
                                                    <label for="id_tipe" class="form-label">Tipe Kategori</label>
                                                    <select id="id_tipe" name="id_tipe" class="form-control">
                                                        <option value="" disabled selected>-- Pilih Tipe Kategori --</option>
                                                    </select>
                                                    @error('id_tipe')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="umur" class="form-label">Umur</label>
                                                    <input type="date" name="umur" id="umur" placeholder="Masukkan Tanggal" class="form-control" required>
                                                    <input type="text" id="calculatedAge" placeholder="Umur dalam tahun" class="form-control mt-2" readonly>
                                                    @error('umur')
                                                        <div class="alert alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                
                                                <script>
                                                    document.getElementById('umur').addEventListener('change', function () {
                                                        const inputDate = new Date(this.value);
                                                        const today = new Date();
                                                        
                                                        if (inputDate > today) {
                                                            document.getElementById('calculatedAge').value = "Tanggal tidak valid";
                                                            return;
                                                        }
                                                        
                                                        let age = today.getFullYear() - inputDate.getFullYear();
                                                        const monthDiff = today.getMonth() - inputDate.getMonth();
                                                        const dayDiff = today.getDate() - inputDate.getDate();
                                                        
                                                        // Adjust age if the current month/day is before the birth month/day
                                                        if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                                                            age--;
                                                        }
                                                
                                                        document.getElementById('calculatedAge').value = age + " tahun";
                                                    });
                                                </script>
                                            </div>
                                            <!-- Kolom Pertama -->
                                            <div class="row">
                                                <div class=" col col-6">
                                                    <!-- Processor -->
                                                    <div class="form-group mb-3">
                                                        <label for="processor" class="form-label">Processor</label>
                                                        <select name="processor" class="form-control">
                                                            <option value="" disabled selected>-- Pilih Processor --</option>
                                                            @forelse ($processor as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
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
                                                        <select name="storage_type" class="form-control">
                                                            <option value="" disabled selected>-- Pilih Storage Type --</option>
                                                            @forelse ($storageType as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                                            @empty
                                                                <option value="">Tidak Ada Processor</option>
                                                            @endforelse
                                                        </select>
                                                        @error('storage_type')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <!-- Memory Type -->
                                                    <div class="form-group mb-3">
                                                        <label for="memory_type" class="form-label">Memory Type</label>
                                                        <select name="memory_type" class="form-control">
                                                            <option value="" disabled selected>-- Pilih Memory Type --</option>
                                                            @forelse ($memoryType as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                                            @empty
                                                                <option value="">Tidak Ada Processor</option>
                                                            @endforelse
                                                        </select>
                                                        @error('memory_type')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <!-- VGA Type -->
                                                    <div class="form-group mb-3">
                                                        <label for="vga_type" class="form-label">VGA Type</label>
                                                        <select name="vga_type" class="form-control">
                                                            <option value="" disabled selected>-- Pilih VGA Type --</option>
                                                            @forelse ($VGAType as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                                            @empty
                                                                <option value="">Tidak Ada Processor</option>
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
                                                            <input type="text" name="serial_number" id="serial_number" placeholder="Masukkan Serial Number" class="form-control" required>
                                                            @error('serial_number')
                                                                <div class="alert alert-danger">{{$message}}</div>
                                                            @enderror
                                                    </div>
                                                    <!-- Storage Capacity -->
                                                    <div class="form-group mb-3">
                                                            <label for="storage_capacity" class="form-label">Storage Capacity</label>
                                                            <input type="text" name="storage_capacity" id="storage_capacity" placeholder="Storage Capacity                           GB" class="form-control" required>
                                                            @error('storage_capacity')
                                                                <div class="alert alert-danger">{{$message}}</div>
                                                            @enderror
                                                    </div>
                                                    <!-- Memory Capacity -->
                                                    <div class="form-group mb-3">
                                                            <label for="memory_capacity" class="form-label">Memory Capacity</label>
                                                            <input type="text" name="memory_capacity" id="memory_capacity" placeholder="Memory Capacity                          GB" class="form-control" required>
                                                            @error('memory_capacity')
                                                                <div class="alert alert-danger">{{$message}}</div>
                                                            @enderror
                                                    </div>
                                                    <!-- VGA Capacity -->
                                                    <div class="form-group mb-3">
                                                            <label for="vga_capacity" class="form-label">VGA Capacity</label>
                                                            <input type="text" name="vga_capacity" id="vga_capacity" placeholder="VGA Capacity                                 GB" class="form-control" required>
                                                            @error('vga_capacity')
                                                                <div class="alert alert-danger">{{$message}}</div>
                                                            @enderror
                                                    </div>
                                                </div>
                                        </div>  
                                         
                                    </div>

                                </div>
                    
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
                                                    <!-- Memory Type -->
                                                    <div class="form-group mb-3">
                                                        <label for="operation_system" class="form-label">Operation System</label>
                                                        <select name="operation_system" class="form-control">
                                                            <option value="" disabled selected>-- Pilih Operation System --</option>
                                                            @forelse ($osType as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
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
                                                        <select name="office" class="form-control">
                                                            <option value="" disabled selected>-- Pilih Office Type --</option>
                                                            @forelse ($officeType as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
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
                                                    <!-- OS Lisence -->
                                                    <div class="form-group mb-3">
                                                        <label for="os_license" class="form-label">Operation Sytem Lisence</label>
                                                        <select name="os_license" class="form-control">
                                                            <option value="" disabled selected>-- Pilih OS Lisence --</option>
                                                            @forelse ($lisence as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                                            @empty
                                                                <option value="">Tidak Ada Lisence</option>
                                                            @endforelse
                                                        </select>
                                                        @error('os_license')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <!-- Office Lisence -->
                                                    <div class="form-group mb-3">
                                                        <label for="office_license" class="form-label">Office Lisence</label>
                                                        <select name="office_license" class="form-control">
                                                            <option value="" disabled selected>-- Pilih Office Lisence --</option>
                                                            @forelse ($lisence as $item)
                                                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                                            @empty
                                                                <option value="">Tidak Ada Lisence</option>
                                                            @endforelse
                                                        </select>
                                                        @error('office_license')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                        </div>  
                                         <!-- Nomor IT -->
                                        <div class="form-group mb-3">
                                            <label for="aplikasi_lainnya" class="form-label">Aplikasi Lainnya</label>
                                            <input type="text" name="aplikasi_lainnya" id="apk_lain" placeholder="Aplikasi Lainnya" class="form-control" required>
                                            @error('aplikasi_lainnya')
                                                <div class="alert alert-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                         
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-danger me-2" style="width: 120px;">Batal</button>
                        <button type="submit" class="btn btn-primary" style="width: 120px;">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.getElementById('id_kategori').addEventListener('change', function () {
        const kategoriId = this.value;
        const tipeDropdown = document.getElementById('id_tipe');

        tipeDropdown.innerHTML = '<option value="" disabled selected>-- Pilih Tipe Kategori --</option>';

        if (kategoriId) {
            fetch(`/get-tipe-by-kategori/${kategoriId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.nama;
                            tipeDropdown.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Tidak Ada Tipe Kategori';
                        tipeDropdown.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });

    function fetchUserData() {
        let nik = $('#nik').val(); 

        if (nik.length > 0) { 
            $.ajax({
                url: "/fetch-user-data",
                type: 'GET',
                data: { nik: nik }, 
                success: function(response) {
                    if (response.success) {
                        $('#nama').val(response.nama);
                        $('#kode_org').val(response.kode_org);
                        $('#nik-status').text('');
                    } else {
                        $('#nama').val('');
                        $('#kode_org').val('');
                        $('#nik-status').text('nik tidak ada');
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        } else {
            $('#nama').val('');
            $('#kode_org').val('');
        }
    }
</script>

@endsection