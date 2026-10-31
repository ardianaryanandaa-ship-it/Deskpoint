<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="mb-10">
    <a href="<?= base_url('knowledge') ?>" class="btn btn-sm btn-light-primary mb-5">
        <i class="bi bi-arrow-left"></i> Kembali ke Pusat Bantuan
    </a>
    
    <div class="d-flex align-items-center">
        <i class="bi <?= $ikon_kat ?> fs-3x text-success me-4"></i>
        <div>
            <h1 class="fw-bolder text-gray-900 mb-0"><?= $nama_kat ?></h1>
            <div class="text-muted fw-bold fs-6">Menampilkan semua panduan terkait <?= strtolower($nama_kat) ?></div>
        </div>
    </div>
</div>

<div class="card card-flush shadow-sm">
    <div class="card-body">
        <?php if (!empty($artikel)) : ?>
            <div class="row">
                <?php foreach ($artikel as $a) : ?>
                    <div class="col-md-6 mb-8">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px me-5">
                                <span class="symbol-label bg-light-success">
                                    <i class="bi bi-file-earmark-text text-success fs-2"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="<?= base_url('knowledge/artikel/' . $a['slug']) ?>" class="text-gray-900 text-hover-primary fs-6 fw-bold">
                                    <?= esc($a['judul']) ?>
                                </a>
                                <span class="text-muted fs-7">Dibaca <?= $a['total_dilihat'] ?> kali</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="text-center py-10">
                <img src="<?= base_url('assets/media/illustrations/sigma-1/13.png') ?>" class="mw-150px mb-5" />
                <h3 class="text-gray-800">Belum ada artikel</h3>
                <p class="text-gray-400">Tim kami sedang menyiapkan panduan untuk kategori ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>