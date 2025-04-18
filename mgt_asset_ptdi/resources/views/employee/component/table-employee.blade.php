
<tbody>
            
    @forelse ($actor as $key => $item)
        <tr>
            <td>{{ $actors->firstItem() + $loop->index }}</td>
            <td>{{ $item['nik'] }}</td>
            <td>{{ $item['nama'] }}</td>
            <td>{{ $item['org'] }}</td>
            <td>{{ $item['jabatan'] }}</td>
            <td>{{ $item['roles'] }}</td>
            <td>
                <a class="btn btn-info" href="/employee/{{ $item['nik'] }}/asset">Detail</a>
            </td>
            <td class="d-flex justify-content-start">
                <div class="me-2">
                    <a class="btn btn-warning" href="/employee/{{ $item['nik'] }}/edit">Edit</a>
                </div>

                <form action="/employee/{{ $item['nik'] }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger me-2" type="submit">Hapus</button>
                </form>
            </td>
            <td>
                @if (str_contains($item['roles'], 'admin') && $admin > 1)
                    <form action="{{ route('delete-role', $item['nik']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');" style="padding: 0; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus Dari Admin</button>
                    </form>
                @elseif (str_contains($item['roles'], 'karyawan') && !str_contains($item['roles'], 'admin'))
                    <form action="{{ route('update-role', $item['nik']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Jadikan Admin</button>
                    </form>
                @else
                    -
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">Tidak ada data.</td>
        </tr>
    @endforelse
</tbody>
