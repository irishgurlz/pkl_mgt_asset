    <div class="notif-tabs d-flex justify-content-center">
        <div id="daftar-device-diterima-tab" class="active" onclick="switchTab('daftar-device-diterima')">Daftar Asset Diterima</div>
        <div id="semua-device-tab" onclick="switchTab('semua-device')">Daftar Distribusi Asset</div>


    </div>

    <div id="daftar-device-diterima" class="tab-content">
        <div class="d-flex justify-content-between">
            <a class="btn bg-primary text-white mb-2" style="width:20%; height:10%;" href="/histroy-device-rusak">
                Lihat History Pengajuan
            </a>

            <form id="searchForm" method="GET">
                <div class="mb-3 d-flex justify-content-between">
                    <div class="input-group me-2">
                        <input type="text" class="form-control" id="search-device" name="search" placeholder="Search Perangkat" value="{{ request('search') }}">
                    </div>
                    <button class="btn bg-primary text-white" type="submit">Search</button>
                </div>
            </form>
        </div>

        <table class="table table-bordered" id="device-table-diterima" width="100%" cellspacing="4" style="overflow-x:auto;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Penyerahan</th>
                    <th>Nomor Asset</th>
                    <th>Kategori</th>
                    <th>Sub Kategori</th>
                    <th>Kondisi</th>
                    <th>Detail</th>
                    <th>Edit Device</th>
                    <th>Aksi</th>
                    <div id="modal-daftar-device-diterima">
                        @include('endpoint device.device.component.modal_detail_device', ['devices' => $devices])
                    </div>
                </tr>
            </thead>
            @include('karyawan.partial-table-device')
        </table>
        @include('paginate', ['paginator' => $devices])
    </div>

    <div id="semua-device" class="tab-content">
        <div class="d-flex justify-content-end">
            <form id="searchForm" method="GET">
                <div class="mb-3 d-flex justify-content-between">
                    <div class="input-group me-2">
                        <input type="text" class="form-control" id="search-all-device" name="search" placeholder="Search Perangkat" value="{{ request('search') }}">
                    </div>
                    <button class="btn bg-primary text-white" type="submit">Search</button>
                </div>
            </form>
        </div>

        <table class="table table-bordered" id="device-table-semua" width="100%" cellspacing="4" style="overflow-x:auto;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Penyerahan</th>
                    <th>Nomor Asset</th>
                    <th>Kategori</th>
                    <th>Sub Kategori</th>
                    <th>Status</th>
                    <th>Kondisi</th>
                    <th>Detail</th>
                    <th>Status Penerimaan</th>
                    <th>Ubah Status</th>
                    <div id="modal-semua-device">
                        @include('employee.component.modal-detail-device')
                    </div>
                </tr>
            </thead>
            @include('karyawan.partial-table-semua-device')
        </table>
        @include('paginate', ['paginator' => $AllDevices])
    </div>



    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInputDevice = document.getElementById('search-device');

        searchInputDevice.addEventListener('keyup', function () {
            let searchQuery = searchInputDevice.value;
            console.log("Device Search Triggered:", searchQuery);

            fetch("{{ route('karyawan.dashboard') }}?search=" + encodeURIComponent(searchQuery) + "&type=device", {
                method: 'GET',
                headers: {
                    'Accept': 'text/html',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(data => {
                console.log("Device AJAX Response:", data);

                const tableBodyDevice = document.querySelector('#device-table-diterima tbody');
                const newTableBodyDevice = data.match(/<tbody[^>]*>([\s\S]*?)<\/tbody>/);

                if (newTableBodyDevice) {
                    tableBodyDevice.innerHTML = newTableBodyDevice[1]; 
                } else {
                    console.warn("No valid <tbody> found in response");
                }
            })
            .catch(error => console.error("Error fetching device data:", error));
        });

        const searchInputAllDevices = document.getElementById('search-all-device');

        searchInputAllDevices.addEventListener('keyup', function () {
            let searchQuery = searchInputAllDevices.value;
            console.log("Search Semua Asset Triggered:", searchQuery);

            fetch("{{ route('karyawan.dashboard') }}?search=" + encodeURIComponent(searchQuery) + "&type=all_devices", {
                method: 'GET',
                headers: {
                    'Accept': 'text/html',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(data => {
                console.log("AJAX Response Semua Asset:", data);

                const tableBodyAllDevices = document.querySelector('#device-table-semua tbody');
                const newTableBodyAllDevices = data.match(/<tbody[^>]*>([\s\S]*?)<\/tbody>/);

                if (newTableBodyAllDevices) {
                    tableBodyAllDevices.innerHTML = newTableBodyAllDevices[1]; 
                } else {
                    console.warn("No valid <tbody> found in response for Semua Asset");
                }
            })
            .catch(error => console.error("Error fetching semua device data:", error));
        });
    });

    function switchTab(tabId) {
        $('.tab-content').hide(); 
        $('#' + tabId).show(); 
        $('.notif-tabs div').removeClass('active');
        $('#' + tabId + '-tab').addClass('active'); 
        localStorage.setItem('lastTab', tabId);
    }

    function loadLastTab() {
        const lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            switchTab(lastTab);
        } else {
            switchTab('daftar-device-diterima');
        }
    }

    $(document).ready(function() {
        loadLastTab();
    });

    document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('modal-detail-device');
});






    </script>
