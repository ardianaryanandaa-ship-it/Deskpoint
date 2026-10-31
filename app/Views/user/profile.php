<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="card card-flush">
    <div class="card-header">
        <h3 class="card-title">Akun Saya</h3>
        <div class="card-toolbar">
            <a href="<?= base_url('dashboard') ?>" class="btn btn-light-primary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('account') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-6">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?= esc($user['username'] ?? '') ?>" required />
            </div>
            <div class="mb-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= esc($user['email'] ?? '') ?>" required />
            </div>
            <div class="mb-6">
                <label class="form-label">Password Baru <span class="text-muted fs-8">(kosongkan jika tidak ingin ganti)</span></label>
                <input type="password" class="form-control" name="password" />
            </div>
            <div class="mb-6">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="password_confirm" />
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
