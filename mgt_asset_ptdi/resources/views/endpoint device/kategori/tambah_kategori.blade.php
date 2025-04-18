<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tambah Kategori</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')

<!-- TITLE -->
<div class="container" data-aos="fade-up">
    <div class="section-title" data-aos="fade-up">
        <h2>Tambah Kategori</h2>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="card shadow mb-4">
            <div class="card-body p-4">
            <form id="form-tambah-kategori" action="{{route('kategori.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama Kategori</label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            class="form-control" 
                            placeholder="Masukkan nama kategori" 
                            required>
                    </div>
                    <div id="nama-status" class="text-danger"></div>
                    @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="jenis_kategori" class="col-form-label">Jenis Kategori</label>
                        <select name="jenis_kategori" id="jenis_kategori" class="form-select" required>
                            <option value="" disabled selected>--Pilih Jenis Kategori--</option>
                            <option value="1" {{ old('jenis_kategori') == '1' ? 'selected' : '' }}>Perangkat Komputer</option>
                            <option value="2" {{ old('jenis_kategori') == '2' ? 'selected' : '' }}>Perlengkapan Kantor</option>
                            <option value="0" {{ old('jenis_kategori') == '0' ? 'selected' : '' }}>Lainnya</option>
                        </select>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="/kategori" class="btn btn-danger me-2" style="width: 25%;">Batal</a>
                        <button type="submit" id="submit-btn" class="btn btn-primary" style="width: 25%;" disabled>Tambah</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nama').on('input', function() {
            var nama = $(this).val(); 

            if (nama) {
                $.ajax({
                    url: '{{ route('checkNama') }}', 
                    type: 'POST',
                    data: {
                        nama: nama,
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(response) {
                        if (response.status === 'available') {
                            $('#nama-status').text('Nama kategori tersedia');
                            $('#nama-status').removeClass('text-danger').addClass('text-success');
                            $('#submit-btn').prop('disabled', false); 
                        } else if (response.status === 'taken') {
                            $('#nama-status').text('Nama kategori sudah terdaftar');
                            $('#nama-status').removeClass('text-success').addClass('text-danger');
                            $('#submit-btn').prop('disabled', true); 
                        }
                    },
                    error: function(xhr) {
                        $('#nama-status').text('Terjadi kesalahan, coba lagi nanti');
                        $('#nama-status').removeClass('text-success').addClass('text-danger');
                        $('#submit-btn').prop('disabled', true); 
                    }
                });
            } else {
                $('#nama-status').text('');
                $('#submit-btn').prop('disabled', false); 
            }
        });
    });
</script>