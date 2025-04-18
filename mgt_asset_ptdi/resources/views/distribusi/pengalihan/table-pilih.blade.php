<tbody>
    @forelse ($distribution as $key => $item)
    <tr>
        <td>{{$distribution->firstItem() + $key}}</td>
        <td>{{$item->nomor_penyerahan}}</td>
        <td>{{$item->employee->nama}}</td>
        @if ($item->nomor_it == null)
            <td>Perlengkapan Kantor</td>
        @else
            <td>Perangkat Komputer</td>
        @endif
        
        @if ($item->nomor_it == null)
            <td>{{$item->nomor_asset}}</td>
        @else
            <td>{{$item->nomor_it}}</td>
        @endif

        <td>
            @if ($item->nomor_asset == null)
                <a class="btn btn-warning" href="/distribusi/{{$item->id}}/detail/{{$item->device->id}}/pengalihanDevice">Alihkan</a>
            @else
                <a class="btn btn-warning" href="/distribusi/{{$item->id}}/detail/{{$item->asset->id}}/pengalihanAsset">Alihkan</a>
            @endif
        </td>

    </tr>
        
    @empty
    <tr>
        <td colspan="6" class="text-center">Tidak ada data</td>
    </tr>
    @endforelse
</tbody>