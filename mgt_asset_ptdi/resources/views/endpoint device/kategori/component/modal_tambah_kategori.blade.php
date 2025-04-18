<!-- Modal -->
<div class="modal fade" id="modal_tambah_kategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl d-flex justify-content-center">
        <div class="modal-content" style="border-radius: 5px; width: 60%;">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
            </div>
            <div class="modal-body">
                <form id="form-tambah-kategori" method="POST" enctype="multipart/form-data">
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
                    @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group mt-3">
                        <label for="is_device" class="form-label">Apakah kategori tersebut merupakan perangkat?</label>
                        <div>
                            <input 
                                type="radio" 
                                id="is_device_ya" 
                                name="is_device" 
                                value="1" 
                                required>
                            <label for="is_device_ya">Ya</label>
                        
                            <input 
                                type="radio" 
                                id="is_device_tidak" 
                                name="is_device" 
                                value="0" 
                                required>
                            <label for="is_device_tidak">Tidak</label>
                        </div>
                    </div>
                    @error('is_device')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="d-flex justify-content-end mt-4">
                        <a href="/kategori" class="btn btn-danger me-2" style="width: 25%;">Batal</a>
                        <button type="submit" class="btn btn-primary" style="width: 25%;">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#form-tambah-kategori').on('submit', function (e) {
            e.preventDefault(); 

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('kategori.store') }}", 
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message || 'Kategori berhasil ditambahkan!',
                        timer: 3000,
                        showConfirmButton: true,
                    }).then(() => {
                        $('#form-tambah-kategori')[0].reset(); 
                        $('#modal_tambah_kategori').modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                    });

                    if (response && response.data) {
                        let data = response.data;

                        let rowCount = $('#tabel_kategori tbody tr').length + 1;

                        let newRow = `
                            <tr>
                                <td>${rowCount}</td>
                                <td>${data.nama}</td>
                                <td class="d-flex justify-content-start">
                                    <div class="me-2">
                                        <a class="btn btn-warning" href="/kategori/${data.id}/edit">Edit</a>
                                    </div>
                                    <form action="/kategori/${data.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" style="padding: 0; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>`;

                        $('#tabel_kategori tbody').append(newRow);
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'Gagal menghubungkan ke server.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: errorMessage,
                    });
                }
            });
        });
    });
</script>