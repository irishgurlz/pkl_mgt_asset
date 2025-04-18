<!-- Modal -->
<div class="modal fade" id="modal-add-asset" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg d-flex justify-content-center" style="max-width: 50%;">
        <div class="modal-content" style="background-color: #ffff; border-radius: 15px;">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Asset</h5>
            </div>
            <div class="modal-body">
                <form id="form-add-asset" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-between" style="margin-left:10%; margin-right:10%">
                        <div class="">
                            <!-- Form Nomor Asset -->
                            <div class="form-group mb-3">
                                <label for="nomor_asset" class="form-label">Nomor Asset</label>
                                <input type="text" name="nomor_asset" id="nomor_asset" placeholder="Masukkan Nomor Asset" class="form-control" required>
                                @error('nomor_asset')
                                    <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                            </div>
        
                            <!-- Card Pengguna -->
                            <div class="card shadow p-4 mb-3">
                                <div class="card-header py-3 text-center">
                                    <h6 class="m-0 font-weight-bold text-gray">Pengguna</h6>
                                </div>
                                <div class="card-body">

                                     <!-- NIK Pemilik Asset -->
                                     <div class="form-group mb-3">
                                        <label for="nik" class="form-label">NIK Pemilik Asset</label>
                                        <input type="text" name="nik" id="nik" placeholder="Masukkan NIK" class="form-control" onkeyup="fetchUserData()" required>
                                        @error('nik')
                                            <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <!-- Nama Pemilik Asset -->
                                    <div class="form-group mb-3">
                                        <label for="nama" class="form-label">Nama Pemilik Asset</label>
                                        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama" class="form-control" required readonly>
                                        @error('nama')
                                            <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
        
                                    <!-- Organisasi -->
                                    <div class="form-group mb-3">
                                        <label for="kode_org" class="form-label">Organisasi</label>
                                        <input type="text" name="kode_org" id="kode_org" placeholder="Masukkan Organisasi" class="form-control" required readonly>
                                        @error('kode_org')
                                            <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
        
                                    <!-- Lokasi -->
                                    <div class="form-group mb-3">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" id="lokasi" placeholder="Masukkan Lokasi" class="form-control" required>
                                        @error('lokasi')
                                            <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Action -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="/asset" class="btn btn-cancel me-2" style="width:25%;">Cancel</a>
                        <button type="submit" class="btn btn-add" style="width:25%;">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   function fetchUserData() {
    let nik = $('#nik').val();  

    if (nik) {
        $.ajax({
            url: '/fetch-user-data',  
            method: 'GET',  
            data: {
                _token: '{{ csrf_token() }}',  
                nik: nik  
            },
            success: function(response) {
                if (response.success) {
                    $('#nama').val(response.user.nama);
                } else {
                    $('#nama').val('');
                }
            },
            error: function() {
                alert('Something went wrong!');
            }
        });
    }
}

</script>
