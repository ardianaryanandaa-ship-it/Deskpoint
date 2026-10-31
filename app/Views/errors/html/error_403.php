<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>403 - Akses Ditolak</title>
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #444;
            background: #fafafa;
            margin: 0;
        }
        .container {
            max-width: 720px;
            margin: 8rem auto;
            padding: 2rem;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 0.75rem;
            text-align: center;
        }
        h1 { font-size: 4rem; margin: 0 0 0.5rem; }
        p { font-size: 1.1rem; color: #666; }
        a { color: #1e88e5; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>403</h1>
        <p><?= isset($message) ? esc($message) : 'Anda tidak memiliki izin untuk mengakses halaman ini.' ?></p>
        <p><a href="<?= base_url('/') ?>">Kembali ke dashboard</a></p>
    </div>
</body>
</html>
