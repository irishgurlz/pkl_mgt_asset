<!DOCTYPE html>
<html lang="en">

<head>
  <title>Kategori</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')

    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class ="section-title" data-aos="fade-up" >
            <h2>Kategori</h2>
        </div>

        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <a href="/kategori/create" class="btn btn-primary">+ Tambah Kategori</a>
                    <form method="GET" action="{{ route('kategori.index') }}" class="d-flex">
                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Cari Kategori">
                        <button class="btn btn-primary ms-2" type="submit">Search</button>
                    </form>
                </div>

                <!-- TABEL -->
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Tabel -->
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0" style="table-layout: auto;">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col" style="width: 75%;">Kategori</th>
                                    <th scope="col" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            @include('endpoint device.kategori.component.search_table', ['kategoris' => $kategoris])
                        </table>

                        <!-- <div class="d-flex justify-content-end mt-3">
                            {{ $kategoris->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                        </div> -->
                        @include('paginate', ['paginator' => $kategoris])
                    </div>
                </div>
            </div>
        </div>
   </div>

   <script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin untuk menghapus kategori ini?');
    }
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', function(event) {
            let searchQuery = searchInput.value;

            fetch("{{ route('kategori.index') }}?search=" + searchQuery, {
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