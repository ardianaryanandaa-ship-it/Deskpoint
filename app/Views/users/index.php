<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-row-fluid gap-7">
    <div class="d-flex flex-stack flex-wrap gap-4 mb-8">
        <div>
            <h1 class="fw-bold text-gray-800 mb-2">Users List</h1>
            <div class="text-muted fs-6">Kelola pengguna, hak akses, dan status akun.</div>
            <div class="d-flex flex-wrap align-items-center gap-2 mt-3">
                <a href="<?= base_url('dashboard') ?>" class="text-muted text-hover-primary">Home</a>
                <span class="bullet bg-secondary h-5px w-5px rounded-circle"></span>
                <span class="text-muted">User Management</span>
                <span class="bullet bg-secondary h-5px w-5px rounded-circle"></span>
                <span class="text-muted">Users</span>
                <span class="bullet bg-secondary h-5px w-5px rounded-circle"></span>
                <span class="fw-semibold text-dark">Users List</span>
            </div>
        </div>
    </div>

    <div class="card card-flush mb-8">
        <div class="card-body">
            <div class="row gx-5 gy-4 align-items-center">
                <div class="col-lg-6">
                    <div class="position-relative">
                        <input type="text" class="form-control form-control-solid ps-12" placeholder="Search user" name="search" value="<?= esc($filters['search'] ?? '') ?>" />
                        <span class="position-absolute top-50 translate-middle-y ms-4 text-muted">
                            <i class="ki-duotone ki-magnifier fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-lg-end gap-3">
                    <a href="<?= base_url('users') ?>" class="btn btn-light-success">Filter</a>
                    <a href="<?= base_url('users/create') ?>" class="btn btn-success">+ Add User</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-flush">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-row-bordered table-row-gray-200 align-middle gs-0 gy-4">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-10 min-w-150px">User</th>
                            <th class="min-w-125px">Role</th>
                            <th class="min-w-125px">Joined Date</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <?php if (empty($users)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-10">No users found.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td class="ps-10">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px symbol-circle me-4">
                                            <span class="symbol-label bg-light-primary text-primary fw-bold"><?= esc(strtoupper($user['username'][0] ?? 'U')) ?></span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-900 fw-bold"><?= esc($user['username']) ?></span>
                                            <span class="text-muted fs-7"><?= esc($user['email']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-light-primary"><?= esc(ucfirst($user['role_name'] ?? 'User')) ?></span></td>
                                <td><?= $user['created_at'] ? date('d M Y, H:i', strtotime($user['created_at'])) : '-' ?></td>
                                <td class="text-end">
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                        </a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3 btn-edit-user" data-id="<?= $user['id'] ?>">Edit</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3 btn-delete-user text-danger" data-id="<?= $user['id'] ?>">Delete</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <form action="<?= base_url('users/force-logout/' . $user['id']) ?>" method="POST" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="menu-link px-3 border-0 bg-transparent w-100 text-start">Force Logout</button>
                                                </form>
                                            </div>
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal_edit_user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="form_edit_user" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bold">Edit User</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"><i class="ki-duotone ki-cross fs-1"></i></div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Username</label>
                        <input type="text" class="form-control form-control-solid" name="username" id="edit_username" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Email</label>
                        <input type="email" class="form-control form-control-solid" name="email" id="edit_email" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Role</label>
                        <select name="role_id" id="edit_role_id" class="form-select form-select-solid">
                            <?php foreach($roles as $r): ?>
                                <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">New Password (Kosongkan jika tidak ganti)</label>
                        <input type="password" class="form-control form-control-solid" name="password" />
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // 1. Ambil Data User untuk Edit
    $(document).on('click', '.btn-edit-user', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.get("<?= base_url('users/edit') ?>/" + id, function(data) {
            $('#edit_username').val(data.username);
            $('#edit_email').val(data.email);
            $('#edit_role_id').val(data.role_id);
            $('#form_edit_user').attr('action', "<?= base_url('users/update') ?>/" + id);
            $('#kt_modal_edit_user').modal('show');
        });
    });

    // 2. Submit Update User
    $('#form_edit_user').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                Swal.fire('Success', res.message, 'success').then(() => location.reload());
            },
            error: function(xhr) {
                Swal.fire('Error', 'Gagal memperbarui data', 'error');
            }
        });
    });

    // 3. Delete User dengan SweetAlert
    $(document).on('click', '.btn-delete-user', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        Swal.fire({
            title: 'Hapus User?',
            text: "User akan dihapus (Soft Delete)",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= base_url('users/delete') ?>/" + id, { _method: 'DELETE' }, function(res) {
                    Swal.fire('Deleted', res.message, 'success').then(() => location.reload());
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
