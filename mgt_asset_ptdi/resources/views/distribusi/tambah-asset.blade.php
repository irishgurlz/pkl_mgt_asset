<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tambah Asset</title>
</head>

@extends('employee.master')

@section('content')
<!-- TITLE -->
<div class="container section-title" data-aos="fade-up">
    <h2>Tambah Asset No : {{$dist->nomor_penyerahan}}</h2>
</div><!-- End Section Title -->

<div class="container">
    <div class="row g-5 d-flex justify-content-center">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive" style="overflow:hidden">
                    <!-- Tabs -->
                    <div class="notif-tabs d-flex justify-content-center">
                        <div id="daftar-asset-device-tab" class="active" onclick="switchTab('daftar-asset-device')">Daftar Asset</div>
                        {{-- <div id="input-pengguna-tab" onclick="switchTab('input-pengguna')">Input Penyerahan</div> --}}
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
                                                <th>Pemilik</th>
                                                <th>Jenis</th>
                                                <th>Nomor Asset</th>
                                                <th>Detail</th>
                                                @include('endpoint device.device.component.modal_detail_device', ['devices' => $distribution])
                                                @include('employee.component.modal-detail-asset')
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($distribution as $key => $item)
                                            <tr>
                                                {{-- @dd( $item->asset->umur ) --}}
                                                <td>{{$key + 1}}</td>
                                                {{-- <td>{{$item->created_at}}</td> --}}
                                                <td>{{$item->nomor_penyerahan}}</td>
                                                <td>{{$item->employee->nama}}</td>
        
                                                @if ($item->nomor_it == null)
                                                    <td>Perlengkapan Kantor</td>
                                                    <td>{{$item->nomor_asset}}</td>
                                                    <td>
                                                        <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-detail-asset"
                                                            data-umur="{{ $item->asset->umur ?? '' }}"
                                                            data-kondisi="{{ $item->asset->kondisi == 1 ? 'Baik' : 'Rusak' }}"
                                                            data-nomor-penyerahan="{{ $item->nomor_penyerahan ?? '' }}"
                                                            data-pemilik="{{ $item->employee->nama ?? '' }}"
                                                            data-kategori="{{ $item->asset->kategori->nama ?? '' }}"
                                                            data-sub-kategori="{{ $item->asset->subKategori->nama ?? '' }}"
                                                            data-nomor-pmn="{{$item->asset->no_pmn ?? ''}}">
                                                        
                                                            Detail
                                                        </a>
                                                    </td>
                                                   
                                                @else
                                                    <td>Perangkat Komputer</td>
                                                    <td>{{$item->nomor_it}}</td>
                                                    <td>
                                                        <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-detail-device" 
                                                            data-nomor-it="{{$item->nomor_it}}"
                                                            data-nomor-pmn="{{$item->device->no_pmn}}"
                                                            data-kategori="{{$item->device->kategori->nama ?? '-'}}"
                                                            data-processor="{{$item->device->processorType->nama}}"
                                                            data-tipe="{{$item->device->subKategori->nama}}"
                                                            data-umur="{{$item->device->umur}}"
                                                            data-storage-type="{{$item->device->storageType->nama}}"
                                                            data-storage-capacity="{{$item->device->storage_capacity}}"
                                                            data-memory-type="{{$item->device->memoryType->nama}}"
                                                            data-memory-capacity="{{$item->device->memory_capacity}}"
                                                            data-vga-type="{{$item->device->vgaType->nama}}"
                                                            data-vga-capacity="{{$item->device->vga_capacity}}"
                                                            data-serial_type="{{$item->device->serial_number}}"
                                                            data-os="{{$item->device->operationSystem->nama}}"
                                                            data-os-license="{{$item->device->osLicense->nama}}"
                                                            data-office="{{$item->device->officeType->nama}}"
                                                            data-office-license="{{$item->device->officeLicense->nama}}"
                                                            data-aplikasi="{{$item->device->aplikasi_lainnya ?? '-'}}"
                                                            data-keterangan="{{$item->device->keterangan_tambahan ?? '-'}}"
                                                            data-kondisi="{{ $item->device->kondisi == 1 ? 'Baik' : 'Rusak' }}"> 
                                                            Detail
                                                        </a>
                                                    </td>
                                                    
                                                @endif
                                            </tr>
                                                
                                            @empty
                                                
                                            @endforelse
                                        </tbody>
                                    </table>    
                                    @include('paginate', ['paginator' => $distribution ])
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAMBAH DEVICE -->
                    <div id="tambah-device" class="tab-content mt-3">
                        @include('distribusi.tambah-asset-device')
                    </div>

                    <!-- TAMBAH ASSET -->
                    <div id="tambah-asset" class="tab-content mt-3">
                        @include('distribusi.tambah-asset-kantor')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('modal-detail-asset');
        modalElement.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
    
            const umur = button.getAttribute('data-umur') || 'N/A';
            const nomor_penyerahan = button.getAttribute('data-nomor-penyerahan') || 'N/A';
            const pemilik = button.getAttribute('data-pemilik') || 'N/A';
            const kategori = button.getAttribute('data-kategori') || 'N/A';
            const sub_kategori = button.getAttribute('data-sub-kategori') || 'N/A';
            const no_pmn = button.getAttribute('data-nomor-pmn') || 'N/A';
            const kondisi = button.getAttribute('data-kondisi') || 'N/A';
    
            modalElement.querySelector('#detail-kategori').textContent = kategori;
            modalElement.querySelector('#detail-sub-kategori').textContent = sub_kategori;
            modalElement.querySelector('#detail-umur').textContent = umur;
            modalElement.querySelector('#detail-nomor-pmn').textContent = no_pmn;
            modalElement.querySelector('#detail-kondisi').textContent = kondisi;
            modalElement.querySelector('#detail-nomor-penyerahan').textContent = nomor_penyerahan;
            modalElement.querySelector('#detail-pemilik').textContent = pemilik;
        });
    });
</script>
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
            fetch(`/get-sub-by-kategori/${kategoriId}`)
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