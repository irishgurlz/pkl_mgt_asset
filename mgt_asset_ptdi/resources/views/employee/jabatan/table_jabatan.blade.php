<div class="table-responsive" id="tableData">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col" style="width: 75%;">Jabatan</th>
                <th scope="col" style="width: 20%;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($jabatan as $key => $item)    
            <tr>
                <td>{{ $jabatan->firstItem() + $key }}</td>
                <td>{{$item->nama}}</td>

                <td class="d-flex justify-content-center">
                    <div class="me-2">
                        <a class="btn btn-warning" href="/jabatan/{{$item->id}}/edit">Edit</a>
                    </div>

                    <form action="/jabatan/{{$item->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this jabatan?');" style="padding: 0; margin: 0;">
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
                <td colspan="3" class="text-center">Tidak ada data jabatan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
