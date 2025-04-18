<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tambah Pendanaan</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')

<!-- TITLE -->
<div class="container" data-aos="fade-up">
    <div class="section-title" data-aos="fade-up">
        <h2>Tambah Pendanaan</h2>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-gray text-center">Pendanaan</h6>
            </div>
            <div class="card-body p-4">
            <form id="form-tambah-pendanaan" action="{{route('pendanaan.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-2">
                        <!-- Nomor PMN -->
                        <div class="form-group">
                            <label for="no_pmn" class="form-label">Nomor PMN</label>
                            <input type="text" id="no_pmn" name="no_pmn" class="form-control" placeholder="Masukkan Nomor PMN" required>
                            <div id="pmn-status" class="text-danger"></div>
                        </div>
                        @error('no_pmn')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="tanggal" class="form-label">Tanggal Pendanaan</label>
                            <input type="date" name="tanggal" id="tanggal" placeholder="Masukkan Tanggal" class="form-control" value="{{old('umur')}}"required>
                            @error('tanggal')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        
                        <!-- Deskripsi -->
                        <div class="col-6 pe-3">
                            <div class="form-group">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="col-lg-12" name="deskripsi" value="{{old('deskripsi')}}" placeholder="Masukkan deskripsi pendanaan" style="height:150px;" required></textarea>
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
                                <button type="submit" class="btn btn-primary" style="width: 50%;">Tambah</button>
                            </div>
                        </div>              
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- AJAX Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#no_pmn').on('input', function() {
            var no_pmn = $(this).val(); 

            if (no_pmn) {
                $.ajax({
                    url: '{{ route('checkPMN') }}', 
                    type: 'POST',
                    data: {
                        no_pmn: no_pmn,
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(response) {
                        if (response.status === 'available') {
                            $('#pmn-status').text('Nomor PMN tersedia'); 
                            $('#pmn-status').removeClass('text-danger').addClass('text-success');
                        }
                    },
                    error: function(xhr) {
                        $('#pmn-status').text('Nomor PMN telah terdaftar');
                        $('#pmn-status').removeClass('text-success').addClass('text-danger');
                    }
                });
            } else {
                $('#pmn-status').text('');
            }
        });
    });
</script>