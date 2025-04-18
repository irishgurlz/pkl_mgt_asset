<tbody>
    @forelse ($AllDevices as $key => $item)    
        <tr>
            <td>{{ $AllDevices->firstItem() + $key }}</td>
            <td>{{ $item->nomor_penyerahan }}</td>
            <td>{{ $item->nomor_it }}</td>
            <td>{{ $item->device->kategori->nama }}</td>
            <td>{{ $item->device->subKategori->nama }}</td>
            <td>{{ $item->device->distribution_detail->status_penerimaan }}</td>
            <td>{{ $item->device->kondisi == 1 ? 'Baik' : 'Rusak' }}</td>
            <td>
                <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-detail-semua-device" 
                    data-nomor-it="{{ $item->nomor_it }}"
                    data-nomor-pmn="{{ $item->device->no_pmn }}"
                    data-kategori="{{ $item->device->kategori->nama }}"
                    data-tipe="{{ $item->device->subKategori->nama }}"
                    data-umur="{{ $item->device->umur }}"
                    data-processor="{{ $item->device->processorType->nama }}"
                    data-storage-type="{{ $item->device->storageType->nama }}"
                    data-storage-capacity="{{ $item->device->storage_capacity }}"
                    data-memory-type="{{ $item->device->memoryType->nama }}"
                    data-memory-capacity="{{ $item->device->memory_capacity }}"
                    data-vga-type="{{ $item->device->vgaType->nama }}"
                    data-vga-capacity="{{ $item->device->vga_capacity }}"
                    data-serial_type="{{ $item->device->serial_number }}"
                    data-os="{{ $item->device->operationSystem->nama }}"
                    data-os-license="{{ $item->device->osLicense->nama }}"
                    data-office="{{ $item->device->officeType->nama }}"
                    data-office-license="{{ $item->device->officeLicense->nama }}"
                    data-kondisi="{{ $item->device->kondisi == 1 ? 'Baik' : 'Rusak' }}"
                    data-aplikasi="{{ $item->device->aplikasi_lainnya }}"
                    data-keterangan="{{ $item->device->keterangan_tambahan }}">
                  Detail
              </a>
            </td>
            <td>
                <span id="status-{{ $item->id }}" class="badge rounded-pill {{ $item->status_penerimaan == 0 ? 'bg-warning' : ($item->status_penerimaan == 1 ? 'bg-success' : '') }}">
                    {{ $item->status_penerimaan == 0 ? 'Belum Diterima' : 
                    ($item->status_penerimaan == 1 ? 'Sudah Diterima' : '') }}
                </span>    
            </td>
            <td>
                <select id="select-status-{{ $item->id }}" class="form-control" style="width:100%; height: 80%; font-weight: bold; font-size: 12px" onchange="handleSelectChange(this, {{ $item->id }})">
                    <option disabled selected>Ubah Status</option>
                        <option value="0" style="font-weight: bold; font-size: 12px;">Reset</option>
                        <option value="1" style="font-weight: bold; font-size: 12px;">Terima</option>
                </select>
            </td>
                     
            
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">Tidak ada data device</td>
        </tr>
    @endforelse
</tbody>

<script>
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

            // Update badge status
            if (newStatus === "0") {
                statusBadge.className = 'badge rounded-pill bg-warning';
                statusBadge.textContent = 'Belum Diterima';
            } else {
                statusBadge.className = 'badge rounded-pill bg-success';
                statusBadge.textContent = 'Sudah Diterima';
            }

        } else {
            alert('Gagal memperbarui status.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan.');
    });
}



</script>
