<!DOCTYPE html>
<html lang="en">

<head>
  <title>Pendanaan</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')
    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class="section-title" data-aos="fade-up">
            <h2>Daftar Pendanaan</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <a href="/pendanaan/create" class="btn btn-primary">+ Tambah Pendanaan</a>
                    <form method="GET" action="{{ route('pendanaan.index') }}" class="d-flex">
                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Cari Pendanaan">
                        <button class="btn btn-primary ms-2" type="submit">Search</button>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-hover" id="tabel_pendanaan" cellspacing="0" style="width: 100%; table-layout: auto;">
                            <thead style="white-space: nowrap;">
                                <tr>
                                    <th scope="col" style="width: 5%">No</th>
                                    <th scope="col" style="width: 20%">Nomor PMN</th>
                                    <th scope="col" style="width: 20%">Deskripsi</th>
                                    <th scope="col" style="width: 15%">Tanggal</th>
                                    <th scope="col" style="width: 20%">Dokumen</th>
                                    <th scope="col" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            @include('pendanaan.component.tabel_pendanaan', ['pendanaan' => $pendanaan])
                        </table>
                    </div>
                    
                    <!-- <div class="d-flex justify-content-end mt-4">
                        {{ $pendanaan->links('pagination::bootstrap-5') }}
                    </div> -->
                    @include('paginate', ['paginator' => $pendanaan])
                </div>
            </div>
        </div>
   </div>

   <script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin untuk menghapus device ini?');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', function(event) {
            let searchQuery = searchInput.value;

            fetch("{{ route('pendanaan.index') }}?search=" + searchQuery, {
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


@endsection
