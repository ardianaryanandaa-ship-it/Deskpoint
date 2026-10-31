<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<!-- Toolbar -->
<div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column py-1">
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bolder fs-3">Konfigurasi Triage & SLA</span>
            </h1>
            <span class="text-muted fw-bold fs-7">Matriks aturan waktu respon dan resolusi tiket.</span>
        </div>
        <div class="d-flex align-items-center py-1">
            <button class="btn btn-primary fw-bolder" onclick="addSlaRule()">
                <i class="bi bi-plus fs-2"></i> Tambah Aturan
            </button>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="card card-flush shadow-sm">
    <div class="card-body pt-5">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_sla">
                <thead>
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-150px">Kategori</th>
                        <th class="min-w-100px">Prioritas</th>
                        <th class="min-w-100px text-center">Respon (Menit)</th>
                        <th class="min-w-100px text-center">Resolusi (Jam)</th>
                        <th class="min-w-200px">Keterangan</th>
                        <th class="text-end min-w-100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    <?php if (!empty($sla_matrix)): ?>
                        <?php foreach ($sla_matrix as $row) : ?>
                        <tr>
                            <td><div class="text-gray-800 fs-6"><?= esc($row['category_name']) ?></div></td>
                            <td>
                                <?php 
                                    $prio_class = match($row['priority_name']) {
                                        'Urgent' => 'badge-light-danger',
                                        'High'   => 'badge-light-warning',
                                        'Medium' => 'badge-light-primary',
                                        default  => 'badge-light-success'
                                    };
                                ?>
                                <span class="badge <?= $prio_class ?> fs-7"><?= $row['priority_name'] ?></span>
                            </td>
                            <td class="text-center"><?= $row['response_time_limit'] ?> m</td>
                            <td class="text-center text-primary"><?= $row['resolution_time_limit'] ?> j</td>
                            <td class="text-muted fs-7 fw-normal"><?= esc($row['description']) ?></td>
                            <td class="text-end">
                                <button class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1 btn-edit" data-id="<?= $row['id'] ?>">
                                    <i class="bi bi-pencil-square fs-3"></i>
                                </button>
                                <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn-delete" data-id="<?= $row['id'] ?>">
                                    <i class="bi bi-trash fs-3"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-10">Data matrik belum diatur.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="kt_modal_sla" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="form_sla_matrix" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bolder" id="modal_sla_title">Atur SLA</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"><i class="bi bi-x fs-1"></i></div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="row g-9 mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Kategori</label>
                            <select name="category_id" id="cat_id" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_sla">
                                <option></option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= $c['category_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Prioritas</label>
                            <select name="priority_id" id="prio_id" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_sla">
                                <option></option>
                                <?php foreach($priorities as $p): ?>
                                    <option value="<?= $p['id'] ?>"><?= $p['priority_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row g-9 mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Respon (Menit)</label>
                            <input type="number" name="response_time_limit" id="res_limit" class="form-control form-control-solid" required />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Resolusi (Jam)</label>
                            <input type="number" name="resolution_time_limit" id="sol_limit" class="form-control form-control-solid" required />
                        </div>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Deskripsi Aturan</label>
                        <textarea name="description" id="desc_sla" class="form-control form-control-solid" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="submit" id="btn_sla_submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function addSlaRule() {
        $('#modal_sla_title').text('Tambah Aturan SLA');
        $('#form_sla_matrix')[0].reset();
        $('#cat_id, #prio_id').val('').trigger('change');
        $('#form_sla_matrix').attr('action', "<?= site_url('triage-sla/store') ?>");
        $('#kt_modal_sla').modal('show');
    }

    $(document).ready(function() {
        // Edit Data
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $.get("<?= site_url('triage-sla/edit') ?>/" + id, function(data) {
                $('#modal_sla_title').text('Edit Aturan SLA');
                $('#cat_id').val(data.category_id).trigger('change');
                $('#prio_id').val(data.priority_id).trigger('change');
                $('#res_limit').val(data.response_time_limit);
                $('#sol_limit').val(data.resolution_time_limit);
                $('#desc_sla').val(data.description);
                $('#form_sla_matrix').attr('action', "<?= site_url('triage-sla/update') ?>/" + id);
                $('#kt_modal_sla').modal('show');
            });
        });

        // Submit Form
        $('#form_sla_matrix').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    Swal.fire('Sukses', res.message, 'success').then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON.message || 'Gagal menyimpan', 'error');
                }
            });
        });

        // Delete Data
        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("<?= site_url('triage-sla/delete') ?>/" + id, function() {
                        location.reload();
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>