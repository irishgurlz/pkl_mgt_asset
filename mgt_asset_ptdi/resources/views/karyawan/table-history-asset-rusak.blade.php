<tbody>
    @forelse ($history as $key => $item)    
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{$item->distributionDetail->nomor_penyerahan}}</td>
            <td>{{$item->distributionDetail->nomor_asset}}</td>
            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
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

        </tr>
       
    @empty
        <tr>
            <td colspan="7" class="text-center">Tidak ada data history</td>
        </tr>
    @endforelse
</tbody>