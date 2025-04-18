<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sub Kategori</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')
    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class ="section-title" data-aos="fade-up" >
            <h2>Sub Kategori</h2>
        </div>

        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
           <!-- Kategori Dropdown -->
           <div class="form-group mb-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select id="id_kategori" name="id_kategori" class="form-control">
                    <option value="" disabled selected>-- Pilih Kategori --</option>
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
                    <a href="/sub-kategori/create" class="btn btn-primary">+ Tambah Sub Kategori</a>
                    <form method="GET" action="{{ route('sub-kategori.index') }}" class="d-flex">
                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Cari Sub Kategori">
                        <button class="btn btn-primary ms-2" type="submit">Search</button>
                    </form>
                </div>
                
                <!-- TABEL -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="sub_kategori_table" width="100%" cellspacing="0" style="table-layout: auto;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 5%;">No</th>
                                    <th scope="col" style="width: 25%;">Kategori</th>
                                    <th scope="col" style="width: 50%;">Sub Kategori</th>
                                    <th scope="col" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            @include('endpoint device.type kategori.component.search_table_tipe', ['subKategoris' => $subKategoris])
                        </table>

                        <!-- <div class="d-flex justify-content-end mt-4">
                            {{ $subKategoris->links('pagination::bootstrap-5') }}
                        </div> -->
                        @include('paginate', ['paginator' => $subKategoris])
                    </div>
                </div>
        </div>
        </div>
        
   </div>

   <script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin untuk menghapus sub kategori ini?');
    }
    </script>

    <script>
    document.getElementById('id_kategori').addEventListener('change', function () {
        const kategoriId = this.value;
        const tableBody = document.querySelector('#sub_kategori_table tbody'); // Ensure we target the tbody section

        tableBody.innerHTML = ''; 

        fetch(`/get-sub-by-kategori/${kategoriId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach((subKategori, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${subKategori.kategori ? subKategori.kategori.nama : 'Tidak Ada Kategori'}</td>
                            <td>${subKategori.nama}</td>
                            <td>
                                <a href="/sub-kategori/${subKategori.id}/edit" class="btn btn-warning">Edit</a>
                                <form action="/sub-kategori/${subKategori.id}" method="POST" style="display: inline-block;" onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="4" class="text-center">Tidak ditemukan sub kategori</td>`;
                    tableBody.appendChild(row);
                }
            })
            .catch(error => {
                alert(`Error: ${error.message || 'Unknown error occurred'}`);
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan="4" class="text-center text-danger">Error loading data</td>`;
                tableBody.appendChild(row);
            });
    });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('input', function(event) {
                let searchQuery = searchInput.value;

                fetch("{{ route('sub-kategori.index') }}?search=" + searchQuery, {
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