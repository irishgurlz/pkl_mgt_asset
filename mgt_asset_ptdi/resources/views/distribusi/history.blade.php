<!DOCTYPE html>
<html lang="en">

<head>
  <title>History Distribusi Asset</title>
</head>

@extends('employee.master')

@section('content')

    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class ="section-title" data-aos="fade-up" >
            <h2>History Distribusi Asset</h2>
        </div>

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-end">
                    <form id="searchForm" method="GET">
                        <div class="mb-3 d-flex justify-content-between"">
                            <div class="input-group me-2">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search History" value="{{ request('search') }}">
                            </div>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                
                <!-- TABEL -->
                <div class="card-body">
                    <div class="table-responsive">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-bordered table-hover" id="tabel_kategori" width="100%" cellspacing="0" style="table-layout: auto;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Penyerahan</th>
                                    <th>Nomor Asset</th>
                                    <th>Pemilik Aset Saat Ini</th>
                                    <th>Lokasi</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>

                            @include('distribusi.table-history')
                        </table>
                        @include('paginate', ['paginator' => $history])

                    </div>
                </div>
        </div>
        
   </div>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const tableBody = document.querySelector('tbody');

        searchInput.addEventListener('keyup', function(event) {
            let searchQuery = searchInput.value;

            fetch("{{ route('history') }}?search=" + searchQuery, {
                method: 'GET',
                headers: {
                    'Accept': 'text/html',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(data => {
                tableBody.innerHTML = data;
            });
        });
    });
</script>
@endsection