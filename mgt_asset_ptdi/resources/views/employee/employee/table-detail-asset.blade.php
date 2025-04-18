<tbody>
    @forelse ($distribution as $key => $item)    
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->nomor_penyerahan }}</td>
            <td>{{ $item->nomor_asset ?? $item->nomor_it }}</td>
            @if ($item->nomor_it == null)
                <td>Perlengkapan Kantor</td>
                <td>{{ $item->asset->kategori->nama }}</td>
                <td>{{ $item->asset->subKategori->nama }}</td>
                <td>
                    <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-detail-asset"
                        data-umur="{{ $item->asset->umur ?? '' }}"
                        data-kondisi="{{ $item->asset->kondisi == 1 ? 'Baik' : 'Rusak' }}"
                        data-nomor-penyerahan="{{ $item->nomor_penyerahan ?? '' }}"
                        data-nomor-pmn = "{{ $item->asset->no_pmn ?? '' }}"
                        data-pemilik="{{ $item->employee->nama ?? '' }}"
                        data-kategori="{{ $item->asset->kategori->nama ?? '' }}"
                        data-sub-kategori="{{ $item->asset->subKategori->nama ?? '' }}">
                        Detail
                    </a>
                </td>
            @else
                <td>Perangkat Komputer</td>
                <td>{{ $item->device->kategori->nama }}</td>
                <td>{{ $item->device->subKategori->nama }}</td>
                <td>
                    {{-- @dd($item->device->serialType); --}}
                    {{-- <a href="/asset/create">Detail Device</a> --}}
                    <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-detail-device" 
                        data-nomor-it="{{$item->nomor_it}}"
                        data-nomor-pmn="{{$item->device->no_pmn}}"
                        data-kategori="{{$item->device->kategori->nama ?? '-'}}"
                        data-processor="{{$item->device->processorType->nama}}"
                        data-tipe="{{$item->device->subKategori->nama}}"
                        data-umur="{{$item->device->umur}}"
                        data-storage-type="{{$item->device->storageType->nama}}"
                        data-storage-capacity="{{$item->device->storage_capacity}}"
                        data-memory-type="{{$item->device->memoryType->nama}}"
                        data-memory-capacity="{{$item->device->memory_capacity}}"
                        data-vga-type="{{$item->device->vgaType->nama}}"
                        data-vga-capacity="{{$item->device->vga_capacity}}"
                        data-serial_type="{{$item->device->serial_number}}"
                        data-os="{{$item->device->operationSystem->nama}}"
                        data-os-license="{{$item->device->osLicense->nama}}"
                        data-office="{{$item->device->officeType->nama}}"
                        data-office-license="{{$item->device->officeLicense->nama}}"
                        data-aplikasi="{{$item->device->aplikasi_lainnya ?? '-'}}"
                        data-keterangan="{{$item->device->keterangan_tambahan ?? '-'}}"
                        data-kondisi="{{ $item->device->kondisi == 1 ? 'Baik' : 'Rusak' }}">
                        Detail
                    </a>
                </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">Tidak ada data aset</td>
        </tr>
    @endforelse
</tbody>