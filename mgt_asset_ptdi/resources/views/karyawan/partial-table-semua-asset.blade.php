<tbody>
    @forelse ($AllAssets as $key => $item)    
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->nomor_penyerahan }}</td>
            <td>{{ $item->nomor_asset }}</td>
            <td>{{ $item->asset->kategori->nama }}</td>
            <td>{{ $item->asset->subKategori->nama }}</td>
            <td> {{ $item->asset->kondisi == 1 ? 'Baik' : 'Rusak' }} </td>
            <td>
                <span id="status-{{ $item->id }}" class="badge rounded-pill 
                    {{ $item->status_penerimaan == 0 ? 'bg-warning' : 
                    ($item->status_penerimaan == 1 ? 'bg-success' : '') }}">
                    {{ $item->status_penerimaan == 0 ? 'Belum Diterima' : 
                    ($item->status_penerimaan == 1 ? 'Sudah Diterima' : '') }}
                </span>                                     
            </td>
            <td>
                <select class="form-control" style="width:100%; height: 80%; font-weight: bold;font-size: 12px" onchange="handleSelectChange(this, {{ $item->id }})">
                    <option disabled selected>Ubah Status</option>
                    <option value="0" style="font-weight: bold; font-size: 12px;">Reset</option>
                    <option value="1" style="font-weight: bold; font-size: 12px;">Terima</option>
                </select>
            </td>  
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">Tidak ada data aset</td>
        </tr>
    @endforelse
</tbody>
@include('employee.component.modal-detail-asset')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('modal-detail-asset');
        modalElement.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const umur = button.getAttribute('data-umur') || 'N/A';
            const nomor_penyerahan = button.getAttribute('data-nomor-penyerahan') || 'N/A';
            const no_pmn = button.getAttribute('data-nomor-pmn') || 'N/A';
            const pemilik = button.getAttribute('data-pemilik') || 'N/A';
            const kategori = button.getAttribute('data-kategori') || 'N/A';
            const sub_kategori = button.getAttribute('data-sub-kategori') || 'N/A';
            const kondisi = button.getAttribute('data-kondisi') || 'N/A';

            modalElement.querySelector('#detail-kategori').textContent = kategori;
            modalElement.querySelector('#detail-sub-kategori').textContent = sub_kategori;
            modalElement.querySelector('#detail-umur').textContent = umur;
            modalElement.querySelector('#detail-kondisi').textContent = kondisi;
            modalElement.querySelector('#detail-nomor-penyerahan').textContent = nomor_penyerahan;
            modalElement.querySelector('#detail-nomor-pmn').textContent = no_pmn;
            modalElement.querySelector('#detail-pemilik').textContent = pemilik;

        });
    });


    function handleSelectChange(selectElement, itemId) {
        const newStatus = selectElement.value;

        fetch(`/update-status/${itemId}/terima`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status_penerimaan: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const statusBadge = document.getElementById('status-' + itemId);

                if (newStatus == "0") {
                    statusBadge.className = 'badge rounded-pill bg-warning';
                    statusBadge.textContent = 'Belum Diterima';
                } else if (newStatus == "1") {
                    statusBadge.className = 'badge rounded-pill bg-success';
                    statusBadge.textContent = 'Sudah Diterima';
                }
            } else {
                alert('Terjadi kesalahan saat memperbarui status.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

</script>