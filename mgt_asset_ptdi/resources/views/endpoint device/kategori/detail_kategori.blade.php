@extends('endpoint device.endpointLayout')

@section('content')
@include('endpoint device.type kategori.component.modal_tambah_tipe')
    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class ="section-title" data-aos="fade-up" >
            <h2>Daftar Tipe Kategori</h2>
        </div>

        <div class="container-fluid">
            <!-- Kategori -->
            <div class="form-group mb-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select id="id_kategori" name="id_kategori" class="form-control">
                    <option value="" disabled>-- Pilih Kategori --</option>
                    @forelse ($kategori as $item)
                        <option value="{{ $item->id }}" 
                            {{ $item->id == $idKategori->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @empty
                        <option value="">Tidak Ada Kategori</option>
                    @endforelse
                </select>
                @error('id_kategori')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">
                        <a data-bs-toggle="modal" data-bs-target="#modal_tambah_tipe" class="btn btn-primary">+ Tambah Tipe Kategori</a>
                    </h6>
                </div>
                
                <!-- TABEL -->
                <div class="card-body">
                    <div class="table-responsive">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-bordered table-hover" id="tipe-kategori-by-kategori" width="100%" cellspacing="0" style="table-layout: auto;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 5%;">No</th>
                                    <th scope="col" style="width: 25%;">Kategori</th>
                                    <th scope="col" style="width: 50%;">Tipe Kategori</th>
                                    <th scope="col" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            @forelse ($typeKategori as $type)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $type->kategori->nama }}</td>
                                    <td>{{ $type->nama }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route('type-kategori.edit', $type->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('detail.tipe.delete', $type->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirmDelete();">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada tipe kategori</td>
                                </tr>
                            @endforelse
                        </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-4">
                            {{ $typeKategori->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
        </div>
   </div>

   <script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin untuk menghapus tipe kategori ini?');
    }
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#id_kategori').on('change', function () {
            const idKategori = $(this).val();

            $.ajax({
                url: `/get-tipe-by-kategori/${idKategori}`,
                type: 'GET',
                success: function (response) {
                    console.log(response);
                const tableBody = $('#tipe-kategori-by-kategori tbody');
                tableBody.empty(); 

                if (response.length > 0) {
                    response.forEach((tipe, index) => {
                        tableBody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${tipe.kategori.nama}</td>
                                <td>${tipe.nama}</td>
                                <td>
                                    <div>
                                        <a href="/type-kategori/${tipe.id}/edit" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('detail.tipe.delete', $type->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirmDelete();">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tableBody.append(`
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada tipe kategori</td>
                        </tr>
                    `);
                }
            },
                error: function (xhr, status, error) {
                    console.error('Error fetching tipe kategori:', error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#id_kategori').on('change', function () {
            const idKategori = $(this).val();

            window.location.href = `/kategori/detail-kategori/${idKategori}`;
        });
    });
</script>
@endsection