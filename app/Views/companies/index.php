<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<!-- Toolbar -->
<div class="toolbar mb-5" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack">
        <h1 class="text-dark fw-bolder fs-3">Daftar Perusahaan Klien</h1>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_add_company">
            <i class="bi bi-plus fs-2"></i> Tambah Perusahaan
        </button>
    </div>
</div>

<!-- Main Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-300 align-middle gs-0 gy-3">
                <thead>
                    <tr class="fw-bolder text-muted">
                        <th>ID</th>
                        <th>Nama Perusahaan</th>
                        <th>Industri</th>
                        <th>Alamat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($companies as $c) : ?>
                    <tr>
                        <td>#<?= $c['id'] ?></td>
                        <td class="text-dark fw-bolder"><?= $c['company_name'] ?></td>
                        <td><span class="badge badge-light-info"><?= $c['industry'] ?></span></td>
                        <td><?= $c['address'] ?></td>
                        <td class="text-end">
                            <button class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm btn-edit" data-id="<?= $c['id'] ?>">
                                <i class="bi bi-pencil-square fs-3"></i>
                            </button>
                            <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn-delete" data-id="<?= $c['id'] ?>">
                                <i class="bi bi-trash fs-3"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_company" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="form_add_company" action="<?= site_url('companies/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bolder">Tambah Klien Baru</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"><i class="bi bi-x fs-1"></i></div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Nama Perusahaan</label>
                        <input type="text" class="form-control form-control-solid" name="company_name" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Bidang Industri</label>
                        <input type="text" class="form-control form-control-solid" name="industry" placeholder="Contoh: Perbankan, IT, Retail" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Alamat Kantor</label>
                        <textarea class="form-control form-control-solid" name="address" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="submit" class="btn btn-primary">Daftarkan Perusahaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modal_edit_company" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="form_edit_company" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bolder">Edit Data Klien</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"><i class="bi bi-x fs-1"></i></div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Nama Perusahaan</label>
                        <input type="text" class="form-control form-control-solid" name="company_name" id="edit_company_name" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Bidang Industri</label>
                        <input type="text" class="form-control form-control-solid" name="industry" id="edit_industry" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Alamat Kantor</label>
                        <textarea class="form-control form-control-solid" name="address" id="edit_address" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // 1. TAMBAH PERUSAHAAN
    $('#form_add_company').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire('Berhasil!', res.message, 'success').then(() => location.reload());
            }
        });
    });

    // 2. KLIK EDIT (AMBIL DATA)
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        $.get("<?= site_url('companies/edit/') ?>" + id, function(data) {
            $('#edit_company_name').val(data.company_name);
            $('#edit_industry').val(data.industry);
            $('#edit_address').val(data.address);
            $('#form_edit_company').attr('action', "<?= site_url('companies/update/') ?>" + data.id);
            $('#modal_edit_company').modal('show');
        });
    });

    // 3. PROSES UPDATE
    $('#form_edit_company').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire('Berhasil!', res.message, 'success').then(() => location.reload());
            }
        });
    });

    // 4. DELETE
    $(document).on('click', '.btn-delete', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Klien?',
            text: "User yang terhubung mungkin tidak bisa mengakses sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f1416c',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= site_url('companies/delete/') ?>" + id, function(res) {
                    Swal.fire('Terhapus!', res.message, 'success').then(() => location.reload());
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>