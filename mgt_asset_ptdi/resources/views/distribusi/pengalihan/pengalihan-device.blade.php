@extends('employee.master')

@section('content')
<!-- TITLE -->
<div class="container section-title" data-aos="fade-up">
    <h2>Pengalihan Asset</h2>
</div><!-- End Section Title -->

<div class="container">
    <div class="row g-5 d-flex justify-content-center">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive" style="overflow:hidden">
                    <div class="card-body">
                        <form action="/distribusi/{{$distribution->id}}/detail/{{$distribution->device->id}}/updatePengalihanDevice" id="form-add-asset" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="row">
                                <div id="form-asset">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3 text-center">
                                            <h6 class="m-0 font-weight-bold text-gray">Distribusi</h6>
                                        </div>

                                        <div class="card-body">
                                            <div class="form-group mt-3">
                                                <label for="nomor_penyerahan" class="form-label">Nomor Penyerahan</label>
                                                <input type="text" name="nomor_penyerahan" id="nomor_penyerahan" placeholder="Masukkan Nomor Penyerahan" class="form-control bg-light" value="{{ old('nomor_penyerahan', $distribution->nomor_penyerahan) }}" required readonly>
                                                {{-- <div id="nomor_penyerahan-status" style="color: red; font-size: 14px;"></div> --}}
                                                @error('nomor_it')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Nomor Asset -->
                                            <div class="form-group mt-3">
                                                <label for="nomor_it" class="form-label">Nomor Asset</label>
                                                <input type="text" name="nomor_it" id="nomor_it" placeholder="Masukkan Nomor Asset" class="form-control bg-light" onkeyup="fetchAssetData()" value="{{ old('nomor_it', $distribution->nomor_it) }}" required readonly>
                                                {{-- <div id="nomor_it-status" style="color: red; font-size: 14px;"></div> --}}
                                                @error('nomor_it')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- NIK -->
                                            <div class="form-group">
                                                <label for="nik" class="form-label">NIK</label>
                                                <input type="text" name="nik" id="nik" placeholder="Masukkan NIK" class="form-control" onkeyup="fetchUserData()" value="{{ old('nik', $distribution->nik) }}"  required>
                                                <div class="nik-status text-danger"></div>
                                                
                                                @error('nik')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            
                                            <!-- Tanggal -->
                                            <div class="form-group mt-3">
                                                <label for="tanggal_pengalihan" class="form-label">Tanggal Pengalihan</label>
                                                <input type="date" name="tanggal_pengalihan" id="tanggal_pengalihan" placeholder="Masukkan Tanggal" class="form-control" required>
                                                @error('tanggal')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Dokumen -->
                                            <div class="form-group mt-3">
                                                <label for="dokumen_pengalihan" class="form-label">Dokumen Pengalihan</label>
                                                <input type="file" name="dokumen_pengalihan" class="form-control">
                                                @error('dokumen_pengalihan')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-danger me-2" style="width: 120px;">Batal</button>
                                <button type="submit" class="btn btn-primary" style="width: 120px;">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).on('keyup blur', 'input[name="nik"]', function () {
    let nik = $(this).val().trim();
    let nikStatus = $(this).closest('.form-group').find('.nik-status');

    // Jika input kosong
    if (nik.length === 0) {
        nikStatus.text('NIK harus diisi').removeClass('text-success').addClass('text-danger');
        return;
    }

    // AJAX request untuk cek NIK
    $.ajax({
        url: "{{ route('fetch-user-data') }}",
        type: 'GET',
        data: { nik: nik },
        success: function (response) {
            if (response.success) {
                nikStatus.text('NIK tersedia (Nama: ' + response.nama + ')')
                    .removeClass('text-danger')
                    .addClass('text-success');
            } else {
                nikStatus.text('NIK belum terdaftar')
                    .removeClass('text-success')
                    .addClass('text-danger');
            }
        },
        error: function () {
            nikStatus.text('Terjadi kesalahan pada server')
                .removeClass('text-success')
                .addClass('text-danger');
        }
    });
});
</script>

@endsection
