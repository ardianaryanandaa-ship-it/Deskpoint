<?= $this->extend('layout/auth_metronic') ?>

<?= $this->section('content') ?>

<!-- Form Login -->
<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="<?= base_url('login') ?>" method="POST">
    <?= csrf_field() ?>
    
    <div class="text-center mb-11">
        <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
        <div class="text-gray-500 fw-semibold fs-6">Silakan masuk ke akun Anda</div>
    </div>

    <!-- Alert Flashdata -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
            <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4"></i>
            <div class="d-flex flex-column">
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success d-flex align-items-center p-5 mb-10">
            <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"></i>
            <div class="d-flex flex-column">
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Input Email -->
    <div class="fv-row mb-8">
        <input type="email" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" value="<?= old('email') ?>" required />
    </div>

    <!-- Input Password -->
    <div class="fv-row mb-3">
        <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" required />
    </div>

    <!-- Lupa Password -->
    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
        <div></div>
        <a href="#" class="link-primary">Forgot Password?</a>
    </div>

    <!-- Tombol Submit -->
    <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
            <span class="indicator-label">Sign In</span>
            <span class="indicator-progress">Please wait... 
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>

    <!-- Sign Up -->
    <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet? 
    <a href="<?= base_url('register') ?>" class="link-primary">Sign up</a></div>
</form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    // Logika animasi tombol saat diklik
    const form = document.getElementById('kt_sign_in_form');
    const submitButton = document.getElementById('kt_sign_in_submit');

    form.addEventListener('submit', function() {
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
    });
</script>
<?= $this->endSection() ?>