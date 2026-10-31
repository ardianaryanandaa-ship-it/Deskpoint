<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="toolbar mb-5" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack">
        <h1 class="text-dark fw-bolder fs-3">Manajemen Service Level Agreement (SLA)</h1>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_add_sla">
            <i class="bi bi-plus fs-2"></i> Tambah Aturan SLA
        </button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-300 align-middle gs-0 gy-3">
                <thead>
                    <tr class="fw-bolder text-muted">
                        <th>ID</th>
                        <th>Kategori</th>
                        <th>Prioritas</th>
                        <th>Batas Waktu Respon (Jam)</th>
                        <th>Batas Waktu Resolusi (Jam)</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    <?php if (!empty($slas)): ?>
                        <?php foreach ($slas as $s) : ?>
                        <tr>
                            <td>#<?= $s['id'] ?></td>
                            <td><span class="badge badge-light-primary"><?= $s['category_name'] ?? 'Semua Kategori' ?></span></td>
                            <td>
                                <?php if (($s['priority_name'] ?? '') === 'Urgent'): ?>
                                    <span class="badge badge-light-danger">Urgent</span>
                                <?php elseif (($s['priority_name'] ?? '') === 'High'): ?>
                                    <span class="badge badge-light-warning">High</span>
                                <?php elseif (($s['priority_name'] ?? '') === 'Medium'): ?>
                                    <span class="badge badge-light-info">Medium</span>
                                <?php else: ?>
                                    <span class="badge badge-light-success"><?= $s['priority_name'] ?? 'Low' ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $s['response_time_limit'] ? $s['response_time_limit'] . ' Jam' : '-' ?></td>
                            <td><span class="fw-bold text-dark"><?= $s['resolution_time_limit'] ?> Jam</span></td>
                            <td><?= $s['description'] ?? '-' ?></td>
                            <td class="text-end">
                                <button class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm btn-edit" data-id="<?= $s['id'] ?>">
                                    <i class="bi bi-pencil-square fs-3"></i>
                                </button>
                                <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn-delete" data-id="<?= $s['id'] ?>">
                                    <i class="bi bi-trash fs-3"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">Belum ada aturan SLA.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_sla" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="form_add_sla" action="<?= site_url('sla/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bolder">Tambah Aturan SLA Baru</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"><i class="bi bi-x fs-1"></i></div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Kategori Layanan</label>
                        <select name="category_id" class="form-select form-select-solid" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Tingkat Prioritas</label>
                        <select name="priority_id" class="form-select form-select-solid" required>
                            <option value="">Pilih Prioritas</option>
                            <?php foreach ($priorities as $prio): ?>
                                <option value="<?= $prio['id'] ?>"><?= $prio['priority_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Batas Waktu Respon (Jam)</label>
                        <input type="number" class="form-control form-control-solid" name="response_time_limit" placeholder="Contoh: 2" />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Batas Waktu Resolusi (Jam)</label>
                        <input type="number" class="form-control form-control-solid" name="resolution_time_limit" placeholder="Contoh: 24" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Deskripsi / Keterangan</label>
                        <textarea class="form-control form-control-solid" name="description" rows="3" placeholder="Catatan penanganan SLA..."></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modal_edit_sla" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="form_edit_sla" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bolder">Edit Aturan SLA</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"><i class="bi bi-x fs-1"></i></div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Kategori Layanan</label>
                        <select name="category_id" id="edit_category_id" class="form-select form-select-solid" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Tingkat Prioritas</label>
                        <select name="priority_id" id="edit_priority_id" class="form-select form-select-solid" required>
                            <option value="">Pilih Prioritas</option>
                            <?php foreach ($priorities as $prio): ?>
                                <option value="<?= $prio['id'] ?>"><?= $prio['priority_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Batas Waktu Respon (Jam)</label>
                        <input type="number" class="form-control form-control-solid" name="response_time_limit" id="edit_response_time_limit" />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Batas Waktu Resolusi (Jam)</label>
                        <input type="number" class="form-control form-control-solid" name="resolution_time_limit" id="edit_resolution_time_limit" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Deskripsi / Keterangan</label>
                        <textarea class="form-control form-control-solid" name="description" id="edit_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {

    // 1. TAMBAH SLA
    $('#form_add_sla').on('submit', function(e) {
        e.preventDefault();
        let btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).text('Tunggu...');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                Swal.fire('Berhasil!', res.message, 'success').then(() => location.reload());
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Simpan');
                let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal menyimpan data';
                Swal.fire('Error', msg, 'error');
            }
        });
    });

    // 2. KLIK EDIT (AMBIL DATA)
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        let btn = $(this);
        btn.prop('disabled', true);

        $.ajax({
            url: "<?= site_url('sla/edit') ?>/" + id,
            method: "GET",
            dataType: "json",
            success: function(data) {
                $('#edit_category_id').val(data.category_id);
                $('#edit_priority_id').val(data.priority_id);
                $('#edit_response_time_limit').val(data.response_time_limit);
                $('#edit_resolution_time_limit').val(data.resolution_time_limit);
                $('#edit_description').val(data.description);
                $('#form_edit_sla').attr('action', "<?= site_url('sla/update') ?>/" + data.id);
                $('#modal_edit_sla').modal('show');
                btn.prop('disabled', false);
            },
            error: function() {
                btn.prop('disabled', false);
                Swal.fire('Error', 'Gagal mengambil data', 'error');
            }
        });
    });

    // 3. PROSES UPDATE (SIMPAN)
    $('#form_edit_sla').on('submit', function(e) {
        e.preventDefault();
        let btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                Swal.fire('Berhasil!', res.message, 'success').then(() => location.reload());
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Update');
                let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem';
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    });

    // 4. DELETE
    $(document).on('click', '.btn-delete', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Aturan SLA?',
            text: "Data SLA yang dihapus tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f1416c',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('sla/delete') ?>/" + id,
                    method: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire('Terhapus!', res.message, 'success').then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menghapus data', 'error');
                    }
                });
            }
        });
    });

});
</script>
<?= $this->endSection() ?>
