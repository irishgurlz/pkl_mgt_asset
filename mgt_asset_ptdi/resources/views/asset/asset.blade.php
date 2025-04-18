<!DOCTYPE html>
<html lang="en">

<head>
  <title>Master Perlengkapan Kantor</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')
    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class="section-title" data-aos="fade-up">
            <h2>Master Perlengkapan Kantor</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Kategori Dropdown -->
           <!-- <div class="form-group mb-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select id="id_kategori" name="id_kategori" class="form-control">
                    <option value="" disabled selected>-- Pilih Kategori Asset--</option>
                    @foreach($kategori as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
                @error('id_kategori')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div> -->

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <a href="/asset/create" class="btn btn-primary">+ Tambah Perlengkapan Kantor</a>
                    <form method="GET" action="{{ route('asset.index') }}" class="d-flex">
                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Cari Perlengkapan">
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
                                    <th scope="col">Nama</th>
                                    <th scope="col">Umur</th>
                                    <th scope="col">Kondisi</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            @include('asset.component.search_table_asset', ['asset' => $asset])
                        </table>
                    </div>

                    <!-- <div class="d-flex justify-content-end mt-4">
                        {{ $asset->links('pagination::bootstrap-5') }}
                    </div> -->
                    @include('paginate', ['paginator' => $asset])
                </div>
            </div>
        </div>
   </div>

   <script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin untuk menghapus perlengkapan ini?');
    }
    </script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
    
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', function(event) {
        let searchQuery = searchInput.value;

        fetch("{{ route('asset.index') }}?search=" + searchQuery, {
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
