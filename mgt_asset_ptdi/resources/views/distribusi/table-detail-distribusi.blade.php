<tbody>
    @forelse ($distribution as $key => $item)
    <tr>
        {{-- @dd( $item->asset->umur ) --}}
        <td>{{$key + 1}}</td>
        {{-- <td>{{$item->created_at}}</td> --}}
        <td>{{$item->nomor_penyerahan}}</td>
        <td>{{$item->employee->nama}}</td>

        @if ($item->nomor_it == null)
            <td>Perlengkapan Kantor</td>
            <td>{{$item->nomor_asset}}</td>
            <td>
                <a href="{{ asset($item->file) }}" target="_blank">Lihat Dokumen Pengajuan</a>
            </td>
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
            <td>
                <form action="{{ url('/distribusi/'.$item->id.'/asset/'.$item->asset->id.'/destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?');" style="padding: 0; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit" style="">
                        Delete
                    </button>
                </form>
            </td>
        @else
            <td>Perangkat Komputer</td>
            <td>{{$item->nomor_it}}</td>
            <td>
                <a href="{{ asset($item->file) }}" target="_blank">Lihat Dokumen Pengajuan</a>
            </td>
            <td>
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
            <td>
                <form action="{{ url('/distribusi/'.$item->id.'/asset/'.$item->device->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?');" style="padding: 0; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit" style="">
                        Delete
                    </button>
                </form>
            </td>
            
        @endif
    </tr>
        
    @empty
    <td colspan="8" class="text-center">Tidak ada data aset</td>
        
    @endforelse
</tbody>