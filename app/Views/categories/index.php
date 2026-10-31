<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="toolbar mb-5" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack">
        <h1 class="text-dark fw-bolder fs-3">Manajemen Kategori Layanan</h1>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_add_category">
            <i class="bi bi-plus fs-2"></i> Tambah Kategori
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
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat) : ?>
                        <tr>
                            <td>#<?= $cat['id'] ?></td>
                            <td><span class="text-gray-800 fw-bold"><?= $cat['category_name'] ?></span></td>
                            <td><?= $cat['description'] ?></td>
                            <td class="text-end">
                                <button class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm btn-edit" data-id="<?= $cat['id'] ?>">
                                    <i class="bi bi-pencil-square fs-3"></i>
                                </button>
                                <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn-delete" data-id="<?= $cat['id'] ?>">
                                    <i class="bi bi-trash fs-3"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">Belum ada data kategori.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="form_add_category" action="<?= site_url('categories/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bolder">Tambah Kategori Baru</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"><i class="bi bi-x fs-1"></i></div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Nama Kategori</label>
                        <input type="text" class="form-control form-control-solid" name="category_name" placeholder="Misal: Payroll Solution" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Deskripsi</label>
                        <textarea class="form-control form-control-solid" name="description" rows="3"></textarea>
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
<div class="modal fade" id="modal_edit_category" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="form_edit_category" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bolder">Edit Kategori</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"><i class="bi bi-x fs-1"></i></div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Nama Kategori</label>
                        <input type="text" class="form-control form-control-solid" name="category_name" id="edit_category_name" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Deskripsi</label>
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

    // 1. TAMBAH DATA
    $('#form_add_category').on('submit', function(e) {
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
            error: function() {
                btn.prop('disabled', false).text('Simpan');
                Swal.fire('Error', 'Gagal menyimpan data', 'error');
            }
        });
    });

    // 2. KLIK EDIT (AMBIL DATA)
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        let btn = $(this);
        btn.prop('disabled', true);

        $.ajax({
            url: "<?= site_url('categories/edit') ?>/" + id,
            method: "GET",
            dataType: "json",
            success: function(data) {
                $('#edit_category_name').val(data.category_name);
                $('#edit_description').val(data.description);
                $('#form_edit_category').attr('action', "<?= site_url('categories/update') ?>/" + data.id);
                $('#modal_edit_category').modal('show');
                btn.prop('disabled', false);
            },
            error: function() {
                btn.prop('disabled', false);
                Swal.fire('Error', 'Gagal mengambil data', 'error');
            }
        });
    });

    // 3. PROSES UPDATE (SIMPAN)
    $('#form_edit_category').on('submit', function(e) {
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
            title: 'Hapus Kategori?',
            text: "Kategori yang dihapus tidak akan muncul lagi di pilihan tiket.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f1416c',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('categories/delete') ?>/" + id,
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

}); // Penutup Ready Function yang benar
</script>
<?= $this->endSection() ?>