<div class="modal fade" id="modal-detail-semua-device" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 80%;">
        <div class="modal-content" style="background-color: #ffffff; border-radius: 15px;">
            <div class="modal-header">
                <h5 class="modal-title">Detail Perangkat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Nomor Asset:</div>
                            <div class="col-7"><span data-modal-nomor-it></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Nomor PMN:</div>
                            <div class="col-7"><span data-modal-nomor-pmn></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Kategori:</div>
                            <div class="col-7"><span data-modal-kategori></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Tipe Kategori:</div>
                            <div class="col-7"><span data-modal-tipe></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Umur:</div>
                            <div class="col-7"><span data-modal-umur></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Processor:</div>
                            <div class="col-7"><span data-modal-processor></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Tipe Storage:</div>
                            <div class="col-7"><span data-modal-storage-type></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Storage Capacity:</div>
                            <div class="col-7"><span data-modal-storage-capacity></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Tipe Memory:</div>
                            <div class="col-7"><span data-modal-memory-type></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Memory Capacity:</div>
                            <div class="col-7"><span data-modal-memory-capacity></span></div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Tipe VGA:</div>
                            <div class="col-7"><span data-modal-vga-type></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">VGA Capacity:</div>
                            <div class="col-7"><span data-modal-vga-capacity></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Serial Number:</div>
                            <div class="col-7"><span data-modal-serial-type></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Operation System:</div>
                            <div class="col-7"><span data-modal-os></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">OS License:</div>
                            <div class="col-7"><span data-modal-os-license></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Office:</div>
                            <div class="col-7"><span data-modal-office></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Office License:</div>
                            <div class="col-7"><span data-modal-office-license></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Kondisi:</div>
                            <div class="col-7"><span data-modal-kondisi></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Aplikasi Lainnya:</div>
                            <div class="col-7"><span data-modal-aplikasi></span></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 fw-bold">Keterangan Tambahan:</div>
                            <div class="col-7"><span data-modal-keterangan></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modal-detail-semua-device");
    const modalInstance = new bootstrap.Modal(modal);
    
    document.querySelectorAll(".btn-info[data-bs-toggle='modal']").forEach(button => {
        button.addEventListener("click", function () {
            const dataAttributes = [
                "nomor-it", "nomor-pmn", "kategori", "tipe", "umur", "processor",
                "storage-type", "storage-capacity", "memory-type", "memory-capacity",
                "vga-type", "vga-capacity", "serial_type", "os", "os-license",
                "office", "office-license", "kondisi", "aplikasi", "keterangan"
            ];
            
            dataAttributes.forEach(attr => {
                const modalElement = modal.querySelector(`[data-modal-${attr}]`);
                if (modalElement) {
                    modalElement.textContent = this.getAttribute(`data-${attr}`) || "-";
                }
            });

            modalInstance.show();
        });
    });
});


</script>