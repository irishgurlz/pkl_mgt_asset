<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tambah Distribusi</title>
</head>

@extends('employee.master')

@section('content')
<!-- TITLE -->
<div class="container section-title" data-aos="fade-up">
    <h2>Tambah Distribusi Asset</h2>
</div><!-- End Section Title -->

<div class="container">
    <div class="row g-5 d-flex justify-content-center">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive" style="overflow:hidden">
                    <!-- Tabs -->
                    <div class="notif-tabs d-flex justify-content-center">
                        <div id="daftar-asset-device-tab" class="active" onclick="switchTab('daftar-asset-device')">Daftar Asset</div>
                        <div id="input-pengguna-tab" onclick="switchTab('input-pengguna')">Input Penyerahan</div>
                        <div id="tambah-asset-tab" onclick="switchTab('tambah-asset')">Tambah Perlengkapan Kantor</div>
                        <div id="tambah-device-tab" onclick="switchTab('tambah-device')">Tambah Perangkat Komputer</div>
                    </div>

                    <!-- DAFTAR ASSET DEVICE -->
                    <div id="daftar-asset-device" class="tab-content">
                        <div class="d-flex justify-content-center mt-4">
                            <h4>Daftar Asset dan Device</h4>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                
                            </div>

                            <!-- Table Device -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor Penyerahan</th>
                                                <th>Pemilik Asset</th>
                                                <th>Nomor Asset</th>
                                                <th>Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(session('table'))
                                                @foreach(session('table') as $key => $row)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $row['nomor_penyerahan'] ?? '-'}}</td>
                                                        <td>{{ $row->employee->nama}}</td>
                                                        <td>{{ $row['nomor_it'] ?? $row['nomor_asset'] }}</td>
                                                        {{-- <td>{{ $row['nomor_asset'] ?? '-' }}</td> --}}
                                                        <td>{{ $row->asset->kategori->nama ?? ($row->device->kategori->nama)}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    {{-- @include('paginate', ['paginator' => $table ]) --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- INPUT PENGGUNA -->
                    <div id="input-pengguna" class="tab-content mt-3">
                        @include('distribusi.input-pengguna')
                    </div>

                    <!-- TAMBAH DEVICE -->
                    <div id="tambah-device" class="tab-content mt-3">
                        @include('distribusi.create-device')
                    </div>

                    <!-- TAMBAH ASSET -->
                    <div id="tambah-asset" class="tab-content mt-3">
                        @include('distribusi.asset.create')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function switchTab(tabId) {
        $('.tab-content').hide(); 
        $('#' + tabId).show(); 
        $('#' + tabId + '-button').show(); 
        $('.notif-tabs div').removeClass('active');
        $('#' + tabId + '-tab').addClass('active'); 
        localStorage.setItem('lastTab', tabId);
    }
    function loadLastTab() {
        const lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            switchTab(lastTab);
        } else {
            switchTab('default-tab-id');
        }
    }

    $(document).ready(function() {
        loadLastTab();
    });



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

    function fetchDeviceData() {
        let nomor_it = $('#nomor_it').val();

        if (nomor_it.length > 0) {
            $.ajax({
                url: "/fetch-device-data",
                type: 'GET',
                data: { nomor_it: nomor_it },
                success: function(response) {
                    if (response.success) {
                        $('#id_kategori').val(response.id_kategori);
                        $('#id_tipe').val(response.id_tipe);
                        $('#no_pmn').val(response.no_pmn);
                        $('#processor').val(response.processor);
                        $('#storage_type').val(response.storage_type);
                        $('#memory_type').val(response.memory_type);
                        $('#vga_type').val(response.vga_type);
                        $('#vga_capacity').val(response.vga_capacity);
                        $('#serial_number').val(response.serial_number);
                        $('#storage_capacity').val(response.storage_capacity);
                        $('#memory_capacity').val(response.memory_capacity);
                        $('#keterangan_tambahan').val(response.keterangan_tambahan);
                        $('#operation_system').val(response.operation_system);
                        $('#office').val(response.office);
                        $('#os_license').val(response.os_license);
                        $('#office_license').val(response.office_license);
                        $('#aplikasi_lainnya').val(response.aplikasi_lainnya);

                        if (response.umur) {
                            const umur = calculateAge(response.umur);
                            $('#umur').val(response.umur);  
                            $('#umur_tahun').val(umur >= 0 ? `${umur} tahun` : 'Tanggal tidak valid');  
                        }

                        $('#nomor_it-status').text('');
                    } else {
                        resetForm();
                        $('#nomor_it-status').text('Nomor Asset tidak ditemukan');
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        } else {
            
        }
    }

    function fetchAssetData() {
        let nomor_asset = $('#nomor_asset').val();

        if (nomor_asset.trim().length > 0) {
            $.ajax({
                url: "/fetch-asset-data",
                type: 'GET',
                data: { nomor_asset: nomor_asset },
                success: function(response) {
                    if (response.success) {
                        $('#id_kategori').val(response.id_kategori);
                        $('#id_tipe').val(response.id_tipe);
                        $('#no_pmn').val(response.no_pmn);
                        $('#umur').val(response.umur);

                        if (response.umur) {
                            const umurTahun = calculateAge(response.umur);
                            $('#umur_tahun').val(umurTahun >= 0 ? `${umurTahun} tahun` : 'Tanggal tidak valid');
                        }
                        $('#nomor_asset-status').text('');
                        
                    } else {
                        resetForm();
                        $('#nomor_asset-status').text('Nomor Asset tidak ditemukan');
                    }
                },
                error: function(xhr) {
                    console.error("Terjadi kesalahan:", xhr);
                }
            });
        } else {
            resetForm();
        }
    }

    function calculateAge(dateOfBirth) {
        const today = new Date();
        const birthDate = new Date(dateOfBirth);
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    function resetForm() {
        $('#id_kategori').val('');
        $('#id_tipe').val('');
        $('#umur').val('');
        $('#no_pmn').val('');
        $('#processor').val('');
        $('#storage_type').val('');
        $('#memory_type').val('');
        $('#vga_type').val('');
        $('#vga_capacity').val('');
        $('#serial_number').val('');
        $('#storage_capacity').val('');
        $('#memory_capacity').val('');
        $('#keterangan_tambahan').val('');
        $('#operation_system').val('');
        $('#office').val('');
        $('#os_license').val('');
        $('#office_license').val('');
        $('#aplikasi_lainnya').val('');
        $('#umur_tahun').val('');
    }
    
</script>

@endsection