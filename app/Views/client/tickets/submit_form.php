<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card shadow-sm">
            <div class="card-header border-0 pt-10">
                <div class="card-title flex-column">
                    <h2 class="fw-bolder text-gray-800 fs-1">Buat Laporan Kendala</h2>
                    <span class="text-muted fw-bold fs-6">Jelaskan masalah Anda, tim teknis kami akan segera melakukan klasifikasi dan penanganan.</span>
                </div>
            </div>

            <div class="card-body py-10 px-lg-17">
                <form id="form_submit_report" action="<?= site_url('client/report/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- 1. Subjek Masalah -->
                    <div class="fv-row mb-8">
                        <label class="required fs-6 fw-bold mb-2">Subjek / Judul Kendala</label>
                        <input type="text" name="subject" class="form-control form-control-solid" placeholder="Contoh: Gagal login ke sistem payroll" required />
                        <div class="text-muted fs-7 mt-2">Berikan judul singkat yang menggambarkan inti masalah.</div>
                    </div>

                    <!-- 2. Deskripsi Detail -->
                    <div class="fv-row mb-8">
                        <label class="required fs-6 fw-bold mb-2">Deskripsi Kronologi</label>
                        <textarea name="description" class="form-control form-control-solid" rows="8" placeholder="Mohon jelaskan secara detail apa yang terjadi, kapan terjadi, dan apakah ada pesan error tertentu..."></textarea>
                    </div>

                    <!-- 3. Lampiran File -->
                    <div class="fv-row mb-12">
                        <label class="fs-6 fw-bold mb-2">Lampiran Bukti / Screenshot (Opsional)</label>
                        <input type="file" name="attachment" class="form-control form-control-solid" />
                        <div class="form-text">Format: jpg, jpeg, png, pdf (Maks 2MB).</div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="text-center">
                        <button type="reset" class="btn btn-light me-3">Reset</button>
                        <button type="submit" id="btn_submit" class="btn btn-primary px-20">
                            <span class="indicator-label">Kirim Laporan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#form_submit_report').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $('#btn_submit');

        btn.attr('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Laporan Terkirim!',
                    text: 'Tim kami akan segera memeriksa dan menentukan prioritas penanganan.',
                    confirmButtonText: 'Selesai'
                }).then(() => {
                    location.reload(); 
                });
            },
            error: function(xhr) {
                btn.attr('disabled', false).text('Kirim Laporan');
                let errors = xhr.responseJSON.messages;
                let msg = errors ? Object.values(errors).join('<br>') : 'Terjadi kesalahan sistem.';
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>