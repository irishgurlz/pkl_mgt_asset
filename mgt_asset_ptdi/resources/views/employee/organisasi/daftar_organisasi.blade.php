<!DOCTYPE html>
<html lang="en">

<head>
  <title>Daftar Organisasi</title>
</head>
@extends('employee.master')

@section('content')
@include('employee.component.modal-add-organisasi')
    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class="section-title" data-aos="fade-up">
            <h2>Daftar Organisasi</h2>
        </div>

        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="m-0 font-weight-bold">
                                <a href="/organisasi/create" class="btn btn-primary">+ Tambah Organisasi</a>
                            </h6>
                        </div>
                        
                        <form id="searchForm" method="GET" action="{{ route('organisasi.index') }}">
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="input-group me-2">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search Organisasi" value="{{ request('search') }}">
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
                                    <th>Divisi</th>
                                    <th>Nama Divisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            @include('employee.organisasi.table_organisasi')
                        </table>
                        @include('paginate', ['paginator' => $org])
                    </div>
                </div>
            </div>
        </div>
   </div>

   <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');

            searchInput.addEventListener('keyup', function(event) {
                let searchQuery = searchInput.value;

                fetch("{{ route('organisasi.index') }}?search=" + searchQuery, {
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
