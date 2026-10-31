<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="post d-flex flex-column-fluid">
    <div class="container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            
            <!-- Kolom Samping (Sidebar Info) -->
            <div class="flex-column flex-lg-row-auto w-100 w-lg-300px mb-10">
                <div class="card mb-5 mb-xl-8 shadow-sm">
                    <div class="card-body pt-10">
                        <div class="d-flex flex-center flex-column mb-5">
                            <span class="fs-3 text-gray-800 fw-bolder mb-1">Tiket #<?= $ticket['id'] ?></span>
                            <span class="badge badge-light-primary fw-bolder px-4 py-3"><?= $ticket['status_name'] ?></span>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="pb-5 fs-6">
                            <div class="fw-bolder mt-4 text-gray-800">Pelapor</div>
                            <div class="text-gray-600"><?= $ticket['client_name'] ?></div>

                            <div class="fw-bolder mt-4 text-gray-800">Perusahaan</div>
                            <div class="text-primary fw-bold"><?= $ticket['company_name'] ?? 'Internal / Individual' ?></div>

                            <div class="fw-bolder mt-4 text-gray-800">Kategori Layanan</div>
                            <div class="text-gray-700 fw-semibold"><?= $ticket['category_name'] ?? 'Belum Ditentukan' ?></div>

                            <div class="fw-bolder mt-4 text-gray-800">Prioritas</div>
                            <div>
                                <?php if ($ticket['priority_name']) : ?>
                                    <span class="badge badge-light-primary"><?= $ticket['priority_name'] ?></span>
                                <?php else : ?>
                                    <span class="badge badge-light-dark text-gray-500">Belum Set (Butuh Triage)</span>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($ticket['sla_limit_hours'])) : ?>
                                <div class="fw-bolder mt-4 text-gray-800">Target SLA Resolusi</div>
                                <div><span class="badge badge-light-success fw-bold"><i class="bi bi-clock me-1 text-success"></i><?= $ticket['sla_limit_hours'] ?> Jam</span></div>
                            <?php endif; ?>

                            <div class="fw-bolder mt-4 text-gray-800">Teknisi (Assignee)</div>
                            <div class="text-primary fw-bold"><?= $ticket['developer_name'] ?? 'Belum Ditugaskan' ?></div>

                            <div class="fw-bolder mt-4 text-gray-800">Dibuat Pada</div>
                            <div class="text-gray-600"><?= date('d M Y, H:i', strtotime($ticket['created_at'])) ?></div>
                        </div>

                        <?php if (session()->get('role_name') === 'develop') : ?>
                            <form action="<?= site_url('tickets/update-status/' . $ticket['id']) ?>" method="post" class="form-update-status">
                                <div class="mb-3 mt-5">
                                    <label class="form-label fw-bold">Ubah Status Tiket:</label>
                                    <select name="status_id" class="form-select form-select-solid">
                                        <?php foreach ($statuses as $s) : ?>
                                            <option value="<?= $s['id'] ?>" <?= $s['id'] == $ticket['status_id'] ? 'selected' : '' ?>><?= $s['status_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-sm btn-dark w-100 fw-bold">Update Status</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header"><h3 class="card-title fs-6 fw-bold">Lampiran Bukti</h3></div>
                    <div class="card-body">
                        <?php if (empty($attachments)) : ?>
                            <span class="text-muted">Tidak ada lampiran file.</span>
                        <?php else : ?>
                            <?php foreach ($attachments as $at) : ?>
                                <a href="<?= base_url('uploads/tickets/' . $at['file_path']) ?>" target="_blank" class="btn btn-light-primary btn-sm mb-2 w-100 text-start">
                                    <i class="bi bi-file-earmark-text me-1"></i> <?= $at['file_name'] ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Kolom Utama (Chat & Deskripsi) -->
            <div class="flex-lg-row-fluid ms-lg-15">

                <!-- Alert Triage jika belum di-triage & role develop -->
                <?php if ((empty($ticket['priority_id']) || $ticket['status_id'] == 1) && session()->get('role_name') === 'develop') : ?>
                    <div class="alert alert-dismissible bg-light-warning d-flex flex-column flex-sm-row p-6 mb-8 border border-warning border-dashed shadow-sm rounded-3">
                        <i class="bi bi-shield-exclamation fs-2tx text-warning me-4 mb-3 mb-sm-0"></i>
                        <div class="d-flex flex-column pe-0 pe-sm-10">
                            <h4 class="fw-bolder text-gray-900 mb-1">Tiket Membutuhkan Triage</h4>
                            <span class="text-gray-700 fs-6">Tiket ini baru masuk. Mohon klasifikasikan kategori, prioritas, dan tentukan teknisi penanggung jawab.</span>
                        </div>
                        <button class="btn btn-warning fw-bold btn-sm ms-sm-auto align-self-center mt-3 mt-sm-0 px-6 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_triage">
                            <i class="bi bi-sliders me-1"></i> Lakukan Triage
                        </button>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm mb-5">
                    <div class="card-header bg-light">
                        <h3 class="card-title fw-bolder"><?= $ticket['subject'] ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6 mb-10">
                            <i class="bi bi-info-circle-fill fs-2tx text-primary me-4"></i>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold">
                                    <h4 class="text-gray-900 fw-bolder">Deskripsi Masalah</h4>
                                    <div class="fs-6 text-gray-700"><?= nl2br(esc($ticket['description'])) ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Section -->
                        <div class="scroll-y me-n5 pe-5 h-400px" id="chat-box-container">
                            <?php foreach ($comments as $c) : ?>
                                <div class="d-flex flex-column mb-5 align-items-<?= $c['user_id'] == session()->get('id') ? 'end' : 'start' ?>">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-3">
                                            <span class="text-muted fs-7 mb-1"><?= date('H:i', strtotime($c['created_at'])) ?></span>
                                            <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1"><?= $c['username'] ?></a>
                                        </div>
                                    </div>
                                    <div class="p-5 rounded <?= $c['user_id'] == session()->get('id') ? 'bg-light-primary text-dark' : 'bg-light-secondary text-dark' ?> fw-bold mw-lg-400px text-start">
                                        <?= nl2br(esc($c['message'])) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card-footer pt-4">
                        <form id="form-comment" action="<?= site_url('tickets/comment/' . $ticket['id']) ?>" method="post">
                            <textarea class="form-control form-control-solid mb-3" rows="2" name="message" placeholder="Tulis balasan..."></textarea>
                            <div class="d-flex flex-stack">
                                <button class="btn btn-primary fw-bold" type="submit">Kirim Balasan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- INCLUDE MODAL TRIAGE -->
<?= $this->include('tickets/triage') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // 1. AJAX UNTUK UPDATE STATUS
    $('.form-update-status').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan';
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    });

    // 2. AJAX UNTUK SUBMIT TRIAGE
    $(document).on('submit', '#kt_modal_triage_form', function(e) {
        e.preventDefault();
        let form = $(this);
        let btn = $('#kt_modal_triage_submit');

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses Triage...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Triage Berhasil!',
                    text: res.message,
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Selesaikan Triage & Mulai Pengerjaan');
                let msg = xhr.responseJSON ? (xhr.responseJSON.message || JSON.stringify(xhr.responseJSON.messages)) : 'Terjadi kesalahan sistem.';
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    });

    // 3. AJAX UNTUK KIRIM KOMENTAR
    $('#form-comment').on('submit', function(e) {
        e.preventDefault();
        let btn = $(this).find('button');
        let message = $(this).find('textarea').val();

        if(message.trim() == "") return;

        btn.prop('disabled', true).text('Mengirim...');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                let newChat = `
                    <div class="d-flex flex-column mb-5 align-items-end">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3">
                                <span class="text-muted fs-7 mb-1">${response.time}</span>
                                <a href="#" class="fs-5 fw-bolder text-gray-900 ms-1">${response.username}</a>
                            </div>
                        </div>
                        <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-start">
                            ${response.message}
                        </div>
                    </div>`;
                
                $('#chat-box-container').append(newChat); 
                $('#form-comment textarea').val('');
                btn.prop('disabled', false).text('Kirim Balasan');
                $('#chat-box-container').animate({ scrollTop: $('#chat-box-container')[0].scrollHeight }, 500);
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Kirim Balasan');
                let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal mengirim pesan.';
                Swal.fire('Gagal!', msg, 'error');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>