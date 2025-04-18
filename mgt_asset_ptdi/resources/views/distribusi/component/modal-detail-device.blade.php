<!-- Modal -->
<div class="modal fade" id="modal-detail-device" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin-left:35%; width:100%">
        <div class="modal-content" style="background-color: #ffffff; border-radius: 15px; width: 60%;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Nomor Asset:</div>
                        <div class="col-7" id="modal-nomor-it"></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Nomor PMN:</div>
                        <div class="col-7" id="modal-nomor-pmn"></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Kategori:</div>
                        <div class="col-7" id="modal-kategori"></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Tipe Kategori:</div>
                        <div class="col-7" id="modal-tipe"></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Umur:</div>
                        <div class="col-7" id="modal-umur"></div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Processor:</div>
                        <div class="col-7" id="modal-processor"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Tipe Storage:</div>
                        <div class="col-7" id="modal-storage-type"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Storage Capacity:</div>
                        <div class="col-7" id="modal-storage-capacity"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Tipe Memory:</div>
                        <div class="col-7" id="modal-memory-type"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Memory Capacity:</div>
                        <div class="col-7" id="modal-memory-capacity"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Tipe VGA:</div>
                        <div class="col-7" id="modal-vga-type"></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 fw-bold">VGA Capacity:</div>
                        <div class="col-7" id="modal-vga-capacity"></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Serial Number:</div>
                        <div class="col-7" id="modal-serial-type"></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Operation System:</div>
                        <div class="col-7" id="modal-os"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">OS License:</div>
                        <div class="col-7" id="modal-os-license"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Office:</div>
                        <div class="col-7" id="modal-office"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Office License:</div>
                        <div class="col-7" id="modal-office-license"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Aplikasi Lainnya:</div>
                        <div class="col-7" id="modal-aplikasi"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Keterangan Tambahan:</div>
                        <div class="col-7" id="modal-keterangan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var myModal = document.getElementById('modal-detail-device');
    myModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; 
        document.getElementById('modal-nomor-it').textContent = button.getAttribute('data-nomor-it');
        document.getElementById('modal-nomor-pmn').textContent = button.getAttribute('data-nomor-pmn');
        document.getElementById('modal-kategori').textContent = button.getAttribute('data-kategori');
        document.getElementById('modal-tipe').textContent = button.getAttribute('data-tipe');

        var umurDate = button.getAttribute('data-umur'); 
        if (umurDate) {
            var today = new Date();
            var umur = new Date(umurDate);

            var years = today.getFullYear() - umur.getFullYear();
            var months = today.getMonth() - umur.getMonth();
            var days = today.getDate() - umur.getDate();

            if (months < 0 || (months === 0 && days < 0)) {
                years--;
            }

            document.getElementById('modal-umur').textContent = `${years} tahun`;
        } else {
            document.getElementById('modal-umur').textContent = '-';
        }

        document.getElementById('modal-processor').textContent = button.getAttribute('data-processor');
        document.getElementById('modal-storage-type').textContent = button.getAttribute('data-storage-type');
        document.getElementById('modal-storage-capacity').textContent = button.getAttribute('data-storage-capacity') + " GB";
        document.getElementById('modal-memory-type').textContent = button.getAttribute('data-memory-type');
        document.getElementById('modal-memory-capacity').textContent = button.getAttribute('data-memory-capacity') + " GB";
        document.getElementById('modal-vga-type').textContent = button.getAttribute('data-vga-type');
        document.getElementById('modal-vga-capacity').textContent = button.getAttribute('data-vga-capacity');
        document.getElementById('modal-serial-type').textContent = button.getAttribute('data-serial_type');
        document.getElementById('modal-os').textContent = button.getAttribute('data-os');
        document.getElementById('modal-os-license').textContent = button.getAttribute('data-os-license');
        document.getElementById('modal-office').textContent = button.getAttribute('data-office');
        document.getElementById('modal-office-license').textContent = button.getAttribute('data-office-license');
        document.getElementById('modal-aplikasi').textContent = button.getAttribute('data-aplikasi');
        document.getElementById('modal-keterangan').textContent = button.getAttribute('data-keterangan');
    });

    
</script>


