<tbody>
    @forelse ($assets as $key => $item)    
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->nomor_penyerahan }}</td>
            <td>{{ $item->nomor_asset }}</td>
            <td>{{ $item->asset->kategori->nama }}</td>
            <td>{{ $item->asset->subKategori->nama }}</td>
            <td> {{ $item->asset->kondisi == 1 ? 'Baik' : 'Rusak' }} </td>
            <td>
                <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-detail-asset"
                    data-umur="{{ $item->asset->umur ?? '' }}"
                    data-kondisi="{{ $item->asset->kondisi == 1 ? 'Baik' : 'Rusak' }}"
                    data-nomor-penyerahan="{{ $item->nomor_penyerahan ?? '' }}"
                    data-pemilik="{{ $item->employee->nama ?? '' }}"
                    data-kategori="{{ $item->asset->kategori->nama ?? '' }}"
                    data-sub-kategori="{{ $item->asset->subKategori->nama ?? '' }}"
                    data-nomor-pmn="{{$item->asset->no_pmn ?? ''}}">
                    Detail
                </a>
            </td>
            <td>
                @if ($item->asset->kondisi == 1)    
                <a href="{{ route('asset.ajukan.kerusakan', $item->nomor_asset) }}" class="btn btn-warning">
                    Ajukan Kerusakan
                </a>
                @else
                    <p>Kerusakan disetuui</p>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">Tidak ada data aset</td>
        </tr>
    @endforelse
</tbody>
@include('employee.component.modal-detail-asset')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('modal-detail-asset');
        modalElement.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const umur = button.getAttribute('data-umur') || 'N/A';
            const nomor_penyerahan = button.getAttribute('data-nomor-penyerahan') || 'N/A';
            const no_pmn = button.getAttribute('data-nomor-pmn') || 'N/A';
            const pemilik = button.getAttribute('data-pemilik') || 'N/A';
            const kategori = button.getAttribute('data-kategori') || 'N/A';
            const sub_kategori = button.getAttribute('data-sub-kategori') || 'N/A';
            const kondisi = button.getAttribute('data-kondisi') || 'N/A';

            modalElement.querySelector('#detail-kategori').textContent = kategori;
            modalElement.querySelector('#detail-sub-kategori').textContent = sub_kategori;
            modalElement.querySelector('#detail-umur').textContent = umur;
            modalElement.querySelector('#detail-kondisi').textContent = kondisi;
            modalElement.querySelector('#detail-nomor-penyerahan').textContent = nomor_penyerahan;
            modalElement.querySelector('#detail-nomor-pmn').textContent = no_pmn;
            modalElement.querySelector('#detail-pemilik').textContent = pemilik;

        });
    });
</script>