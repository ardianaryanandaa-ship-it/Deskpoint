<div id="kt_header" class="header align-items-stretch" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
    <div class="container-xxl d-flex flex-grow-1 flex-stack">
        <div class="d-flex align-items-center me-5">
            <div class="d-lg-none btn btn-icon btn-active-color-primary w-35px h-35px me-3" id="kt_header_menu_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
            <a href="<?= base_url() ?>" class="d-flex align-items-center">
                <div class="ms-3 d-none d-lg-block">
                    <div class="fs-5 fw-bold text-dark">DeskPoint</div>
                    <div class="text-muted fs-8">Helpdesk/Ticketing</div>
                </div>
            </a>
        </div>

        <div class="btn ms-auto me-3 btn-icon btn-color-gray-700 btn-active-color-primary btn-outline btn-active-bg-light w-30px h-30px w-lg-40px h-lg-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
			<i class="ki-duotone ki-user fs-1">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
        
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
            <!-- begin::Menu item (User Info) -->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <div class="symbol symbol-50px me-5">
                        <img alt="Logo" src="assets/media/avatars/300-1.jpg">
                    </div>
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5"><?= esc(session()->get('username') ?? 'Pengguna') ?>
                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"><?= esc(session()->get('role') ?? 'User') ?></span></div>
                        <a href="<?= base_url('account') ?>" class="fw-semibold text-muted text-hover-primary fs-7"><?= esc(session()->get('email') ?? '') ?></a>
                    </div>
                </div>
            </div>
            <!-- end::Menu item -->

            <div class="separator my-2"></div>

            <!-- begin::Menu item -->
            <div class="menu-item px-5">
                <a href="<?= base_url('account') ?>" class="menu-link px-5">
                    <span class="menu-icon me-3"><i class="ki-duotone ki-user-circle fs-3"></i></span>
                    <span class="menu-title">My Profile</span>
                </a>
            </div>
            <div class="menu-item px-5">
                <a href="<?= base_url('account') ?>" class="menu-link px-5">
                    <span class="menu-icon me-3"><i class="ki-duotone ki-settings fs-3"></i></span>
                    <span class="menu-title">Account Settings</span>
                </a>
            </div>
            <div class="menu-item px-5">
                <a href="<?= base_url('account') ?>" class="menu-link px-5">
                    <span class="menu-icon me-3"><i class="ki-duotone ki-lock fs-3"></i></span>
                    <span class="menu-title">Change Password</span>
                </a>
            </div>
            
            <div class="separator my-2"></div>

            <!-- begin::Sign Out -->
            <div class="menu-item px-5">
                <a href="<?= base_url('logout') ?>" class="menu-link px-5 text-danger">
                    <span class="menu-icon me-3"><i class="ki-duotone ki-sign-out fs-3"></i></span>
                    <span class="menu-title">Sign Out</span>
                </a>
            </div>
            <!-- end::Sign Out -->
        </div>
    </div>
    <!-- END WRAPPER DROPDOWN -->

    <div class="separator"></div>
    <div class="header-menu-container container-xxl d-flex flex-stack h-lg-75px w-100" id="kt_header_nav">
        <div class="header-menu flex-column flex-lg-row" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-state-primary menu-title-gray-800 menu-arrow-gray-500 align-items-stretch flex-grow-1 my-5 my-lg-0 px-2 px-lg-0 fw-semibold fs-6" data-kt-menu="true">
                
                <!-- Dashboard -->
                <div class="menu-item me-0 me-lg-2">
                    <a class="menu-link py-3 <?= url_is('dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                <!-- Tickets -->
                <!-- Menu Tickets Dropdown -->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2">
                    
                    <!-- Judul Utama di Navbar -->
                    <span class="menu-link py-3 <?= (url_is('tickets*') || url_is('client/report*')) ? 'active' : '' ?>">
                        <span class="menu-title">Tickets</span>
                        <span class="menu-arrow"></span> <!-- Panah Dropdown -->
                    </span>

                    <!-- Isi Dropdown -->
                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                        
                        <!-- Menu 1: Manajemen Tiket (View Develop/Table) -->
                        <div class="menu-item px-3">
                            <a class="menu-link py-3 <?= url_is('tickets') ? 'active' : '' ?>" href="<?= base_url('tickets') ?>">
                                <span class="menu-icon">
                                    <i class="bi bi-list-ul fs-3"></i>
                                </span>
                                <span class="menu-title">Semua Tiket</span>
                            </a>
                        </div>

                        <!-- Menu 2: Form Tambah Tiket (View Client/Report) -->
                        <div class="menu-item px-3">
                            <a class="menu-link py-3 <?= url_is('client/report*') ? 'active' : '' ?>" href="<?= base_url('client/report') ?>">
                                <span class="menu-icon">
                                    <i class="bi bi-plus-square fs-3"></i>
                                </span>
                                <span class="menu-title">Buat Tiket Baru</span>
                            </a>
                        </div>

                    </div>
                </div>
                
                <?php if (session()->get('role_name') === 'develop') : ?>
                    <!-- Companies -->
                    <!-- Dropdown Master Data -->
                    <?php 
                        // Logika agar parent menu otomatis aktif jika salah satu isinya sedang dibuka
                        $isMasterActive = url_is('companies*') || url_is('categories*') || url_is('sla*'); 
                    ?>
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2 <?= $isMasterActive ? 'here show' : '' ?>">
                        
                        <!-- Label Utama Dropdown -->
                        <span class="menu-link py-3">
                            <span class="menu-title">Master Data</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span>

                        <!-- Isi Menu Dropdown -->
                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                            
                            <!-- Menu Companies -->
                            <div class="menu-item px-3">
                                <a class="menu-link py-3 <?= url_is('companies*') ? 'active' : '' ?>" href="<?= base_url('companies') ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-building fs-3"></i>
                                    </span>
                                    <span class="menu-title">Companies</span>
                                </a>
                            </div>

                            <!-- Menu Categories -->
                            <div class="menu-item px-3">
                                <a class="menu-link py-3 <?= url_is('categories*') ? 'active' : '' ?>" href="<?= base_url('categories') ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-grid fs-3"></i>
                                    </span>
                                    <span class="menu-title">Categories</span>
                                </a>
                            </div>

                            <!-- Menu Triage SLA -->
                            <div class="menu-item px-3">
                                <a class="menu-link py-3 <?= url_is('sla*') ? 'active' : '' ?>" href="<?= base_url('sla') ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-clock-history fs-3"></i>
                                    </span>
                                    <span class="menu-title">Triage SLA</span>
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="menu-item me-0 me-lg-2">
                        <a class="menu-link py-3 <?= url_is('knowledge*') ? 'active' : '' ?>" href="<?= base_url('knowledge') ?>">
                            <span class="menu-title">Knowledge Base</span>
                        </a>
                    </div>

                    <!-- Dropdown Administrator -->
                    <?php 
                        // Logika: Jika sedang di halaman users atau settings, dropdown "Administrator" akan ditandai aktif
                        $isAdminActive = url_is('users*') || url_is('settings*'); 
                    ?>
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2 <?= $isAdminActive ? 'here show' : '' ?>">
                        
                        <!-- Label Utama di Navbar -->
                        <span class="menu-link py-3 <?= $isAdminActive ? 'active' : '' ?>">
                            <span class="menu-title">Administrator</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span>

                        <!-- Isi Menu Dropdown -->
                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                            
                            <!-- 1. Menu User Management -->
                            <div class="menu-item">
                                <a class="menu-link py-3 <?= url_is('users*') ? 'active' : '' ?>" href="<?= base_url('users') ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-people fs-3"></i>
                                    </span>
                                    <span class="menu-title">User Management</span>
                                </a>
                            </div>

                            <!-- 2. Menu Settings -->
                            <div class="menu-item">
                                <a class="menu-link py-3 <?= url_is('settings*') ? 'active' : '' ?>" href="<?= base_url('settings') ?>">
                                    <span class="menu-icon">
                                        <i class="bi bi-gear fs-3"></i>
                                    </span>
                                    <span class="menu-title">Settings</span>
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
