@extends('employee.master')

@section('content')

<div class="container section-title" data-aos="fade-up">
    <h2>Daftar Asset {{$employee->nama}}</h2>
</div>

<div class="container">
    <div class="row g-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-end">
                    <form id="searchForm" method="GET">
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="input-group me-2">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search Asset" value="{{ request('search') }}">
                            </div>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            <input type="hidden" name="id" id="id" value="{{ $employee->id }}">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="data-table" width="100%" cellspacing="4" style="overflow-x:auto">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Penyerahan</th>
                                <th>Nomor Asset</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th>Sub Kategori</th>
                                <th>Detail</th>
                                @include('endpoint device.device.component.modal_detail_device', ['devices' => $distribution])
                            </tr>
                        </thead>
                        @include('employee.employee.table-detail-asset')
                    </table>
                    @include('paginate', ['paginator' => $distribution])
                </div>
            </div>
        </div>
    </div>
</div>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalDevice = document.getElementById('modal-detail-device');

        modalDevice.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const nomorIT = button.getAttribute('data-nomor-it') || 'N/A';
            const nomorPMN = button.getAttribute('data-nomor-pmn') || 'N/A';
            const kategori = button.getAttribute('data-kategori') || 'N/A';
            const processor = button.getAttribute('data-processor') || 'N/A';
            const tipe = button.getAttribute('data-tipe') || 'N/A';
            const umur = button.getAttribute('data-umur') || 'N/A';
            const storageType = button.getAttribute('data-storage-type') || 'N/A';
            const storageCapacity = button.getAttribute('data-storage-capacity') || 'N/A';
            const memoryType = button.getAttribute('data-memory-type') || 'N/A';
            const memoryCapacity = button.getAttribute('data-memory-capacity') || 'N/A';
            const vgaType = button.getAttribute('data-vga-type') || 'N/A';
            const vgaCapacity = button.getAttribute('data-vga-capacity') || 'N/A';
            const serialType = button.getAttribute('data-serial_type') || 'N/A';
            const os = button.getAttribute('data-os') || 'N/A';
            const osLicense = button.getAttribute('data-os-license') || 'N/A';
            const office = button.getAttribute('data-office') || 'N/A';
            const officeLicense = button.getAttribute('data-office-license') || 'N/A';
            const aplikasi = button.getAttribute('data-aplikasi') || 'N/A';
            const keterangan = button.getAttribute('data-keterangan') || 'N/A';

            modalDevice.querySelector('#modal-nomor-it').textContent = nomorIT;
            modalDevice.querySelector('#modal-kategori').textContent = kategori;
            modalDevice.querySelector('#modal-processor').textContent = processor;
            modalDevice.querySelector('#modal-storage-type').textContent = storageType;
            modalDevice.querySelector('#modal-storage-capacity').textContent = storageCapacity + ' GB';
            modalDevice.querySelector('#modal-memory-type').textContent = memoryType;
            modalDevice.querySelector('#modal-memory-capacity').textContent = memoryCapacity + ' GB';
            modalDevice.querySelector('#modal-vga-type').textContent = vgaType;
            modalDevice.querySelector('#modal-os').textContent = os;
            modalDevice.querySelector('#modal-os-license').textContent = osLicense;
            modalDevice.querySelector('#modal-office').textContent = office;
            modalDevice.querySelector('#modal-office-license').textContent = officeLicense;
            modalDevice.querySelector('#modal-aplikasi').textContent = aplikasi;
            modalDevice.querySelector('#modal-keterangan').textContent = keterangan;
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const tableBody = document.querySelector('tbody');
    const distId = "{{ $employee->nik }}"; 

    searchInput.addEventListener('keyup', function(event) {
        let searchQuery = searchInput.value;

        fetch(`/employee/${distId}/asset?search=${searchQuery}`, {
            method: 'GET',
            headers: {
                'Accept': 'text/html',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            tableBody.innerHTML = data;
        });
    });
});
</script>


@endsection


