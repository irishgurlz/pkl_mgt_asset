<tbody id="sub_kategori_table">
    @forelse($subKategoris as $index => $subKategori)
        <tr>
            <td>{{ $subKategoris->firstItem() + $index }}</td>
            <td>{{ $subKategori->kategori->nama }}</td>
            <td>{{ $subKategori->nama }}</td>
            <td>
                <div>
                    <a href="{{ route('sub-kategori.edit', $subKategori->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('sub-kategori.destroy', $subKategori->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirmDelete();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Sub kategori tidak ditemukan</td>
        </tr>
    @endforelse
</tbody>