<tbody>
    @forelse($pendanaan as $index => $pmn)
        <tr>
            <td>{{ $pendanaan->firstItem() + $index }}</td>
            <td>{{ $pmn->no_pmn }}</td>
            <td>{{ $pmn->deskripsi }}</td>
            <td>{{ $pmn->tanggal }}</td>
            <td>
                <a href="{{ asset($pmn->file_attach) }}" target="_blank">Lihat dokumen pendanaan</a>
            </td>
            <td>
            <div>
                <a href="{{route('pendanaan.edit', $pmn->id)}}" class="btn btn-warning">Edit</a>
                <form action="{{route('pendanaan.destroy', $pmn->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirmDelete();">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
            </td>
            @empty
            <td colspan="8" class="text-center">Tidak ada data pendanaan</td>
        </tr>
    @endforelse
</tbody>