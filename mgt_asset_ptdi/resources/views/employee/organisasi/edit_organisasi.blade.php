<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Organisasi</title>
</head>

@extends('employee.master')

@section('content')
<div class="container section-title" data-aos="fade-up">
    <h2>Edit Organisasi</h2>
</div><!-- End Section Title -->

<div class="container">
    <div class="row g-5 d-flex justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-gray">Edit Organisasi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive d-flex justify-content-center">
                        <form action="/organisasi/{{$org->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Left Section -->
                                <div class="col-12 col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="kode_org" class="form-label">Kode Organisasi</label>
                                            <input type="text" class="form-control" name="kode_org" value="{{ old('kode_org', $org->kode_org) }}" required readonly>
                                        </div>
                                        @error('kode_org')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Section -->
                                <div class="col-12 col-md-6">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama" class="form-label">Nama Divisi</label>
                                            <input type="text" class="form-control" name="nama" value="{{ old('nama', $org->nama) }}" required>
                                        </div>
                                        @error('nama')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <a href="/organisasi" class="btn btn-danger me-2" style="width:25%;">Cancel</a>
                                <button type="submit" class="btn btn-primary" style="width:25%;">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
