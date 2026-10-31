<?= $this->extend('layout/metronic') ?>

<?= $this->section('content') ?>
<!-- Header Welcome -->
<div class="d-flex flex-wrap flex-stack mb-6">
    <div class="d-flex flex-column shadow-none">
        <h1 class="fw-bolder text-gray-900 fs-2qx">Hello, <?= session()->get('username') ?>!</h1>
        <div class="text-gray-500 fw-semibold fs-6">Berikut adalah ringkasan performa sistem helpdesk hari ini.</div>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <span class="badge badge-light-success fw-bold px-4 py-3"><?= date('d M Y') ?></span>
    </div>
</div>

<!--begin::Row Kartu Statistik-->
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    
    <?php if (session()->get('role_name') === 'develop') : ?>
        <!-- CARD 1: BUTUH TRIAGE (Mendesak) -->
        <div class="col-md-3">
            <div class="card card-flush h-md-100 bg-light-danger border-start border-danger border-4">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2"><?= $stats->need_triage ?></span>
                            <span class="badge badge-danger fs-base px-2 py-1 animate-pulse">Action Required</span>
                        </div>
                        <span class="text-gray-500 pt-1 fw-semibold fs-6">Belum di-Triage</span>
                    </div>
                </div>
                <div class="card-body d-flex align-items-end pt-0">
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="h-8px mx-3 w-100 bg-white rounded">
                            <div class="bg-danger rounded h-8px" role="progressbar" style="width: <?= $stats->need_triage > 0 ? '100%' : '0%' ?>;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 2: AKTIF (In Progress) -->
        <div class="col-md-3">
            <div class="card card-flush h-md-100 bg-light-warning border-start border-warning border-4">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2"><?= $stats->in_progress ?></span>
                        <span class="text-gray-500 pt-1 fw-semibold fs-6">Sedang Dikerjakan</span>
                    </div>
                </div>
                <div class="card-body d-flex flex-column justify-content-end pe-0">
                    <span class="fs-7 fw-bold text-gray-800 d-block mb-2">Technical Team Active</span>
                    <div class="symbol-group symbol-hover">
                        <div class="symbol symbol-30px symbol-circle" data-bs-toggle="tooltip" title="Support Team"><span class="symbol-label bg-warning text-inverse-warning fw-bold">IT</span></div>
                        <div class="symbol symbol-30px symbol-circle" data-bs-toggle="tooltip" title="Payroll Team"><span class="symbol-label bg-primary text-inverse-primary fw-bold">PR</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 3: TOTAL CLIENT -->
        <div class="col-md-3">
            <div class="card card-flush h-md-100 bg-light-primary border-start border-primary border-4">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2"><?= $stats->total_clients ?></span>
                        <span class="text-gray-500 pt-1 fw-semibold fs-6">Perusahaan Mitra</span>
                    </div>
                </div>
                <div class="card-body d-flex align-items-end pt-0">
                    <div class="text-muted fs-8 fw-bold">Terdaftar di database</div>
                </div>
            </div>
        </div>

    <?php else : ?>
        <!-- CARD CLIENT 1: MY ACTIVE TICKETS -->
        <div class="col-md-4">
            <div class="card card-flush h-md-100 bg-primary">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column text-white">
                        <span class="fs-2hx fw-bold me-2 lh-1 ls-n2"><?= $stats->my_open ?></span>
                        <span class="opacity-75 pt-1 fw-semibold fs-6">Tiket Sedang Kami Tangani</span>
                    </div>
                </div>
                <div class="card-body d-flex align-items-end pt-0">
                    <a href="<?= base_url('client/tickets') ?>" class="btn btn-sm btn-light-primary fw-bold">Cek Progres</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- CARD UMUM: TOTAL TICKETS -->
    <div class="col-md-3">
        <div class="card card-flush h-md-100 bg-gray-900">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column text-white">
                    <span class="fs-2hx fw-bold me-2 lh-1 ls-n2"><?= $stats->total_tickets ?></span>
                    <span class="opacity-50 pt-1 fw-semibold fs-6">Total Record History</span>
                </div>
            </div>
            <div class="card-body d-flex align-items-end pt-0">
                <div class="text-success fw-bold fs-8"><i class="bi bi-shield-check text-success me-1"></i> Data Secure & Cloud Synced</div>
            </div>
        </div>
    </div>
</div>

<!--begin::Tabel Tiket Terbaru-->
<div class="card card-flush shadow-sm border-0">
    <div class="card-header border-0 pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900 fs-3">Tiket Masuk Terbaru</span>
            <span class="text-muted mt-1 fw-semibold fs-7">Pantau update terbaru dari mitra perusahaan</span>
        </h3>
        <div class="card-toolbar">
            <a href="<?= base_url('tickets') ?>" class="btn btn-sm btn-light-primary fw-bold">
                <i class="bi bi-list-task me-1"></i> Lihat Semua Antrean
            </a>
        </div>
    </div>
    <div class="card-body pt-2">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th class="ps-4 min-w-300px rounded-start">Informasi Kendala</th>
                        <th class="min-w-150px">Pelapor & Perusahaan</th>
                        <th class="min-w-120px">Prioritas</th>
                        <th class="min-w-100px text-end pe-4 rounded-end">Status Operasional</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($recent_tickets)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-10">Belum ada laporan yang masuk.</td></tr>
                    <?php endif; ?>

                    <?php foreach($recent_tickets as $ticket): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px me-5">
                                    <span class="symbol-label bg-light-primary text-primary fw-bold">#<?= $ticket['id'] ?></span>
                                </div>
                                <div class="d-flex justify-content-start flex-column">
                                    <a href="<?= base_url('tickets/show/'.$ticket['id']) ?>" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6"><?= esc($ticket['subject']) ?></a>
                                    <span class="text-muted fw-semibold d-block fs-8"><?= date('d M Y, H:i', strtotime($ticket['created_at'])) ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 fw-bold fs-7"><?= $ticket['client_name'] ?></span>
                                <span class="badge badge-light-secondary fs-8 fw-semibold w-fit"><?= $ticket['company_name'] ?? 'Individual' ?></span>
                            </div>
                        </td>
                        <td>
                            <?php 
                                $p_class = match($ticket['priority_name']) {
                                    'Urgent' => 'badge-danger',
                                    'High'   => 'badge-light-warning text-warning',
                                    default  => 'badge-light-primary text-primary'
                                };
                            ?>
                            <span class="badge <?= $p_class ?> fw-bold"><?= $ticket['priority_name'] ?? 'Pending' ?></span>
                        </td>
                        <td class="text-end pe-4">
                            <?php if ($ticket['closed_at'] != null) : ?>
                                <span class="badge badge-light-danger fw-bolder px-4 py-3">CLOSED</span>
                            <?php elseif (empty($ticket['triaged_at'])) : ?>
                                <span class="badge badge-warning fw-bolder px-4 py-3 animate-pulse">WAIT TRIAGE</span>
                            <?php else : ?>
                                <span class="badge badge-primary fw-bolder px-4 py-3">IN PROGRESS</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--end::Tabel Tiket Terbaru-->
<?= $this->endSection() ?>