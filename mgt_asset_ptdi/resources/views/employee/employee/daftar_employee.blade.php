<!DOCTYPE html>
<html lang="en">

<head>
  <title>Daftar Employee</title>
</head>

@extends('employee.master')


    @section('content')

        <!-- TITLE -->
    <div class="container" data-aos="fade-up" style="width:100%">
            <div class ="section-title" data-aos="fade-up" >
                <h2>Daftar Employee</h2>
            </div>

            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card shadow mb-4">
                    <div class="card-header py-3">

                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="m-0 font-weight-bold">
                                    <a class="btn btn-primary" href="/employee/create">+ Tambah Employee</a>
                                </h6>
                            </div>

                            {{-- <form action="/import-excel" method="GET">
                                <button type="submit" class="btn btn-success">Import From Excel</button>
                            </form> --}}
                            
                            <form id="searchForm" method="GET">
                                <div class="mb-3 d-flex justify-content-between"">
                                    <div class="input-group me-2">
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Search Employee" value="{{ request('search') }}">
                                    </div>
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- TABEL -->
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                            <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Employee NIK</th>
                                        <th>Employee Name</th>
                                        <th>Employee Org</th>
                                        <th>Employee Level</th>
                                        <th>Role</th>
                                        <th>Detail Asset</th>
                                        <th>Aksi</th>
                                        <th>Atur Role</th>
                                    </tr>
                                </thead>
                                @include('employee.component.table-employee')
                            </table>
                            @include('paginate', ['paginator' => $actors])

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

                fetch("{{ route('employee.index') }}?search=" + searchQuery, {
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