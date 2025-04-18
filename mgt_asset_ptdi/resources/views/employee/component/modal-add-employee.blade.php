<!-- Modal -->
<div class="modal fade" id="modal-add-employee" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-lg d-flex justify-content-center">
        <div class="modal-content" style="background-color: #ffff; border-radius: 15px; width: 60%;">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Employee</h5>
            </div>
            <div class="modal-body">
                <form id="form-add-employee" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-2 d-flex justify-content-between">
                        <div class="me-3">Nama Employee</div>
                        <input type="text" class="input-form" name="nama" required> 
                    </div>
                    @error('nama')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="mt-2 d-flex justify-content-between">
                        <div class="me-3">NIK Employee</div>
                        <input type="text" class="input-form" name="nik" required> 
                    </div>
                    @error('nik')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="mt-2 d-flex justify-content-between">
                        <div class="me-3">Organisasi</div>
                        <select name="kode_org" class="input-form" required>
                            <option value="" disabled selected>--Pilih Organisasi--</option>
                            
                            @forelse ($org as $item)
                            {{-- Debugging nama --}}
                                <option value="{{$item->kode_org}}">{{$item->nama}}</option>
                            @empty
                                <option value="">Tidak Ada Organisasi</option>
                            @endforelse
                        </select>
                    </div>
                    @error('kode_org')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="mt-2 d-flex justify-content-between">
                        <div class="me-3">Jabatan</div>
                        <select name="kode_jabatan" class="input-form" required>
                            <option value="" disabled selected>--Pilih Jabatan--</option>
                            @forelse ($jabatan as $item)
                                <option value="{{$item->id}}">{{$item->nama}}</option>
                            @empty
                                <option value="">Tidak Ada Jabatan</option>
                            @endforelse
                        </select>
                    </div>
                    @error('kode_jabatan')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="d-flex justify-content-end mt-3">
                        <a href="/employee" class="btn btn-cancel me-2" style="width:25%;">Cancel</a>
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
$('#form-add-employee').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: `/employee`, 
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Employee berhasil ditambahkan',
                timer: 3000,
                showConfirmButton: true,
            }).then(() => {
                $('#modal-add-employee').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            });

            // Validasi respons data
            if (response && response.data) {
                let data = response.data;

                // Ambil nomor urut dari tabel
                let rowCount = $('#data-table tbody tr').length + 1;

                // Tambahkan baris baru ke tabel
                let newRow = `
                    <tr>
                        <td>${rowCount}</td>
                        <td>${data.nik}</td>
                        <td>${data.nama}</td>
                        <td>${data.org_name}</td>
                        <td>${data.kode_jabatan}</td>
                        <td>
                            <a class="btn btn-info" href="/employee/${data.id}/asset">
                                Detail Asset
                            </a>
                        </td>
                        <td class="d-flex justify-content-start">
                            <div class="me-2">
                                <a class="btn btn-warning" href="/employee/${data.id}/edit">Edit</a>
                            </div>
                            <form action="/employee/${data.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');" style="padding: 0; margin: 0;">
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
                $('#form-add-employee')[0].reset();
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
