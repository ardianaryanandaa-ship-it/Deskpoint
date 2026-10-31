<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column py-1">
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bolder fs-3">Daftar Tiket Helpdesk</span>
            </h1>
        </div>
        <div class="d-flex align-items-center py-1">
            <button class="btn btn-primary fw-bolder" data-bs-toggle="modal" data-bs-target="#kt_modal_create_ticket">
                <i class="bi bi-plus fs-2"></i> Buat Tiket Baru
            </button>
        </div>
    </div>
</div>

<div class="post d-flex flex-column-fluid">
    <div class="container-xxl">

        <div class="card card-flush shadow-sm">
            <!-- Header Filter & Search Toolbar -->
            <!-- Ganti Card Header Anda dengan struktur ini -->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
                <!-- Search Box dengan Ikon Terintegrasi -->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                    <input type="text" id="kt_filter_search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari nomor tiket atau subjek..." />
                </div>
            </div>

            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <!-- Filter Prioritas dengan Select2 -->
                <div class="w-100 mw-150px">
                    <select id="kt_filter_priority" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Prioritas">
                        <option value="">Semua Prioritas</option>
                        <option value="Urgent">Urgent</option>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                </div>

                <!-- Filter Status dengan Select2 -->
                <div class="w-100 mw-150px">
                    <select id="kt_filter_status" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status">
                        <option value="">Semua Status</option>
                        <option value="Butuh Triage">Butuh Triage</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
            </div>
        </div>

            <!-- Table Body -->
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_tickets">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">ID</th>
                            <th class="min-w-200px">Subjek / Perihal</th>
                            <th class="min-w-100px">Prioritas</th>
                            <th class="min-w-120px">Status</th>
                            <th class="min-w-120px">Pelapor</th>
                            <th class="min-w-120px">Perusahaan</th>
                            <th class="text-end min-w-70px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        <?php foreach ($tickets as $t) : ?>
                        <tr>
                            <td>#<?= $t['id'] ?></td>
                            <td>
                                <a href="<?= site_url('tickets/show/' . $t['id']) ?>" class="text-gray-800 text-hover-primary mb-1 fw-bolder">
                                    <?= esc($t['subject']) ?>
                                </a>
                                <div class="text-muted fs-7 fw-normal"><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></div>
                            </td>
                            <td>
                                <?php if (!empty($t['priority_name'])) : ?>
                                    <?php if ($t['priority_name'] === 'Urgent') : ?>
                                        <span class="badge badge-light-danger fw-bolder">Urgent</span>
                                    <?php elseif ($t['priority_name'] === 'High') : ?>
                                        <span class="badge badge-light-warning fw-bolder">High</span>
                                    <?php elseif ($t['priority_name'] === 'Medium') : ?>
                                        <span class="badge badge-light-info fw-bolder">Medium</span>
                                    <?php else : ?>
                                        <span class="badge badge-light-success fw-bolder"><?= $t['priority_name'] ?></span>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <span class="badge badge-light-dark text-gray-500">Belum Set</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($t['closed_at']) || ($t['status_name'] ?? '') === 'Closed') : ?>
                                    <span class="badge badge-light-danger fw-bolder">Closed</span>
                                <?php elseif (empty($t['priority_id']) || empty($t['category_id']) || $t['status_id'] == 1) : ?>
                                    <span class="badge badge-light-warning fw-bolder animate-pulse">Butuh Triage</span>
                                <?php elseif (($t['status_name'] ?? '') === 'In Progress') : ?>
                                    <span class="badge badge-light-primary fw-bolder">In Progress</span>
                                <?php else : ?>
                                    <span class="badge badge-light-info fw-bolder"><?= $t['status_name'] ?? 'Open' ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($t['client_name']) ?></td>
                            <td><?= esc($t['company_name'] ?? 'Individual') ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('tickets/show/' . $t['id']) ?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Lihat Detail">
                                    <i class="bi bi-eye-fill fs-3"></i>
                                </a>
                                <?php if ($t['closed_at'] == null) : ?>
                                            <!-- <button type="button" class="btn btn-icon btn-bg-light btn-active-color-warning btn-sm me-1 btn-edit" data-id="<?= $t['id'] ?>" title="Edit Tiket">
                                                <i class="ki-duotone ki-pencil fs-3">
                                                    <span class="path1"></span><span class="path2"></span>
                                                </i>
                                            </button> -->

                                            <button type="button" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn-delete" data-id="<?= $t['id'] ?>" title="Hapus Tiket">
                                                <i class="ki-duotone ki-trash fs-3">
                                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                                    <span class="path4"></span><span class="path5"></span>
                                                </i>
                                            </button>
                                        <?php endif; ?>
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

<!-- Modal Create Ticket -->
<div class="modal fade" id="kt_modal_create_ticket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="kt_modal_create_ticket_form" action="<?= site_url('tickets/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bolder">Buat Laporan Tiket Baru</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="bi bi-x fs-1"></i>
                    </div>
                </div>

                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Kategori Layanan</label>
                        <select name="category_id" class="form-select form-select-solid" required>
                            <option value="">Pilih Kategori Layanan</option>
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= $cat['id'] ?>"><?= esc($cat['category_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Subjek Masalah</label>
                        <input type="text" class="form-control form-control-solid" name="subject" placeholder="Masukkan judul masalah" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Prioritas</label>
                        <select name="priority_id" class="form-select form-select-solid" required>
                            <option value="1">Low</option>
                            <option value="2">Medium</option>
                            <option value="3">High</option>
                            <option value="4">Urgent</option>
                        </select>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Deskripsi Detail</label>
                        <textarea class="form-control form-control-solid" rows="4" name="description" placeholder="Ceritakan kronologi masalah..." required></textarea>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-bold mb-2">Lampiran File (Opsional)</label>
                        <input type="file" name="attachment" class="form-control form-control-solid" />
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Kirim Tiket</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="kt_modal_edit_ticket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="kt_modal_edit_ticket_form" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h2 class="fw-bolder">Edit Tiket #<span id="edit_ticket_id_label"></span></h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Subjek Masalah</label>
                        <input type="text" class="form-control form-control-solid" name="subject" id="edit_subject" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Prioritas</label>
                        <select name="priority_id" id="edit_priority_id" class="form-select form-select-solid">
                            <option value="1">Low</option>
                            <option value="2">Medium</option>
                            <option value="3">High</option>
                            <option value="4">Urgent</option>
                        </select>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-bold mb-2">Deskripsi Detail</label>
                        <textarea class="form-control form-control-solid" rows="4" name="description" id="edit_description" required></textarea>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold">Update Tiket</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {

    // Inisialisasi DataTables
    let ticketTable = $('#kt_table_tickets').DataTable({
    // l = length, t = table, i = info, p = pagination (Hilangkan 'f' agar searchbox default hilang)
    dom: "rt<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    order: [[0, 'desc']],
    pageLength: 10,
    responsive: true,
    columnDefs: [
        { orderable: false, targets: -1 } 
    ]
});

// Update Search Logic agar lebih responsif
$('#kt_filter_search').on('keyup', function() {
    ticketTable.search(this.value).draw();
});

// Update Filter Logic dengan Regex (Exact Match)
$('#kt_filter_status').on('change', function() {
    let val = $(this).val();
    ticketTable.column(3).search(val ? '^' + val + '$' : '', true, false).draw();
});
    // AJAX Create Tiket
    $(document).on('submit', '#kt_modal_create_ticket_form', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                Swal.fire('Berhasil!', response.message, 'success').then(() => { 
                    window.location.reload(); 
                });
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Kirim Tiket');
                let msg = xhr.responseJSON ? (xhr.responseJSON.message || 'Cek kembali isian Anda.') : 'Terjadi kesalahan.';
                Swal.fire('Error!', msg, 'error');
            }
        });
    });

});

// 1. Tombol Edit - Ambil Data
// $(document).on('click', '.btn-edit', function() {
//     let id = $(this).data('id');
//     $.ajax({
//         url: "<?= site_url('tickets/edit/') ?>" + id,
//         method: "GET",
//         dataType: "json",
//         success: function(data) {
//             $('#edit_ticket_id_label').text(data.id);
//             $('#edit_subject').val(data.subject);
//             $('#edit_priority_id').val(data.priority_id);
//             $('#edit_description').val(data.description);
//             // Set action URL secara dinamis
//             $('#kt_modal_edit_ticket_form').attr('action', "<?= site_url('tickets/update/') ?>" + data.id);
//             $('#kt_modal_edit_ticket').modal('show');
//         }
//     });
// });

// // 2. Submit Update
// $(document).on('submit', '#kt_modal_edit_ticket_form', function(e) {
//     e.preventDefault();
//     $.ajax({
//         url: $(this).attr('action'),
//         method: 'POST',
//         data: $(this).serialize(),
//         dataType: 'json',
//         success: function(response) {
//             Swal.fire('Berhasil!', 'Data tiket telah diperbarui.', 'success').then(() => {
//                 location.reload();
//             });
//         }
//     });
// });

// 3. Tombol Hapus - SweetAlert2
$(document).on('click', '.btn-delete', function() {
    let id = $(this).data('id');
    Swal.fire({
        title: 'Hapus Tiket?',
        text: "Tiket akan dipindahkan ke arsip sampah.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f1416c', // Warna Danger Metronic
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= site_url('tickets/delete/') ?>" + id,
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    Swal.fire('Terhapus!', response.message, 'success').then(() => {
                        location.reload();
                    });
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>