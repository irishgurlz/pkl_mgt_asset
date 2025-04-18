<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Pendanaan</title>
</head>
@extends('endpoint device.endpointLayout')

@section('content')

<!-- TITLE -->
<div class="container" data-aos="fade-up">
    <div class="section-title" data-aos="fade-up">
        <h2>Edit Pendanaan</h2>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-gray text-center">Pendanaan</h6>
            </div>
            <div class="card-body p-4">
            <form id="form-tambah-pendanaan" action="{{route('pendanaan.update', $pendanaan->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-2">
                        <!-- Nomor PMN -->
                        <div class="form-group">
                            <label for="no_pmn" class="form-label">Nomor PMN</label>
                            <input type="text" id="no_pmn" name="no_pmn" value="{{ old('no_pmn', $pendanaan->no_pmn) }}" class="form-control bg-light" {{ isset($pendanaan->no_pmn) ? 'readonly' : '' }} required>
                        </div>
                        @error('no_pmn')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="tanggal" class="form-label">Tanggal Pendanaan</label>
                            <input type="date" name="tanggal" id="tanggal" placeholder="Masukkan Tanggal" class="form-control" value="{{old('tanggal', $pendanaan->tanggal)}}"required>
                            @error('tanggal')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        
                        <!-- Deskripsi -->
                        <div class="col-6 pe-3">
                            <div class="form-group">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="col-lg-12" name="deskripsi" placeholder="Masukkan deskripsi pendanaan" style="height:150px;">{{old('deskripsi', $pendanaan->deskripsi)}}</textarea>
                            </div>
                        </div>

                        <!-- Upload dokumen -->
                        <div class="col col-6 pt-3">
                            <small class="text-muted">Upload Dokumen PDF</small>
                            <input 
                                type="file" name="file_attach" class="form-control" accept=".pdf" required placeholder="Upload dokumen pendanaan">
                            @error('file_attach')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="d-flex justify-content-start mt-5 pt-3">
                                <a href="/pendanaan" class="btn btn-danger me-2" style="width: 50%;">Batal</a>
                                <button type="submit" class="btn btn-primary" style="width: 50%;">Edit</button>
                            </div>
                        </div>              
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection