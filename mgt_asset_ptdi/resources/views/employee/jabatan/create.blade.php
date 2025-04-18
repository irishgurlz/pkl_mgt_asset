<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tambah Jabatan</title>
</head>

@extends('employee.master')

@section('content')
<div class="container section-title" data-aos="fade-up">
    <h2>Tambah Jabatan</h2>
</div><!-- End Section Title -->

<div class="container">
    <div class="row g-5 d-flex justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-gray">Edit Jabatan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive d-flex justify-content-center">
                        <form action="/jabatan" method="post" enctype="multipart/form-data">
                            @csrf
                            {{-- @method('PUT') --}}

                            <div class="row">
                                <!-- Left Section -->
                                <div class="col-12">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama" class="form-label">Jabatan</label>
                                            <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" required>
                                        </div>
                                        @error('nama')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end  mt-3">
                                <a href="/jabatan" class="btn btn-danger me-2" >Cancel</a>
                                <button type="submit" class="btn btn-primary" ">Add</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
