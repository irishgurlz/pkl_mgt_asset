<!DOCTYPE html>
<html lang="en">

<head>
  <title>Daftar Jabatan</title>
</head>
@extends('employee.master')

@section('content')
@include('employee.component.modal-add-jabatan')


    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class ="section-title" data-aos="fade-up" >
            <h2>Daftar Jabatan</h2>
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
                                <a href="/jabatan/create" class="btn btn-primary">+ Tambah Jabatan</a>
                            </h6>
                        </div>
                        
                        <form id="searchForm" method="GET">
                            <div class="mb-3 d-flex justify-content-between"">
                                <div class="input-group me-2">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search Jabatan" value="{{ request('search') }}">
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
                                    <th scope="col">No</th>
                                    <th scope="col" style="width: 75%;">Jabatan</th>
                                    <th scope="col" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($jabatan as $key => $item)    
                                <tr>
                                    <td>{{ $loop->iteration + $jabatan->firstItem() - 1 }}</td>
                                    <td>{{$item->nama}}</td>
                                
                                    <td class="d-flex justify-content-center">
                                        <div class="me-2">
                                            <a class="btn btn-warning" href="/jabatan/{{$item->id}}/edit">Edit</a>
                                        </div>

                                        <form action="/jabatan/{{$item->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this jabatan?');" style="padding: 0; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit" style="">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data employee</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @include('paginate', ['paginator' => $jabatan])
                    
                    </div>
                </div>
        </div>
        
   </div>

   <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');

            searchInput.addEventListener('keyup', function(event) {
                let searchQuery = searchInput.value; 

                fetch("{{ route('jabatan.index') }}?search=" + searchQuery, {
                    method: 'GET',
                    headers: {
                        'Accept': 'text/html',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('tableData').innerHTML = data;
                });
            });
        });
    </script>



@endsection