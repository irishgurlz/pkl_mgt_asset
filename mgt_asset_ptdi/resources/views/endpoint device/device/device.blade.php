<!DOCTYPE html>
<html lang="en">

<head>
  <title>Master Perangkat Komputer</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')
    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class="section-title" data-aos="fade-up">
            <h2>Master Perangkat Komputer</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Kategori Dropdown -->
           <div class="form-group mb-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select id="id_kategori" name="id_kategori" class="form-control">
                    <option value="" disabled selected>-- Pilih Perangkat Komputer--</option>
                    @foreach($kategori as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
                @error('id_kategori')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <a href="/device/create" class="btn btn-primary">+ Tambah Perangkat Komputer</a>
                    <form method="GET" action="{{ route('device.index') }}" class="d-flex">
                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Cari Perangkat">
                        <button class="btn btn-primary ms-2" type="submit">Search</button>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-hover" id="tabel_device" cellspacing="0" style="width: 100%; table-layout: auto;">
                            <thead style="white-space: nowrap;">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nomor PMN</th>
                                    <th scope="col">Nomor Asset</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Tipe Perangkat</th>
                                    <th scope="col">Umur</th>
                                    <th scope="col">Kondisi</th>
                                    <th scope="col">Detail</th>
                                    <th scope="col">Aksi</th>
                                    @include('endpoint device.device.component.modal_detail_device', ['devices' => $devices])
                                </tr>
                            </thead>
                            @include('endpoint device.device.component.search_table_device', ['devices' => $devices])
                        </table>
                    </div>

                    <!-- <div class="d-flex justify-content-end mt-4">
                        {{ $devices->links('pagination::bootstrap-5') }}
                    </div> -->
                    @include('paginate', ['paginator' => $devices])
                </div>
            </div>
        </div>
   </div>

   <script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin untuk menghapus perangkat ini?');
    }
    </script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
$(document).ready(function () {
    $('#id_kategori').on('change', function () {
        const idKategori = $(this).val();

        $.ajax({
            url: `/get-device-by-kategori/${idKategori}`,
            type: 'GET',
            success: function (response) {
                console.log(response); 
                const tableBody = $('#tabel_device tbody');
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
                                    <form action="" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat ini?');" style="padding: 0; margin: 0;">
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

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', function(event) {
        let searchQuery = searchInput.value;

        fetch("{{ route('device.index') }}?search=" + searchQuery, {
            method: 'GET',
            headers: {
                'Accept': 'text/html',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.querySelector('tbody').innerHTML = data;
        });
    });
});
</script>
@endsection
