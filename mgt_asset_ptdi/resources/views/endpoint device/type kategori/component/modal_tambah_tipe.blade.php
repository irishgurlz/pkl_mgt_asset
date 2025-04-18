<!-- Modal -->
<div class="modal fade" id="modal_tambah_tipe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg d-flex justify-content-center">
        <div class="modal-content" style="border-radius: 10px;">
            <div class="modal-header d-flex justify-content-center">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tipe Kategori</h5>
            </div>
        
            <div class="modal-body">
                <form id="form-tambah-tipe" method="POST" enctype="multipart/form-data">
                   @csrf
                    <div class="row mb-3 align-items-center">
                        <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <select name="kategori" id="kategori" class="form-select" required>
                                <option value="" disabled selected>--Pilih Kategori--</option>
                                @forelse ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @empty
                                    <option value="">Tidak Ada Kategori</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="nama" class="col-sm-3 col-form-label">Nama Tipe Kategori</label>
                        <div class="col-sm-9">
                            <input 
                                type="text" 
                                id="nama" 
                                name="nama" 
                                class="form-control" 
                                placeholder="Masukkan tipe kategori" 
                                required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal" style="width: 120px;">Batal</button>
                        <button type="submit" class="btn btn-primary" style="width: 120px;">Tambah</button>
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

        $('#form-tambah-tipe').on('submit', function (e) {
            e.preventDefault(); 

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('type-kategori.store') }}", 
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message || 'Tipe kategori berhasil ditambahkan!',
                        timer: 3000,
                        showConfirmButton: true,
                    }).then(() => {
                        $('#form-tambah-tipe')[0].reset(); 
                        $('#modal_tambah_tipe').modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                    });

                    if (response && response.data) {
                        let data = response.data;

                        let rowCount = $('#type_kategori_table tr').length + 1;

                        let newRow = `
                            <tr>
                                <td>${rowCount}</td>
                                <td>${data.kategori.nama}</td>
                                <td>${data.nama}</td>
                                <td class="d-flex justify-content-start">
                                    <div class="me-2">
                                        <a class="btn btn-warning" href="/type-kategori/${data.id}/edit">Edit</a>
                                    </div>
                                    <form action="/type-kategori/${data.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tipe kategori ini?');" style="padding: 0; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>`;

                        $('#type_kategori_table').append(newRow); 
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
