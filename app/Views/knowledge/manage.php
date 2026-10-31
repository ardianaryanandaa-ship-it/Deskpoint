<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="card card-flush shadow-sm">
    <div class="card-header border-0 pt-6">
        <h3 class="card-title fw-bolder">Data Knowledge Base</h3>
        <div class="card-toolbar">
            <a href="<?= base_url('knowledge/form') ?>" class="btn btn-success btn-sm">Tulis Artikel Baru</a>
        </div>
    </div>
    <div class="card-body py-4">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_knowledge">
            <thead>
                <tr class="text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Total Dilihat</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
                <?php foreach($artikel as $a): ?>
                <tr>
                    <td><?= $a['judul'] ?></td>
                    <td><span class="badge badge-light-info"><?= $a['nama_kategori'] ?></span></td>
                    <td><i class="bi bi-eye me-1"></i> <?= $a['total_dilihat'] ?></td>
                    <td class="text-end">
                        <a href="<?= base_url('knowledge/form/'.$a['id']) ?>" class="btn btn-icon btn-light-warning btn-sm me-2"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-icon btn-light-danger btn-sm btn-delete" data-id="<?= $a['id'] ?>"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>