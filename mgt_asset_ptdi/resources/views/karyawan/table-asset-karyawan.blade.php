<div class="notif-tabs d-flex justify-content-center">
    <div id="daftar-asset-diterima-tab" class="active" onclick="switchTab('daftar-asset-diterima')">Daftar Asset Diterima</div>
    <div id="semua-asset-tab" onclick="switchTab('semua-asset')">Daftar Distribusi Asset</div>
</div>
<div id="daftar-asset-diterima" class="tab-content">
    <div class="d-flex justify-content-between">

        <a class="btn bg-primary text-white mb-2" style="width:20%;height:10%" href="/histroy-asset-rusak">
            Lihat History Pengajuan
        </a>

            
        <form id="searchForm" method="GET" action="{{ route('karyawan.dashboard') }}">
            <div class="mb-3 d-flex justify-content-between">
                <div class="input-group me-2">
                    <input type="text" class="form-control" id="search-asset" name="search" placeholder="Search Perlengkapan" value="{{ request('search') }}">
                </div>
                <button class="btn bg-primary text-white" type="submit">Search</button>
            </div>
        </form>
    </div>

    <table class="table table-bordered" id="asset-table" width="100%" cellspacing="4" style="overflow-x:auto">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Penyerahan</th>
                <th>Nomor Asset</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Kondisi</th>
                <th>Detail</th>
                <th>Aksi</th>
            </tr>
        </thead>
        @include('karyawan.partial-table-asset')
    </table>
    @include('employee.component.modal-detail-asset')
    @include('paginate', ['paginator' => $assets])
</div>


<div id="semua-asset" class="tab-content">
    <div class="d-flex justify-content-end">

        <form id="searchForm" method="GET" action="{{ route('karyawan.dashboard') }}">
            <div class="mb-3 d-flex justify-content-between">
                <div class="input-group me-2">
                    <input type="text" class="form-control" id="search-all-assets" name="search" placeholder="Search Perlengkapan" value="{{ request('search') }}">
                </div>
                <button class="btn bg-primary text-white" type="submit">Search</button>
            </div>
        </form>
    </div>
    <table class="table table-bordered" id="semua-asset" width="100%" cellspacing="4" style="overflow-x:auto">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Penyerahan</th>
                <th>Nomor Asset</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Kondisi</th>
                <th>Status Penerimaan</th>
                <th>Ubah status</th>
            </tr>
        </thead>
        @include('karyawan.partial-table-semua-asset')
    </table>
    @include('employee.component.modal-detail-asset')
    @include('paginate', ['paginator' => $AllAssets])
</div>

{{-- @include('employee.component.modal-detail-device') --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('template/assets/js/main.js') }}"></script>

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

    document.addEventListener('DOMContentLoaded', function () {
    const searchInputAsset = document.getElementById('search-asset');

    searchInputAsset.addEventListener('keyup', function () {
        let searchQuery = searchInputAsset.value;
        console.log("Asset Search Triggered:", searchQuery);

        fetch("{{ route('karyawan.dashboard') }}?search=" + encodeURIComponent(searchQuery) + "&type=asset", {
            method: 'GET',
            headers: {
                'Accept': 'text/html',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            console.log("Asset AJAX Response:", data);

            const tableBodyAsset = document.querySelector('#asset-table tbody');
            const newTableBodyAsset = data.match(/<tbody[^>]*>([\s\S]*?)<\/tbody>/);

            if (newTableBodyAsset) {
                tableBodyAsset.innerHTML = newTableBodyAsset[1]; 
            } else {
                console.warn("No valid <tbody> found in response");
            }
        })
        .catch(error => console.error("Error fetching asset data:", error));
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const searchInputAllAssets = document.getElementById('search-all-assets');

    searchInputAllAssets.addEventListener('keyup', function () {
        let searchQuery = searchInputAllAssets.value;
        console.log("Search Semua Asset Triggered:", searchQuery);

        fetch("{{ route('karyawan.dashboard') }}?search=" + encodeURIComponent(searchQuery) + "&type=all_assets", {
            method: 'GET',
            headers: {
                'Accept': 'text/html',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            console.log("AJAX Response Semua Asset:", data);

            const tableBodyAllAssets = document.querySelector('#semua-asset table tbody');
            const newTableBodyAllAssets = data.match(/<tbody[^>]*>([\s\S]*?)<\/tbody>/);

            if (newTableBodyAllAssets) {
                tableBodyAllAssets.innerHTML = newTableBodyAllAssets[1]; 
            } else {
                console.warn("No valid <tbody> found in response for Semua Asset");
            }
        })
        .catch(error => console.error("Error fetching semua asset data:", error));
    });
});



function switchTab(tabId) {
        $('.tab-content').hide(); 
        $('#' + tabId).show(); 
        $('#' + tabId + '-button').show(); 
        $('.notif-tabs div').removeClass('active');
        $('#' + tabId + '-tab').addClass('active'); 
        localStorage.setItem('lastTab', tabId);
    }
    function loadLastTab() {
        const lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            switchTab(lastTab);
        } else {
            switchTab('default-tab-id');
        }
    }

    $(document).ready(function() {
        loadLastTab();
    });

</script>




