<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title ?? 'Metronic' ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.ico') ?>" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
    
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>

<body id="kt_body" class="auth-bg">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            
            <!--begin::Logo (Mobile only)-->
            <a href="/" class="d-block d-lg-none mx-auto py-20">
                <img alt="Logo" src="<?= base_url('assets/media/logos/default.svg') ?>" class="theme-light-show h-25px" />
            </a>
            
            <!--begin::Aside (Left Side / Form Container)-->
            <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
                <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                    
                    <!--begin::Header-->
                    <div class="d-flex flex-stack py-2">
                        <div class="me-2"></div>
                        <div class="m-0">
                            <span class="text-gray-500 fw-bold fs-5 me-2">Not a Member yet?</span>
                            <a href="<?= base_url('register') ?>" class="link-primary fw-bold fs-5">Sign Up</a>
                        </div>
                    </div>
                    
                    <!--begin::Body (Form Content)-->
                    <div class="py-20">
                        <?= $this->renderSection('content') ?>
                    </div>
                    
                    <!--begin::Footer-->
                    <div class="m-0">
                        <button class="btn btn-flex btn-link rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                            <img class="w-25px h-25px rounded-circle me-3" src="<?= base_url('assets/media/flags/united-states.svg') ?>" alt="" />
                            <span class="me-2">English</span>
                            <i class="ki-duotone ki-down fs-2 text-muted m-0"></i>
                        </button>
                        <!-- Menu bahasa bisa ditambahkan di sini sesuai template asli jika perlu -->
                    </div>
                </div>
            </div>

            <!--begin::Body (Right Side / Image)-->
            <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat" 
                 style="background-image: url(<?= base_url('assets/media/auth/bg11.png') ?>)">
            </div>
        </div>
    </div>

    <!--begin::Global Javascript Bundle-->
    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
    <?= $this->renderSection('js') ?>
</body>
</html>