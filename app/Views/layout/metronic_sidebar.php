<aside id="kt_app_sidebar" class="app-sidebar app-sidebar-fixed w-250px w-lg-250px flex-column bg-white border-end"
    data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="250px" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_header_menu_toggle">

    <!-- Brand Logo -->
    <div class="app-sidebar-logo d-flex align-items-center px-6 py-5 border-bottom">
        <a href="<?= base_url() ?>" class="d-flex align-items-center text-decoration-none">
            <div class="symbol symbol-40px symbol-circle bg-light-primary me-3">
                <span class="symbol-label">
                    <i class="ki-duotone ki-abstract-13 fs-2 text-primary"></i>
                </span>
            </div>
            <div class="ms-2">
                <div class="fs-5 fw-bolder text-gray-900"><?= $app->site_name ?? 'DeskPoint' ?></div>
                <div class="fs-8 fw-semibold text-gray-500">Ticketing System</div>
            </div>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid px-3 py-5">
        <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold" id="kt_app_sidebar_menu" data-kt-menu="true">

            <!-- --- MENU UMUM (SEMUA USER) --- -->
            
            <!-- Dashboard -->
            <div class="menu-item">
                <a href="<?= base_url('dashboard') ?>"
                    class="menu-link rounded-3 py-3 <?= url_is('dashboard') ? 'active bg-light-primary' : '' ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-home-2 fs-2 <?= url_is('dashboard') ? 'text-primary' : 'text-gray-500' ?>"></i>
                    </span>
                    <span class="menu-title <?= url_is('dashboard') ? 'text-primary fw-bold' : 'text-gray-700' ?>">
                        Dashboard
                    </span>
                </a>
            </div>

            <!-- Tickets -->
            <div class="menu-item">
                <a href="<?= base_url('tickets') ?>"
                    class="menu-link rounded-3 py-3 <?= url_is('tickets*') ? 'active bg-light-primary' : '' ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-ticket fs-2 <?= url_is('tickets*') ? 'text-primary' : 'text-gray-500' ?>"></i>
                    </span>
                    <span class="menu-title <?= url_is('tickets*') ? 'text-primary fw-bold' : 'text-gray-700' ?>">
                        Tickets
                    </span>
                </a>
            </div>

            <!-- --- MENU ADMINISTRATOR (DEVELOP ONLY) --- -->
            <?php if (session()->get('role_name') === 'develop') : ?>
                
                <div class="menu-item pt-7">
                    <div class="menu-content">
                        <div class="text-uppercase text-gray-400 fs-8 fw-bold">Master Data</div>
                    </div>
                </div>

                <!-- Companies -->
                <div class="menu-item">
                    <a href="<?= base_url('companies') ?>"
                        class="menu-link rounded-3 py-3 <?= url_is('companies*') ? 'active bg-light-primary' : '' ?>">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-bank fs-2 <?= url_is('companies*') ? 'text-primary' : 'text-gray-500' ?>"></i>
                        </span>
                        <span class="menu-title <?= url_is('companies*') ? 'text-primary fw-bold' : 'text-gray-700' ?>">
                            Companies
                        </span>
                    </a>
                </div>

                <!-- Categories -->
                <div class="menu-item">
                    <a href="<?= base_url('categories') ?>"
                        class="menu-link rounded-3 py-3 <?= url_is('categories*') ? 'active bg-light-primary' : '' ?>">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-category fs-2 <?= url_is('categories*') ? 'text-primary' : 'text-gray-500' ?>"></i>
                        </span>
                        <span class="menu-title <?= url_is('categories*') ? 'text-primary fw-bold' : 'text-gray-700' ?>">
                            Categories
                        </span>
                    </a>
                </div>

                <!-- SLA Management -->
                <div class="menu-item">
                    <a href="<?= base_url('sla') ?>"
                        class="menu-link rounded-3 py-3 <?= url_is('sla*') ? 'active bg-light-primary' : '' ?>">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-time fs-2 <?= url_is('sla*') ? 'text-primary' : 'text-gray-500' ?>"></i>
                        </span>
                        <span class="menu-title <?= url_is('sla*') ? 'text-primary fw-bold' : 'text-gray-700' ?>">
                            SLA Management
                        </span>
                    </a>
                </div>

                <!-- User Management -->
                <div class="menu-item">
                    <a href="<?= base_url('users') ?>"
                        class="menu-link rounded-3 py-3 <?= url_is('users*') ? 'active bg-light-primary' : '' ?>">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-people fs-2 <?= url_is('users*') ? 'text-primary' : 'text-gray-500' ?>"></i>
                        </span>
                        <span class="menu-title <?= url_is('users*') ? 'text-primary fw-bold' : 'text-gray-700' ?>">
                            User Management
                        </span>
                    </a>
                </div>

                <!-- Reports (Sesuai Routes Anda) -->
                <div class="menu-item">
                    <a href="<?= base_url('reports') ?>"
                        class="menu-link rounded-3 py-3 <?= url_is('reports') ? 'active bg-light-primary' : '' ?>">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-chart-line fs-2 <?= url_is('reports') ? 'text-primary' : 'text-gray-500' ?>"></i>
                        </span>
                        <span class="menu-title <?= url_is('reports') ? 'text-primary fw-bold' : 'text-gray-700' ?>">
                            Reports
                        </span>
                    </a>
                </div>

            <?php endif; ?>

            <!-- --- MENU PENGATURAN --- -->
            <div class="menu-item pt-7">
                <div class="menu-content">
                    <div class="text-uppercase text-gray-400 fs-8 fw-bold">Settings</div>
                </div>
            </div>

            <!-- Account -->
            <div class="menu-item">
                <a href="<?= base_url('account') ?>"
                    class="menu-link rounded-3 py-3 <?= url_is('account*') ? 'active bg-light-primary' : '' ?>">
                    <span class="menu-icon">
                        <i class="ki-duotone ki-user-square fs-2 <?= url_is('account*') ? 'text-primary' : 'text-gray-500' ?>"></i>
                    </span>
                    <span class="menu-title <?= url_is('account*') ? 'text-primary fw-bold' : 'text-gray-700' ?>">
                        My Profile
                    </span>
                </a>
            </div>

            <!-- Global Settings (Hanya Develop) -->
            <?php if (session()->get('role_name') === 'develop') : ?>
                <div class="menu-item">
                    <a href="<?= base_url('settings') ?>"
                        class="menu-link rounded-3 py-3 <?= url_is('settings*') ? 'active bg-light-primary' : '' ?>">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-setting-2 fs-2 <?= url_is('settings*') ? 'text-primary' : 'text-gray-500' ?>"></i>
                        </span>
                        <span class="menu-title <?= url_is('settings*') ? 'text-primary fw-bold' : 'text-gray-700' ?>">
                            Global Settings
                        </span>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Footer Logout -->
    <div class="app-sidebar-footer border-top px-5 py-5">
        <a href="<?= base_url('logout') ?>" class="btn btn-light-danger w-100 d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-box-arrow-right fs-3"></i>
            <span class="fw-bold">Sign Out</span>
        </a>
    </div>
</aside>