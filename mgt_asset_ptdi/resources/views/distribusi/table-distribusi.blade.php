<tbody>
    @forelse ($distribution as $key => $item)    
    <tr>
        <td>{{ $distribution->firstItem() + $key }}</td>
        <td>{{$item->nomor_penyerahan}}</td>
        <td>
            <a class="btn btn-info" href="/distribusi/{{$item->id}}/detailAsset">Detail</a>
        </td>
        <td class="d-flex justify-content-start">
            <div class="me-2">
                    <a class="btn btn-warning" href="/distribusi/{{$item->id}}/pilihPengalihan">Pengalihan</a>
                </a>
            </div>
            {{-- @dd($item->id) --}}
            <form action="/distribusi/{{$item->id}}/destroyDist" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?');" style="padding: 0; margin: 0;">
                {{-- @csrf --}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @method('DELETE')
                <button class="btn btn-danger me-2" type="submit">Delete</button>
            </form>
            <a class="btn btn-success" href="/distribution-asset/create/{{$item->id}}">Tambah Asset</a>

        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-center">Tidak ada data aset</td>
    </tr>
    @endforelse
</tbody>