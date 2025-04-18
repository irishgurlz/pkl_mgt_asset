<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tambah Sub Kategori</title>
</head>

@extends('endpoint device.endpointLayout')

@section('content')

<!-- TITLE -->
<div class="container" data-aos="fade-up">
    <div class="section-title" data-aos="fade-up">
        <h2>Tambah Sub Kategori</h2>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="card shadow mb-4">
            <div class="card-body p-4">
            <form id="form-edit-sub" action="{{ route('sub-kategori.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3 align-items-center">
                <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                <div class="col-sm-9">
                    <select name="kategori" id="kategori" class="form-select" required>
                        <option value="" disabled selected>--Pilih Kategori--</option>
                        @forelse ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}
                            </option>
                        @empty
                            <option value="">Tidak Ada Kategori</option>
                        @endforelse
                    </select>
                </div>
            </div>

                    <div class="row mb-3 align-items-center">
                        <label for="nama" class="col-sm-3 col-form-label">Nama Sub Kategori</label>
                        <div class="col-sm-9">
                            <input 
                                type="text" 
                                id="nama" 
                                name="nama" 
                                class="form-control" 
                                placeholder="Masukkan sub kategori" 
                                required>
                            <div id="nama-status" class="text-danger"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="/sub-kategori" type="button" class="btn btn-danger me-2" style="width: 120px;">Batal</a>
                        <button type="submit" id="submit-btn" class="btn btn-primary" style="width: 120px;">Tambah</button>
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
                    url: '{{ route('checkNamaSub') }}', 
                    type: 'POST',
                    data: {
                        nama: nama,
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(response) {
                        if (response.status === 'available') {
                            $('#nama-status').text('Sub kategori tersedia');
                            $('#nama-status').removeClass('text-danger').addClass('text-success');
                            $('#submit-btn').prop('disabled', false); 
                        } else if (response.status === 'taken') {
                            $('#nama-status').text('Sub kategori sudah terdaftar');
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
