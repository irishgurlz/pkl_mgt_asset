@php
    $disabledIds = [2, 5, 6, 7, 8, 9, 10];
@endphp

@forelse($kategoris as $index => $kategori) 
    <tr>
        <td>{{ $kategoris->firstItem() + $index }}</td>
        <td>{{ $kategori->nama }}</td> 
        <td>
            <div>
                <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirmDelete();">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                        {{ in_array($kategori->id, $disabledIds) ? 'disabled' : '' }}>
                        Delete
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
<tr>
    <td colspan="6" class="text-center">Kategori tidak ditemukan</td>
</tr>
@endforelse