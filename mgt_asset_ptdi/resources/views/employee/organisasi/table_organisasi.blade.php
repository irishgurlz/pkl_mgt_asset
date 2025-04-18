<tbody>
    @forelse ($org as $key => $item)
        <tr>
            <td> {{ $org->firstItem() + $key }} </td>
            <td>{{ $item->kode_org }}</td>
            <td>{{ $item->nama }}</td>
            <td class="d-flex justify-content-start">
                <div class="me-2">
                    <a class="btn btn-warning" href="/organisasi/{{$item->id}}/edit">Edit</a>
                </div>

                <form action="/organisasi/{{$item->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this organisasi?');" style="padding: 0; margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">Tidak ada data organisasi</td>
        </tr>
    @endforelse
</tbody>
