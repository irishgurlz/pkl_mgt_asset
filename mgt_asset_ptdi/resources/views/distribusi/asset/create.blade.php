<form action="/distribution-asset" id="form-add-asset" method="POST" enctype="multipart/form-data">
    @csrf
    <div id="alert-success-asset"></div>
    <div class="row mb-3">
        <div class="col col-3">
            <div class="mb-2">
                <label for="nomor_penyerahan">Nomor Penyerahan</label>
                <input type="text" class="form-control" name="nomor_penyerahan" id="nomor_penyerahan_hidden" 
                    value="{{ old('nomor_penyerahan', session('nomor_penyerahan')) }}" style="background-color: #f2f2f2;" readonly>
                @error('nomor_penyerahan')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col col-3 d-flex align-items-center">
            <div class="mt-3" style="width:100%">
                <button class="btn btn-success" type="button" style="width:100%" id="add-asset-btn">Tambah Perlengkapan Kantor</button>
            </div>
        </div>
    </div>

    <div class="row">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="col-12 d-flex flex-wrap" id="form-asset-container">
            @foreach (old('nik', []) as $key => $nik)
                <div class="col-6 me-2 form-asset" id="form-asset-{{ $key + 1 }}" style="width: 49%">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3 text-center">
                            <h6 class="m-0 font-weight-bold text-gray">Distribusi {{ $key + 1 }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nik_{{ $key }}">NIK</label>
                                <input type="text" name="nik[]" id="nik_{{ $key }}" value="{{ $nik }}" placeholder="Masukkan NIK" class="form-control">
                                <div class="nik-status text-danger"></div>
                                @error("nik.{$key}")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nomor_asset_{{ $key }}">Nomor Asset</label>
                                <input type="text" name="nomor_asset[]" id="nomor_asset_{{ $key }}" value="{{ old('nomor_asset.' . $key) }}" placeholder="Masukkan Nomor Asset" class="form-control">
                                <div class="nomor_asset-status text-danger"></div>
                                @error("nomor_asset.{$key}")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="file_{{ $key }}">Dokumen</label>
                                <input type="file" name="file[]" id="file_{{ $key }}" class="form-control" required>
                                @error("file.{$key}")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal_{{ $key }}">Tanggal</label>
                                <input type="date" name="tanggal[]" id="tanggal_{{ $key }}" value="{{ old('tanggal.' . $key) }}" class="form-control">
                                @error("tanggal.{$key}")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lokasi_{{ $key }}">Lokasi</label>
                                <input type="text" name="lokasi[]" id="lokasi_{{ $key }}" value="{{ old('lokasi.' . $key) }}" placeholder="Masukkan Lokasi" class="form-control">
                                @error("lokasi.{$key}")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deskripsi_{{ $key }}">Deskripsi</label>
                                <textarea name="deskripsi[]" id="deskripsi_{{ $key }}" class="form-control" placeholder="Deskripsi">{{ old('deskripsi.' . $key) }}</textarea>
                                @error("deskripsi.{$key}")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-danger remove-asset-btn">Hapus</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a href="/distribusi" type="button" class="btn btn-danger me-2" style="width: 120px;">Batal</a>
        <button type="submit" class="btn btn-primary" style="width: 120px;">Tambah</button>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let assetCount = 1;

    // Tambah Form Asset
    document.getElementById("add-asset-btn").addEventListener("click", function () {
        assetCount++;

        const newFormAsset = `
        <div class="col-6 me-2 form-asset" id="form-asset-${assetCount}" style="width: 49%">
            <div class="card shadow mb-3">
                <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-gray">Distribusi ${assetCount -1}</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nik_${assetCount}">NIK</label>
                        <input type="text" name="nik[]" id="nik_${assetCount}" placeholder="Masukkan NIK" class="form-control" required>
                        <div class="nik-status text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="nomor_asset_${assetCount}">Nomor Asset</label>
                        <input type="text" name="nomor_asset[]" id="nomor_asset_${assetCount}" placeholder="Masukkan Nomor Asset" class="form-control" required>
                        <div class="nomor_asset-status text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="file_${assetCount}">Dokumen</label>
                        <input type="file" name="file[]" id="file_${assetCount}" class="form-control"required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_${assetCount}">Tanggal</label>
                        <input type="date" name="tanggal[]" id="tanggal_${assetCount}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="lokasi_${assetCount}">Lokasi</label>
                        <input type="text" name="lokasi[]" id="lokasi_${assetCount}" placeholder="Masukkan Lokasi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_${assetCount}">Deskripsi</label>
                        <textarea name="deskripsi[]" id="deskripsi_${assetCount}" class="form-control" placeholder="Deskripsi" style="height:150px;"></textarea>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-danger remove-asset-btn">Hapus</button>
                </div>
            </div>
        </div>
        `;

        const formContainer = document.getElementById("form-asset-container");
        formContainer.insertAdjacentHTML("beforeend", newFormAsset);

        attachRemoveEventListeners();
    });

    // Hapus Form Asset
    function attachRemoveEventListeners() {
        const removeButtons = document.querySelectorAll(".remove-asset-btn");
        removeButtons.forEach((btn) => {
            btn.addEventListener("click", function () {
                const parent = btn.closest(".form-asset");
                if (parent) {
                    parent.remove();
                }
            });
        });
    }

    attachRemoveEventListeners();
});



$(document).on('keyup blur', 'input[name="nik[]"]', function () {
    let nik = $(this).val();
    let nikStatus = $(this).closest('.form-asset').find('.nik-status');

    if (nik.length === 0) {
        nikStatus.text('NIK harus diisi').removeClass('text-success').addClass('text-danger');
        return;
    }

    $.ajax({
        url: "{{ route('fetch-user-data') }}",
        type: 'GET',
        data: { nik: nik },
        success: function (response) {
            if (response.success) {
                nikStatus.text('NIK tersedia' + ' (Nama: ' + response.nama + ')')
                .removeClass('text-danger').addClass('text-success');
            } else {
                nikStatus.text('NIK belum terdaftar').removeClass('text-success').addClass('text-danger');
            }
        },
        error: function () {
            nikStatus.text('Terjadi kesalahan pada server').removeClass('text-success').addClass('text-danger');
        }
    });
});



$(document).on('keyup blur', 'input[name="nomor_asset[]"]', function () {
    let nomor_asset = $(this).val().trim();
    let assetStatus = $(this).closest('.form-asset').find('.nomor_asset-status');

    let existingNomorAsset = [];
    $('input[name="nomor_asset[]"]').each(function () {
        if ($(this).val().trim() !== '') {
            existingNomorAsset.push($(this).val().trim());
        }
    });

    let duplicateCount = existingNomorAsset.filter(it => it === nomor_asset).length;
    if (duplicateCount > 1) {
        assetStatus.text('Nomor asset sudah digunakan dalam form ini').removeClass('text-success').addClass('text-danger');
        return;
    }

    if (nomor_asset.length === 0) {
        assetStatus.text('Nomor asset harus diisi').removeClass('text-success').addClass('text-danger');
        return;
    }

    $.ajax({
        url: '{{ route('checkNomorAssetDist') }}',
        type: 'POST',
        data: {
            nomor_asset: nomor_asset,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            if (response.status === 'not_registered') {
                assetStatus.text(response.message).removeClass('text-success').addClass('text-danger');
            } else if (response.status === 'distributed') {
                assetStatus.text(response.message + ' (Kondisi: ' + response.kondisi + ')')
                    .removeClass('text-success').addClass('text-danger');
            } else if (response.status === 'available') {
                assetStatus.text(response.message + ' (Kondisi: ' + response.kondisi + ')')
                    .removeClass('text-success').addClass('text-danger');
            }
        },
        error: function () {
            // assetStatus.text('Terjadi kesalahan, coba lagi nanti').removeClass('text-success').addClass('text-danger');
        }
    });
});

</script>