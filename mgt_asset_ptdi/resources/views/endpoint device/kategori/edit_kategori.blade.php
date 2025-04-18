<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Kategori</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')

<!-- TITLE -->
<div class="container" data-aos="fade-up">
    <div class="section-title" data-aos="fade-up">
        <h2>Edit Kategori</h2>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="card shadow mb-4">
            <div class="card-body p-4">
                <form id="form-edit-kategori" action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Input Nama Kategori -->
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama Kategori</label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            class="form-control" 
                            value="{{ old('nama', $kategori->nama) }}" 
                            placeholder="Masukkan nama kategori" 
                            required>
                            <div id="nama-status" class="text-danger"></div>
                        @error('nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <!-- Select Jenis Kategori -->
                    <div class="form-group mb-3">
                        <label for="jenis_kategori" class="form-label">Jenis Kategori</label>
                        <select name="jenis_kategori" id="jenis_kategori" class="form-select" required>
                            <option value="" disabled {{ old('jenis_kategori', $kategori->jenis_kategori) == '' ? 'selected' : '' }}>
                                --Pilih Jenis Kategori--
                            </option>
                            <option value="1" {{ old('jenis_kategori', $kategori->jenis_kategori) == '1' ? 'selected' : '' }}>
                                Perangkat Komputer
                            </option>
                            <option value="2" {{ old('jenis_kategori', $kategori->jenis_kategori) == '2' ? 'selected' : '' }}>
                                Perlengkapan Kantor
                            </option>
                            <option value="0" {{ old('jenis_kategori', $kategori->jenis_kategori) == '0' ? 'selected' : '' }}>
                                Lainnya
                            </option>
                        </select>
                        @error('jenis_kategori')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('kategori.index') }}" class="btn btn-danger me-3" style="width: 150px;">Batal</a>
                        <button type="submit" id="submit-btn" class="btn btn-primary" style="width: 150px;">Edit</button>
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