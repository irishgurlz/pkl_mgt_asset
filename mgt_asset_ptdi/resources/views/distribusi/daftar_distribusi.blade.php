<!DOCTYPE html>
<html lang="en">

<head>
  <title>Daftar Pendistribusian Asset</title>
</head>
@extends('employee.master')

@section('content')
@include('distribusi.component.modal-detail-device')

    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class ="section-title" data-aos="fade-up" >
            <h2>Daftar Pendistribusian Asset</h2>
        </div>

        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-between">
                            <h6 class="m-0 font-weight-bold me-2">
                                <a href="/distribusi/create" class="btn btn-primary">+ Tambah Distribusi Asset</a>
                            </h6>

                            <form action="/distribusi/export" method="GET">
                                <button type="submit" class="btn btn-success">Export to Excel</button>
                            </form>
                            
                        </div>
                        
                        <form id="searchForm" method="GET" action="{{ route('distribusi.index') }}">
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="input-group me-2">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search Asset" value="{{ request('search') }}">
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- TABEL -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Penyerahan</th>
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            @include('distribusi.table-distribusi')
                        </table>
                        
                        @include('paginate', ['paginator' => $distribution])
                    </div>
                </div>
        </div>
        
   </div>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');

        searchInput.addEventListener('keyup', function(event) {
            let searchQuery = searchInput.value;

            fetch("{{ route('distribusi.index') }}?search=" + searchQuery, {
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