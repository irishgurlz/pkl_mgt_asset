@forelse($asset as $index => $ass)
    <tr>
        <td>{{ $index  + 1}}</td>
        <td>{{ $ass->pendanaan->no_pmn }}</td>
        <td>{{ $ass->nomor_asset }}</td>
        <td>{{ $ass->kategori->nama }}</td>
        <td>{{ $ass->subKategori->nama }}</td>
        <td>{{ $ass->calculated_age !== null ? $ass->calculated_age . ' tahun' : '-' }}</td>
        <td>
            <span class="{{ $ass->kondisi == '1' ? '' : 'text-danger' }}">
                {{ $ass->kondisi == '1' ? 'Baik' : 'Rusak' }}
            </span>
        </td>
        <td>
            @if ($ass->foto)
                    <a href="{{ asset($ass->foto) }}" target="_blank">Lihat kondisi</a>
                @else
                    <span>Tidak ada foto</span>
                @endif
        </td>
        <td class="d-flex justify-content-start">
            <div class="me-2">
                <a class="btn btn-warning" href="{{route('asset.edit', $ass->id)}}">Edit</a>
            </div>
            <form action="{{route('asset.destroy', $ass->id)}}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus asset ini?');" style="padding: 0; margin: 0;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit" style="">
                    Delete
                </button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="text-center">Tidak ada perlengkapan kantor</td>
    </tr>
@endforelse

