<form action="/distribusi" method="POST">
    @csrf
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="form-group mb-3">
            <label for="nomor_penyerahan" class="form-label">Nomor Penyerahan</label>
            <input type="text" name="nomor_penyerahan" id="nomor_penyerahan" placeholder="Masukkan Nomor Penyerahan" class="form-control" required>
            <div id="no_penyerahan-status" class="text-danger"></div> 
            @error('nomor_penyerahan')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Tombol Submit -->
    <div class="input-pengguna-button">
        <div class="d-flex justify-content-end mt-4">
            <button type="button" class="btn btn-danger me-2" style="width: 120px;">Batal</button>
            <button type="submit" class="btn btn-primary" style="width: 120px;">Tambah</button>
        </div>
    </div>
</form>

<!-- Input Hidden -->
<input type="hidden" name="nomor_penyerahan_hidden" id="nomor_penyerahan_hidden_form2" value="">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).on('keyup blur', '#nomor_penyerahan', function () {
    let nomor_penyerahan = $(this).val();
    let statusElement = $('#no_penyerahan-status');

    if (nomor_penyerahan.length === 0) {
        statusElement.text('Nomor Penyerahan harus diisi').removeClass('text-success').addClass('text-danger');
        return;
    }

    $.ajax({
        url: "{{ route('fetchNoPenyerahan') }}",
        type: 'GET',
        data: { nomor_penyerahan: nomor_penyerahan },
        success: function (response) {
            if (response.success) {
                statusElement.text('Nomor Penyerahan sudah tersedia').removeClass('text-success').addClass('text-danger');
            } else {
                statusElement.text('Nomor Penyerahan belum terdaftar').removeClass('text-danger').addClass('text-success');
            }
        },
        error: function () {
            statusElement.text('Terjadi kesalahan pada server').removeClass('text-success').addClass('text-danger');
        }
    });
});


// Validasi Nomor Asset
$('#nomor_asset').on('input', function () {
    let nomor_asset = $(this).val();

    if (nomor_asset) {
        $.ajax({
            url: '{{ route('checkNomorAsset') }}',
            type: 'POST',
            data: {
                nomor_asset: nomor_asset,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.status === 'available') {
                    $('#nomor-asset-status').text('Nomor asset tersedia').removeClass('text-danger').addClass('text-success');
                    // $('#submit-btn').prop('disabled', false);
                } else if (response.status === 'taken') {
                    $('#nomor-asset-status').text('Nomor asset sudah terdaftar').removeClass('text-success').addClass('text-danger');
                    // $('#submit-btn').prop('disabled', true);
                }
            },
            error: function () {
                // $('#nomor-asset-status').text('Terjadi kesalahan, coba lagi nanti').removeClass('text-success').addClass('text-danger');
                // $('#submit-btn').prop('disabled', true);
            }
        });
    } else {
        $('#nomor-asset-status').text('');
        $('#submit-btn').prop('disabled', false);
    }
});


</script>


