<!DOCTYPE html>
<html lang="en">

<head>
  <title>Daftar Asset Rusak</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')
<!-- TITLE -->
<div class="container" data-aos="fade-up">
    <div class="section-title" data-aos="fade-up">
        <h2>Daftar Asset Rusak</h2>
    </div>

    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive" style="overflow:hidden">
                    <!-- Tabs -->
                    <div class="notif-tabs d-flex justify-content-center">
                        <div id="device-rusak-tab" class="active"  onclick="switchTab('tabel-device-rusak')">Perangkat Komputer</div>
                        <div id="asset-rusak-tab" onclick="switchTab('tabel-asset-rusak')">Perlengkapan Kantor</div>
                    </div>

                    <!-- DAFTAR DEVICE RUSAK -->
                    <div id="tabel-device-rusak" class="tab-content active">
                        <div class="d-flex justify-content-center mt-4">
                            <h4>Daftar Perangkat Komputer Rusak</h4>
                        </div>

                        <!-- Kategori Dropdown -->
                        <div class="form-group mb-3">
                                <label for="id_kategori" class="form-label">Kategori</label>
                                <select id="id_kategori" name="id_kategori" class="form-control">
                                    <option value="" disabled selected>-- Pilih Kategori Perangkat--</option>
                                    @foreach($kategori as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <form id="searchForm" method="GET" action="{{ route('barangRusak') }}">
                                <input type="hidden" name="type" id="type" value="device">
                                    <div class="mb-3 d-flex justify-content-between">
                                        <div class="input-group me-2">
                                            <input type="text" class="form-control" id="search" name="search" placeholder="Search" value="{{ request('search') }}">
                                        </div>
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Table Device -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor PMN</th>
                                                <th>Nomor Asset</th>
                                                <th>Kategori</th>
                                                <th>Type Device</th>
                                                <th>Umur</th>
                                                <th>Kondisi</th>
                                                <th>Detail</th>
                                                <th>Aksi</th>
                                                @include('endpoint device.device.component.modal_detail_device', ['devices' => $devices])
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @include('endpoint device.device.component.search_table_device', ['devices' => $devices])
                                        </tbody>
                                    </table>
                                    <!-- <div class="d-flex justify-content-end mt-3">
                                        {{ $devices->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                                    </div> -->
                                    @include('paginate', ['paginator' => $devices])
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DAFTAR ASSET RUSAK -->
                    <div id="tabel-asset-rusak" class="tab-content mt-3">
                        <div class="d-flex justify-content-center mt-4">
                            <h4>Daftar Perlengkapan Kantor Rusak</h4>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <form id="searchForm" method="GET" action="{{ route('barangRusak') }}">
                                <input type="hidden" name="type" id="type" value="asset">
                                    <div class="mb-3 d-flex justify-content-between">
                                        <div class="input-group me-2">
                                            <input type="text" class="form-control" id="search" name="search" placeholder="Search" value="{{ request('search') }}">
                                        </div>
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Table Asset -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor PMN</th>
                                                <th>Nomor Asset</th>
                                                <th>Kategori</th>
                                                <th>Nama</th>
                                                <th>Umur</th>
                                                <th>Kondisi</th>
                                                <th>Foto</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @include('asset.component.search_table_asset', ['asset' => $asset])
                                        </tbody>
                                    </table>
                                    <!-- <div class="d-flex justify-content-end mt-3">
                                        {{ $asset->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                                    </div> -->
                                    @include('paginate', ['paginator' => $asset])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection

<script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin untuk menghapus perangkat ini?');
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// SWITCH TAB
function switchTab(tabId) {
    $('.tab-content').removeClass('active');
    $('#' + tabId).addClass('active');
    $('.notif-tabs div').removeClass('active');
    if (tabId === 'tabel-device-rusak') {
        $('#device-rusak-tab').addClass('active');
        $('#type').val('device'); 
    } else if (tabId === 'tabel-asset-rusak') {
        $('#asset-rusak-tab').addClass('active');
        $('#type').val('asset'); 
    }

    localStorage.setItem('lastTab', tabId);
}

function loadLastTab() {
    const lastTab = localStorage.getItem('lastTab') || 'tabel-device-rusak'; 
    switchTab(lastTab); 
}

$(document).ready(function() {
    loadLastTab();
});

// SEARCH
$(document).on('input', '#search', function () {
    const searchQuery = $(this).val();
    const activeTab = $('.tab-content.active').attr('id');
    const type = activeTab === 'tabel-device-rusak' ? 'device' : 'asset';

    console.log("Active Tab:", activeTab, "Type:", type, "Search Query:", searchQuery);

    fetch("{{ route('barangRusak') }}?search=" + searchQuery + "&type=" + type, {
        method: 'GET',
        headers: {
            'Accept': 'text/html',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(data => {
        console.log("Response Data:", data);
        const tableBody = document.querySelector(`#${activeTab} tbody`);
        if (tableBody) {
            tableBody.innerHTML = data;
        } else {
            console.error("Table body not found for active tab:", activeTab);
        }
    })
    .catch(error => console.error('Error fetching data:', error));
});

$(document).ready(function () {
    $('#id_kategori').on('change', function () {
        const idKategori = $(this).val();

        $.ajax({
            url: `/get-device-rusak-by-kategori/${idKategori}`,
            type: 'GET',
            success: function (response) {
                console.log('Respons dari Backend:', response);
                const tableBody = $('#tableData tbody');
                tableBody.empty();

                if (response.length > 0) {
                    response.forEach((device, index) => {
                        tableBody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${device.pendanaan}</td>
                                <td>${device.nomor_it}</td>
                                <td>${device.kategori}</td>
                                <td>${device.sub_kategori}</td>
                                <td>${device.umur}</td>
                                <td>
                                    <span class="${device.kondisi === '1' ? '' : 'text-danger'}">
                                        ${device.kondisi === '1' ? 'Baik' : 'Rusak'}
                                    </span> <br>
                                    <a href="/${device.id}" target="_blank">Lihat kondisi</a>
                                </td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modal-detail-device"
                                            data-nomor-it="${device.nomor_it}"
                                            data-nomor-pmn="${device.pendanaan}"
                                            data-kategori="${device.kategori}"
                                            data-tipe="${device.sub_kategori}"
                                            data-umur="${device.umur}"
                                            data-processor="${device.processor_type}"
                                            data-storage-type="${device.storage_type}"
                                            data-storage-capacity="${device.storage_capacity}"
                                            data-memory-type="${device.memory_type}"
                                            data-memory-capacity="${device.memory_capacity}"
                                            data-vga-type="${device.vga_type}"
                                            data-vga-capacity="${device.vga_capacity}"
                                            data-serial_type="${device.serial_number}"
                                            data-os="${device.operation_system}"
                                            data-os-license="${device.os_license}"
                                            data-office="${device.office_type}"
                                            data-office-license="${device.office_license}"
                                            data-kondisi="${device.kondisi === '1' ? 'Baik' : 'Rusak'}"
                                            data-aplikasi="${device.aplikasi_lainnya}"
                                            data-keterangan="${device.keterangan_tambahan}">
                                        Detail Perangkat
                                    </button>
                                </td>
                                <td class="d-flex justify-content-start">
                                    <div class="me-2">
                                        <a class="btn btn-warning" href="">Edit</a>
                                    </div>
                                    <form action="" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus device ini?');" style="padding: 0; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" style="">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tableBody.append(`
                        <tr>
                            <td colspan="18" class="text-center">Tidak ada perangkat ditemukan</td>
                        </tr>
                    `);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching devices:', error);
            }
        });
    });
});
</script>