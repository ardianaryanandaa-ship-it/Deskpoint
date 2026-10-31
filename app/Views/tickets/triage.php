<!-- begin::Modal - Triage Ticket -->
<div class="modal fade" id="kt_modal_triage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <!-- Form Triage -->
            <form class="form" action="<?= site_url('tickets/triage/' . $ticket['id']) ?>" id="kt_modal_triage_form" method="POST">
                <?= csrf_field() ?>
                
                <div class="modal-header" id="kt_modal_triage_header">
                    <h2 class="fw-bolder">Triage & Klasifikasi Tiket #<?= $ticket['id'] ?></h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="bi bi-x fs-1"></i>
                    </div>
                </div>

                <div class="modal-body py-10 px-lg-17">
                    <!-- Alert Info -->
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                        <i class="bi bi-exclamation-triangle-fill fs-2tx text-warning me-4"></i>
                        <div class="d-flex flex-stack flex-grow-1">
                            <div class="fw-semibold">
                                <h4 class="text-gray-900 fw-bold">Proses Triage Tiket</h4>
                                <div class="fs-6 text-gray-700">Tentukan kategori, prioritas, dan teknisi penanggung jawab. Sistem akan mencocokkan <b class="text-dark">Target SLA</b> dan mengubah status menjadi <b>In Progress</b> secara otomatis.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Kategori Layanan</label>
                        <select name="category_id" class="form-select form-select-solid" required>
                            <option value="">Pilih Kategori Layanan</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == ($ticket['category_id'] ?? '') ? 'selected' : '' ?>><?= $cat['category_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tipe Tiket -->
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Tipe Laporan</label>
                        <select name="ticket_type" class="form-select form-select-solid" required>
                            <option value="incident" <?= ($ticket['ticket_type'] ?? '') == 'incident' ? 'selected' : '' ?>>Incident (Kendala / Error)</option>
                            <option value="request" <?= ($ticket['ticket_type'] ?? '') == 'request' ? 'selected' : '' ?>>Service Request (Permintaan Layanan)</option>
                        </select>
                    </div>

                    <!-- Prioritas -->
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Prioritas (SLA)</label>
                        <select name="priority_id" class="form-select form-select-solid" required>
                            <option value="">Pilih Prioritas</option>
                            <option value="1" <?= ($ticket['priority_id'] ?? '') == 1 ? 'selected' : '' ?>>Low (Rendah)</option>
                            <option value="2" <?= ($ticket['priority_id'] ?? '') == 2 ? 'selected' : '' ?>>Medium (Sedang)</option>
                            <option value="3" <?= ($ticket['priority_id'] ?? '') == 3 ? 'selected' : '' ?>>High (Tinggi)</option>
                            <option value="4" <?= ($ticket['priority_id'] ?? '') == 4 ? 'selected' : '' ?>>Urgent (Darurat)</option>
                        </select>
                    </div>

                    <!-- Assignee (Teknisi) -->
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Tugaskan Kepada (Teknisi)</label>
                        <select name="assignee_id" class="form-select form-select-solid" required>
                            <option value="">Pilih Teknisi Penanggung Jawab</option>
                            <?php foreach($developers as $dev): ?>
                                <option value="<?= $dev['id'] ?>" <?= ($dev['id'] == ($ticket['assignee_id'] ?? session()->get('id'))) ? 'selected' : '' ?>><?= $dev['username'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Catatan Triage -->
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Catatan Triage (Internal)</label>
                        <textarea name="triage_notes" class="form-control form-control-solid" rows="3" placeholder="Tambahkan instruksi pengerjaan atau hasil analisa awal..."></textarea>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Batal</button>
                    <button type="submit" id="kt_modal_triage_submit" class="btn btn-warning fw-bold">
                        <i class="bi bi-check-circle me-1"></i> Selesaikan Triage & Mulai Pengerjaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end::Modal -->