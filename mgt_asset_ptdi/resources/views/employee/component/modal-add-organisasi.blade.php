<!-- Modal -->
<div class="modal fade" id="modal-add-organisasi"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg d-flex justify-content-center">
        <div class="modal-content" style="background-color: #ffff; border-radius: 15px; width: 60%;">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Organisasi</h5>
            </div>
            <div class="modal-body">
                <form id="form-add-organisasi" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-2 d-flex justify-content-between">
                        <div class="me-3">Kode Organisasi</div>
                        <input type="text" class="input-form" name="kode_org" required> 
                    </div>
                    @error('kode_org')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="mt-2 d-flex justify-content-between">
                        <div class="me-3">Nama Organisasi</div>
                        <input type="text" class="input-form" name="nama" required> 
                    </div>
                    @error('nama')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="d-flex justify-content-end mt-3">
                        <a href="/organisasi" class="btn btn-cancel me-2" style="width:25%;">Cancel</a>
                        <button type="submit" class="btn btn-add" style="width:25%;">Add</button>
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
$('#form-add-organisasi').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: `/organisasi`, 
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Organisasi berhasil ditambahkan',
                timer: 3000,
                showConfirmButton: true,
            }).then(() => {
                $('#modal-add-organisasi').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            });

            if (response && response.data) {
                let data = response.data;

                let rowCount = $('#data-table tbody tr').length + 1;
                let newRow = `
                    <tr>
                        <td>${rowCount}</td>
                        <td>${data.kode_org}</td>
                        <td>${data.nama}</td>
                        <td class="d-flex justify-content-start">
                            <div class="me-2">
                                <a class="btn btn-warning" href="/organisasi/${data.id}/edit">Edit</a>
                            </div>
                            <form action="/organisasi/${data.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this organisasi?');" style="padding: 0; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>`;

                // Tambahkan baris ke tabel
                $('#data-table tbody').append(newRow);

                // Reset form
                $('#form-add-organisasi')[0].reset();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Data tidak valid.',
                });
            }
        },
        error: function (xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: xhr.responseJSON.errors.nama ? xhr.responseJSON.errors.nama[0] : 'Gagal menyimpan data.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal menghubungkan ke server.',
                });
            }
        }
    });
});


</script>
