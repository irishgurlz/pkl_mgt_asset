<!DOCTYPE html>
<html lang="en">

<head>
  <title>Detail History</title>
</head>

@extends('employee.master')

@section('content')

    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class ="section-title" data-aos="fade-up" >
            <h2>Detail History</h2>

        </div>

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- <h6 class="m-0 font-weight-bold">
                        <a href="/kategori/tambah-kategori" class="btn btn-primary">+ Tambah Kategori</a>
                    </h6> --}}
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
                                    @forelse ($history as $key => $item)
                                        <th>Pemilik {{$key + 1}}</th>
    
                                    @empty
                                        <th>tidak ada</th>
                                    @endforelse
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{$history_status->nomor_penyerahan}}</td>
                                    <td>{{$history_status->nomor_asset}}</td>
                                    @forelse ($history as $key => $item)
                                        <td>{{$item->employee->nama}}
                                            @if (($key + 1) > 1)
                                                <p>
                                                    <a href="{{ asset($item->dokumen_pengalihan) }}" target="_blank">Lihat Dokumen</a>
                                                </p>
                                            @endif
                                        </td>
                                    @empty
                                        <td>tidak ada</td>
                                    @endforelse 
                            </tbody>
                        </table>
                        {{-- @include('paginate', ['paginator' => $history]) --}}
                    </div>
                </div>
        </div>
        
   </div>

   <script>

@endsection