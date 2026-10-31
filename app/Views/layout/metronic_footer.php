<footer id="kt_app_footer" class="app-footer py-6 border-top bg-white">
    <div class="app-container container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        
        <!-- Copyright & Site Name -->
        <div class="text-gray-900 order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">© <?= date('Y') ?></span>
            <a href="<?= base_url() ?>" class="text-gray-800 text-hover-primary fw-bold"><?= $app->site_name ?? 'DeskPoint' ?></a>
        </div>

        <!-- Contact Links -->
        <div class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            
            <!-- Lokasi/Alamat (Baru Ditambahkan) -->
            <div class="menu-item px-3">
                <span class="menu-link px-2 cursor-default">
                    <i class="bi bi-geo-alt-fill text-danger me-2"></i> <?= $app->contact_address ?? 'Jakarta, Indonesia' ?>
                </span>
            </div>

            <!-- Link Email dengan Icon -->
            <div class="menu-item px-3">
                <a href="mailto:<?= $app->contact_email ?? 'support@deskpoint.com' ?>" class="menu-link px-2">
                    <i class="bi bi-envelope-fill text-primary me-2"></i> Support
                </a>
            </div>

            <!-- Nomor Telepon -->
            <div class="menu-item px-3">
                <span class="menu-link px-2 cursor-default">
                    <i class="bi bi-telephone-fill text-success me-2"></i> <?= $app->contact_phone ?? '-' ?>
                </span>
            </div>

            <!-- Privacy Policy -->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-2">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>