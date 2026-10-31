<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Pengaturan SEO & Kontak Perusahaan</h3>
    </div>
    <form action="<?= base_url('settings/update') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="card-body">
            
            <h5 class="text-primary mb-5">Konfigurasi SEO (Meta Tags)</h5>
            <div class="row mb-10">
                <div class="col-md-6 mb-5">
                    <label class="form-label fw-bold">Nama Situs</label>
                    <input type="text" name="settings[site_name]" value="<?= $settings['site_name'] ?>" class="form-control form-control-solid">
                </div>
                <div class="col-md-6 mb-5">
                    <label class="form-label fw-bold">Meta Author</label>
                    <input type="text" name="settings[meta_author]" value="<?= $settings['meta_author'] ?>" class="form-control form-control-solid">
                </div>
                <div class="col-md-12 mb-5">
                    <label class="form-label fw-bold">Meta Description</label>
                    <textarea name="settings[meta_description]" class="form-control form-control-solid" rows="2"><?= $settings['meta_description'] ?></textarea>
                </div>
                <div class="col-md-12 mb-5">
                    <label class="form-label fw-bold">Meta Keywords</label>
                    <input type="text" name="settings[meta_keywords]" value="<?= $settings['meta_keywords'] ?>" class="form-control form-control-solid">
                </div>
            </div>

            <h5 class="text-success mb-5">Informasi Kontak</h5>
            <div class="row">
                <div class="col-md-6 mb-5">
                    <label class="form-label fw-bold">Email Support</label>
                    <input type="email" name="settings[contact_email]" value="<?= $settings['contact_email'] ?>" class="form-control form-control-solid">
                </div>
                <div class="col-md-6 mb-5">
                    <label class="form-label fw-bold">Nomor Telepon</label>
                    <input type="text" name="settings[contact_phone]" value="<?= $settings['contact_phone'] ?>" class="form-control form-control-solid">
                </div>
                <div class="col-md-12 mb-5">
                    <label class="form-label fw-bold">Alamat Kantor</label>
                    <textarea name="settings[contact_address]" class="form-control form-control-solid" rows="2"><?= $settings['contact_address'] ?></textarea>
                </div>
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>