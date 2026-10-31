<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="card">
    <form action="<?= base_url('knowledge/save') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $artikel['id'] ?? '' ?>">
        
        <div class="card-body">
            <div class="fv-row mb-7">
                <label class="required fs-6 fw-bold mb-2">Judul Artikel</label>
                <input type="text" name="judul" class="form-control form-control-solid" value="<?= old('judul', $artikel['judul'] ?? '') ?>" required />
            </div>

            <div class="fv-row mb-7">
                <label class="required fs-6 fw-bold mb-2">Kategori</label>
                <select name="id_kategori" class="form-select form-select-solid" data-control="select2" required>
                    <?php foreach($kategori as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($artikel) && $artikel['id_kategori'] == $cat['id']) ? 'selected' : '' ?>><?= $cat['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="fv-row mb-7">
                <label class="required fs-6 fw-bold mb-2">Konten Tutorial</label>
                <textarea name="isi_artikel" id="summernote" class="form-control"><?= $artikel['isi_artikel'] ?? '' ?></textarea>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="<?= base_url('knowledge/manage') ?>" class="btn btn-light me-3">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({ height: 400 });
    });
</script>
<?= $this->endSection() ?>