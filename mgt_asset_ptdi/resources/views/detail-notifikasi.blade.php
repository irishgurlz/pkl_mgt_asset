@extends('employee.master')


@section('content')

    <!-- TITLE -->
<div class="container" data-aos="fade-up">
        <div class ="section-title" data-aos="fade-up" >
            <h2>Daftar Pengajuan</h2>
        </div>

        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card-header py-3">

                    <div class="d-flex justify-content-between">                
                        {{-- <form id="searchForm" method="GET">
                            <div class="mb-3 d-flex justify-content-between"">
                                <div class="input-group me-2">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search Employee" value="{{ request('search') }}">
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form> --}}
                    </div>
                </div>
                
                <!-- TABEL -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama Pemilik</th>
                                    <th>Nomor Penyerahan</th>
                                    <th>Nomor</th>
                                    <th>Status</th>
                                    <th>Deskripsi</th>
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                    <th>Foto Kondisi</th>
                                    @include('endpoint device.device.component.modal_detail_device', ['devices' => $distribution])
                                </tr>
                            </thead>
                            {{-- @include('employee.component.table-employee') --}}
                            <tbody>
                                @forelse ($distribution as $key => $item)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$item->nik}}</td>
                                        <td>{{$item->employee->nama}}</td>
                                        <td>{{$item->nomor_penyerahan}}</td>
                                        <td>{{$item->nomor_asset ?? $item->nomor_it}}</td>
                                        {{-- <td>{{ $item->asset->kondisi == 0 ? 'Baik' : 'Rusak' }}</td> --}}
                                        {{-- <td> 
                                            <a href="{{ asset($item->foto) }}" target="_blank">Lihat Foto Kondisi</a>
                                        </td> --}}
                                        <td>
                                            <span id="status-{{ $item->id }}" class="badge rounded-pill 
                                                {{ $item->status_pengajuan == 1 ? 'bg-warning' : 
                                                ($item->status_pengajuan == 2 ? 'bg-success' : 
                                                ($item->status_pengajuan == 3 ? 'bg-danger' : '')) }}">
                                                {{ $item->status_pengajuan == 1 ? 'Menunggu' : 
                                                ($item->status_pengajuan == 2 ? 'Disetujui' : 
                                                ($item->status_pengajuan == 3 ? 'Ditolak' : '')) }}
                                            </span>                                     
                                        </td>
                                        <td>{{$item->deskripsi_pengajuan}}</td>
                                        @if ($item->nomor_asset == null)
                                            <td>
                                                <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-detail-device" 
                                                    data-nomor-it="{{$item->nomor_it}}"
                                                    data-nomor-pmn="{{$item->device->no_pmn}}"
                                                    data-kategori="{{$item->device->kategori->nama ?? '-'}}"
                                                    data-processor="{{$item->device->processorType->nama}}"
                                                    data-tipe="{{$item->device->subKategori->nama}}"
                                                    data-umur="{{$item->device->umur}}"
                                                    data-storage-type="{{$item->device->storageType->nama}}"
                                                    data-storage-capacity="{{$item->device->storage_capacity}}"
                                                    data-memory-type="{{$item->device->memoryType->nama}}"
                                                    data-memory-capacity="{{$item->device->memory_capacity}}"
                                                    data-vga-type="{{$item->device->vgaType->nama}}"
                                                    data-vga-capacity="{{$item->device->vga_capacity}}"
                                                    data-serial_type="{{$item->device->serial_number}}"
                                                    data-os="{{$item->device->operationSystem->nama}}"
                                                    data-os-license="{{$item->device->osLicense->nama}}"
                                                    data-office="{{$item->device->officeType->nama}}"
                                                    data-office-license="{{$item->device->officeLicense->nama}}"
                                                    data-aplikasi="{{$item->device->aplikasi_lainnya ?? '-'}}"
                                                    data-keterangan="{{$item->device->keterangan_tambahan ?? '-'}}"
                                                    data-kondisi="{{ $item->device->kondisi == 1 ? 'Baik' : 'Rusak' }}">
                                                    Detail
                                                </a>
                                            </td>
                                            @else
                                            <td>
                                                <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal-detail-asset"
                                                    data-umur="{{ $item->asset->umur ?? '' }}"
                                                    data-kondisi="{{ $item->asset->kondisi == 1 ? 'Baik' : 'Rusak' }}"
                                                    data-nomor-penyerahan="{{ $item->nomor_penyerahan ?? '' }}"
                                                    data-pemilik="{{ $item->employee->nama ?? '' }}"
                                                    data-kategori="{{ $item->asset->kategori->nama ?? '' }}"
                                                    data-sub-kategori="{{ $item->asset->subKategori->nama ?? '' }}">
                                                    Detail
                                                </a>
                                            </td>
                                            @endif
                                            {{-- <button class="btn btn-info">Detail</button> --}}
                                        {{-- </td> --}}

                                        <td>
                                            <select class="form-control" style="width:100%; height: 80%; font-weight: bold;font-size: 12px" onchange="handleSelectChange(this, {{ $item->id }})">
                                                {{-- <select class="input-form" onchange="handleSelectChange(this, {{ $value->id }})"> --}}
                
                                                <option disabled selected>Ubah Status</option>
                                                <option value="1" style="font-weight: bold; font-size: 12px;">Reset</option>
                                                <option value="2" style="font-weight: bold; font-size: 12px;">Terima</option>
                                                <option value="3" style="font-weight: bold; font-size: 12px;">Tolak</option>
                                            </select>
                                        </td>  
                                        <td>
                                            <div id="upload-{{ $item->id }}" 
                                                data-item-id="{{ $item->id }}" 
                                                data-device-id="{{ $item->device->id ?? '' }}" 
                                                data-asset-id="{{ $item->asset->id ?? '' }}"> 
                                           </div>     
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
        
</div>
<script>
    function handleSelectChange(selectElement) {
        const itemId = selectElement.closest('td').nextElementSibling.querySelector('div').dataset.itemId;
        const deviceId = selectElement.closest('td').nextElementSibling.querySelector('div').dataset.deviceId;
        const assetId = selectElement.closest('td').nextElementSibling.querySelector('div').dataset.assetId;
        const newStatus = selectElement.value;
        
        // Send request to update status
        fetch(`/update-status/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Make sure the CSRF token is sent
            },
            body: JSON.stringify({
                status_pengajuan: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const statusBadge = document.getElementById('status-' + itemId);
                const uploadBadge = document.getElementById('upload-' + itemId);
                
                if (newStatus == 1) {
                    statusBadge.className = 'badge rounded-pill bg-warning';
                    statusBadge.textContent = 'Menunggu';
                } else if (newStatus == 2) {
                    statusBadge.className = 'badge rounded-pill bg-success';
                    statusBadge.textContent = 'Disetujui';
                    
                    // Use deviceId and assetId to generate the correct links
                    if (!assetId) {
                        uploadBadge.innerHTML = '<a href="/edit-foto-device/' + deviceId + '" class="btn btn-success">Upload Foto</a>';
                    } else {
                        uploadBadge.innerHTML = '<a href="/edit-foto-asset/' + assetId + '" class="btn btn-success">Upload Foto</a>';
                    }
                } else if (newStatus == 3) {
                    statusBadge.className = 'badge rounded-pill bg-danger';
                    statusBadge.textContent = 'Ditolak';
                }
            } else {
                alert('Terjadi kesalahan saat memperbarui status.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

@include('employee.component.modal-detail-asset')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('modal-detail-asset');
        modalElement.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const umur = button.getAttribute('data-umur') || 'N/A';
            const nomor_penyerahan = button.getAttribute('data-nomor-penyerahan') || 'N/A';
            const pemilik = button.getAttribute('data-pemilik') || 'N/A';
            const kategori = button.getAttribute('data-kategori') || 'N/A';
            const sub_kategori = button.getAttribute('data-sub-kategori') || 'N/A';
            const kondisi = button.getAttribute('data-kondisi') || 'N/A';

            modalElement.querySelector('#detail-kategori').textContent = kategori;
            modalElement.querySelector('#detail-sub-kategori').textContent = sub_kategori;
            
            modalElement.querySelector('#detail-umur').textContent = umur;
            modalElement.querySelector('#detail-kondisi').textContent = kondisi;

            modalElement.querySelector('#detail-nomor-penyerahan').textContent = nomor_penyerahan;
            modalElement.querySelector('#detail-pemilik').textContent = pemilik;

        });
    });
</script>
@endsection