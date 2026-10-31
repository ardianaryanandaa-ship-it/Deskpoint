<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="card bgi-no-repeat bgi-size-cover bgi-position-x-center mb-10" style="background-color: #009ef7; background-image:url('<?= base_url('assets/media/svg/shapes/wave-white.svg') ?>')">
    <div class="card-body py-15 text-center">
        <h1 class="text-white fw-bolder fs-2qx mb-7">Pusat Bantuan</h1>
        <form action="<?= base_url('knowledge') ?>" method="GET" class="position-relative w-md-600px mx-auto">
            <i class="ki-duotone ki-magnifier fs-1 text-primary position-absolute top-50 translate-middle-y ms-5"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" class="form-control form-control-solid ps-15 h-60px" name="search" value="<?= esc($keyword ?? '') ?>" placeholder="Cari solusi kendala Anda..." />
        </form>
    </div>
</div>

<!-- Navigasi ke Manajemen Selalu Aktif -->
<div class="d-flex justify-content-between align-items-center mb-7">
    <h3 class="fw-bolder text-dark">Kategori Bantuan</h3>
    <div class="d-flex gap-3">
        <a href="<?= base_url('knowledge/manage') ?>" class="btn btn-sm btn-light-primary fw-bold">
            <i class="bi bi-list-check"></i> Kelola Semua Artikel
        </a>
        <a href="<?= base_url('knowledge/form') ?>" class="btn btn-sm btn-primary fw-bold">
            <i class="bi bi-plus-lg"></i> Buat Artikel
        </a>
    </div>
</div>

<!-- Bagian Kategori Bantuan -->
<div class="row g-6 g-xl-9">
    <?php foreach($kategori as $cat): ?>
    <div class="col-md-4">
        <!-- Seluruh card dibungkus tag <a> agar bisa diklik -->
        <a href="<?= base_url('knowledge/kategori/'.$cat['id']) ?>" class="card card-flush h-100 border-hover-primary shadow-sm text-decoration-none">
            <div class="card-body d-flex flex-column flex-center text-center py-10">
                
                <!-- Wrapper Ikon: Warna hijau (text-success) & ukuran lebih besar (fs-4x) -->
                <div class="mb-5">
                    <i class="bi <?= $cat['ikon'] ?> fs-4x text-success"></i>
                </div>
                
                <!-- Judul Kategori: Huruf lebih tegas -->
                <h3 class="fs-4 fw-bolder text-gray-800 mb-1"><?= esc($cat['nama']) ?></h3>
                
                <!-- Deskripsi: Abu-abu halus -->
                <span class="text-gray-400 fw-semibold fs-7">Daftar panduan lengkap.</span>
                
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>
<div class="card card-flush shadow-sm mt-10">
    <!-- Header dengan Sub-judul -->
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900 fs-3">Panduan Terbaru</span>
            <span class="text-muted mt-1 fw-semibold fs-7">Solusi dan tutorial paling update untuk Anda</span>
        </h3>
        <div class="card-toolbar">
            <a href="<?= base_url('knowledge/manage') ?>" class="btn btn-sm btn-light">Lihat Semua</a>
        </div>
    </div>

    <!-- Body dengan Grid 2 Kolom -->
    <div class="card-body pt-5">
        <div class="row">
            <?php if (!empty($terbaru)) : ?>
                <?php foreach($terbaru as $art): ?>
                <div class="col-md-6">
                    <!-- Item Artikel -->
                    <div class="d-flex align-items-center mb-8">
                        <!-- Simbol/Icon Dokumen -->
                        <div class="symbol symbol-45px symbol-circle me-5">
                            <span class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-document text-primary fs-2x">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                        
                        <!-- Judul & Meta Info -->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('knowledge/artikel/'.$art['slug']) ?>" class="text-gray-900 text-hover-primary fs-6 fw-bold mb-1">
                                <?= esc($art['judul']) ?>
                            </a>
                            <div class="d-flex align-items-center">
                                <!-- Badge Kategori Kecil -->
                                <span class="badge badge-light-success fs-9 fw-bold px-2 py-1 me-2">
                                    <?= esc($art['nama_kategori'] ?? 'Umum') ?>
                                </span>
                                <!-- Info Tanggal -->
                                <span class="text-muted fs-8 fw-semibold">
                                    <i class="bi bi-calendar3 fs-9 me-1"></i> <?= date('d M Y', strtotime($art['dibuat_pada'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 text-center py-5">
                    <span class="text-muted">Belum ada panduan terbaru.</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Aksen halus saat card di-hover */
    .border-hover-primary:hover {
        border: 1px solid #009ef7 !important;
        transition: 0.3s;
        transform: translateY(-5px);
    }
</style>
<?= $this->endSection() ?>