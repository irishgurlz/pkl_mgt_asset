@forelse($devices as $index => $device)
    <tr>
        <td>{{ $devices->firstItem() + $index }}</td>
        <td>{{ $device->pendanaan->no_pmn }}</td>
        <td>{{ $device->nomor_it }}</td>
        <td>{{ $device->kategori->nama }}</td>
        <td>{{ $device->subKategori->nama }}</td>
        <td>{{ $device->calculated_age !== null ? $device->calculated_age . ' tahun' : '-' }}</td>
        <td>
            <span class="{{ $device->kondisi == '1' ? '' : 'text-danger' }}">
                {{ $device->kondisi == '1' ? 'Baik' : 'Rusak' }}
            </span> <br>
            @if ($device->foto_kondisi)
                <a href="{{ asset($device->foto_kondisi) }}" target="_blank">Lihat kondisi</a>
            @else
                <span>Tidak ada foto</span>
            @endif     
        </td>
        <td>
            <button type="button" 
                    class="btn btn-primary" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modal-detail-device"
                    data-nomor-it="{{ $device->nomor_it }}"
                    data-nomor-pmn="{{ $device->no_pmn }}"
                    data-kategori="{{ $device->kategori->nama }}"
                    data-tipe="{{ $device->subKategori->nama }}"
                    data-umur="{{ $device->umur }}"
                    data-processor="{{ $device->processorType->nama }}"
                    data-storage-type="{{ $device->storageType->nama }}"
                    data-storage-capacity="{{ $device->storage_capacity }}"
                    data-memory-type="{{ $device->memoryType->nama }}"
                    data-memory-capacity="{{ $device->memory_capacity }}"
                    data-vga-type="{{ $device->vgaType->nama }}"
                    data-vga-capacity="{{ $device->vga_capacity }}"
                    data-serial_type="{{ $device->serial_number }}"
                    data-os="{{ $device->operationSystem->nama }}"
                    data-os-license="{{ $device->osLicense->nama }}"
                    data-office="{{ $device->officeType->nama }}"
                    data-office-license="{{ $device->officeLicense->nama }}"
                    data-kondisi="{{ $device->kondisi == 1 ? 'Baik' : 'Rusak' }}"
                    data-aplikasi="{{ $device->aplikasi_lainnya }}"
                    data-keterangan="{{ $device->keterangan_tambahan }}">
                Detail Perangkat
            </button>
        </td>

        <td class="d-flex justify-content-start">
            <div class="me-2">
                <a class="btn btn-warning" href="{{route('device.edit', $device->id)}}">Edit</a>
            </div>
            <form action="{{ route('device.destroy', $device->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat ini?');" style="padding: 0; margin: 0;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit" style="">
                    Delete
                </button>
            </form>
        </td>
        @empty
        <td colspan="9" class="text-center">Tidak ada device</td>
    </tr>
@endforelse