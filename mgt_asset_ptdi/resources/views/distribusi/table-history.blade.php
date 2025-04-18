<tbody>
    @forelse ($history as $key => $item)    
    <tr>
        <td>{{$key + 1}}</td>
        <td>{{$item->nomor_penyerahan }}</td>
        {{-- <td>{{$item->nomor_it ?? '-'}}</td> --}}
        <td>{{$item->nomor_asset ?? $item->nomor_it }}</td>
        <td>{{$item->distribution_detail->employee->nama}}</td>
        <td>{{$item->distribution_detail->lokasi}}</td>
        <td>
            {{-- <a href="/asset/create">Detail Device</a> --}}
            @if ($item->nomor_it == null)    
                <a class="btn btn-info"  href="/historyAsset/{{$item->distribution_detail->id}}/{{$item->asset->id}}">
                    Detail History
                </a>
            @else
                <a class="btn btn-info"  href="/historyDevice/{{$item->distribution_detail->id}}/{{$item->device->id}}">
                    Detail History
                </a>
            @endif

        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-center">Tidak ada data history</td>
    </tr>
    @endforelse
</tbody>