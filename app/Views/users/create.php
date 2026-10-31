<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-row-fluid gap-7">
    <div class="d-flex flex-stack flex-wrap gap-4 mb-8">
        <div>
            <h1 class="fw-bold text-gray-800 mb-2">Create User</h1>
            <div class="text-muted fs-6">Tambahkan user baru dan tetapkan peran.</div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="<?= base_url('users/store') ?>" class="btn btn-light-primary">Back to List</a>
        </div>
    </div>

    <?php if (isset($errors) && ! empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card card-flush">
        <div class="card-body">
            <form action="<?= base_url('users/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row gx-9 gy-6">
                    <div class="col-lg-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" value="<?= old('username') ?>" class="form-control" required />
                    </div>
                    <!-- Contoh di View admin/users/create.php -->
<label>Pilih Perusahaan Klien:</label>
<select name="company_id" class="form-select">
    <option value="">-- Internal Humanika (Develop) --</option>
    <?php foreach ($companies as $c) : ?>
        <option value="<?= $c['id'] ?>"><?= $c['company_name'] ?></option>
    <?php endforeach; ?>
</select>
                    <div class="col-lg-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="<?= old('email') ?>" class="form-control" required />
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirm" class="form-control" required />
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-select" required>
                            <option value="">Pilih Role</option>
                            <?php foreach ($roles as $role) : ?>
                                <option value="<?= esc($role['id']) ?>" <?= old('role_id') == $role['id'] ? 'selected' : '' ?>><?= esc(ucfirst($role['name'])) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">Aktifkan User</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="active" value="1" <?= old('active') ? 'checked' : '' ?> />
                            <label class="form-check-label">Akun aktif setelah dibuat</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-8">
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
