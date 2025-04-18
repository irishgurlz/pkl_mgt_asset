<tbody>
    @forelse ($devices as $key => $item)    
        <tr>
            <td>{{ $devices->firstItem() + $key }}</td>
            <td>{{ $item->nomor_penyerahan }}</td>
            <td>{{ $item->nomor_it }}</td>
            <td>{{ $item->device->kategori->nama }}</td>
            <td>{{ $item->device->subKategori->nama }}</td>
            <td>{{ $item->device->kondisi == 1 ? 'Baik' : 'Rusak' }}</td>
            <td>
              <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-detail-device" 
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
            <a href="{{ route('karyawan-edit-device', $item->nomor_it) }}" class="btn btn-warning">Edit</a>
            </td>
            <td>
                @if ($item->device->kondisi == 1)    
                    <a href="{{ route('device.ajukan.kerusakan', $item->nomor_it) }}" class="btn btn-warning">
                        Ajukan Kerusakan
                    </a>
                @else
                    <p>Kerusakan disetujui</p>
                @endif
                <!-- <button class="btn btn-warning">Edit</button> -->
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">Tidak ada data device</td>
        </tr>
    @endforelse
</tbody>
