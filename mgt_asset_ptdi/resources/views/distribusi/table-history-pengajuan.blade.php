<tbody>
    @forelse ($history as $key => $item)
        <tr>
            <td>{{ $history->firstItem() + $key }}</td>
            <td>{{$item->distributionDetail->nik}}</td>
            <td>{{$item->distributionDetail->employee->nama}}</td>
            <td>{{$item->distributionDetail->nomor_penyerahan}}</td>
            <td>{{$item->distributionDetail->nomor_asset ?? $item->distributionDetail->nomor_it}}</td>
            <td>Pengajuan ke-{{$item->status + 1 }}</td>
            <td>
                <span id="status-{{ $item->id }}" class="badge rounded-pill 
                    {{ $item->status_pengajuan == 1 ? 'bg-warning' : 
                    ($item->status_pengajuan == 2 ? 'bg-success' : 
                    ($item->status_pengajuan == 3 ? 'bg-danger' : '')) }}">
                    {{ $item->status_pengajuan == 1 ? 'Menunggu' : 
                    ($item->status_pengajuan == 2 ? 'Disetujui' : 
                    ($item->status_pengajuan == 3 ? 'Ditolak' : '')) }}
                </span>                                            
            </td>
            <td>
                <a href="{{ asset($item->distributionDetail->device->foto_kondisi ?? $item->distributionDetail->asset->foto) }}" target="_blank">Lihat kondisi</a>   
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">Tidak ada data.</td>
        </tr>
    @endforelse
</tbody>
