<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../controllers/AuthController.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect jika sudah login
if (is_logged_in()) {
    redirect(BASE_URL . '/');
}

$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $errors['general'] = 'Permintaan tidak valid. Silakan coba lagi.';
    } else {
        $result = handle_register($userRepo);
        if ($result['success']) {
            set_flash('success', 'Registrasi berhasil! Silakan login dengan akun kamu.');
            redirect(BASE_URL . '/auth/login.php');
        } else {
            $errors = $result['errors'];
            $old = [
                'fullname' => trim($_POST['fullname'] ?? ''),
                'username' => trim($_POST['username'] ?? ''),
                'email'    => trim($_POST['email'] ?? ''),
            ];
        }
    }
}

$pageCSS = ['auth.css'];
$title = 'Daftar Akun';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForIT — Daftar Akun</title>
    <meta name="description" content="Buat akun ForIT dan bergabung dengan komunitas diskusi IT terbesar di Indonesia.">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/auth.css">
</head>
<body class="auth-page">

<div class="auth-container">
    <!-- Brand -->
    <div class="auth-brand">
        <a href="<?= BASE_URL ?>/" style="text-decoration:none;">
            <div class="auth-brand-logo">F</div>
            <h2>ForIT</h2>
        </a>
        <p>Forum Diskusi Teknologi Informasi</p>
    </div>

    <div class="auth-card">
        <h1>Buat Akun Baru</h1>
        <p class="auth-subtitle">Bergabunglah dengan ribuan member komunitas ForIT</p>

        <!-- Alert pesan error umum -->
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-error" role="alert">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <?= e($errors['general']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" novalidate>
            <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">

            <!-- Nama Lengkap -->
            <div class="form-group">
                <label for="fullname">Nama Lengkap</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input type="text" id="fullname" name="fullname"
                           placeholder="Nama lengkap kamu"
                           value="<?= e($old['fullname'] ?? '') ?>"
                           class="<?= isset($errors['fullname']) ? 'is-invalid' : '' ?>"
                           autocomplete="name">
                </div>
                <?php if (isset($errors['fullname'])): ?>
                    <div class="error-message">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16" stroke="white" stroke-width="2"/><line x1="12" y1="17" x2="12" y2="17" stroke="white" stroke-width="2"/></svg>
                        <?= e($errors['fullname']) ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input type="text" id="username" name="username"
                           placeholder="username_kamu"
                           value="<?= e($old['username'] ?? '') ?>"
                           class="<?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                           autocomplete="username">
                </div>
                <?php if (isset($errors['username'])): ?>
                    <div class="error-message"><?= e($errors['username']) ?></div>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <input type="email" id="email" name="email"
                           placeholder="email@kamu.com"
                           value="<?= e($old['email'] ?? '') ?>"
                           class="<?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                           autocomplete="email">
                </div>
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?= e($errors['email']) ?></div>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" id="password" name="password"
                               placeholder="Min. 8 karakter"
                               class="<?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                               autocomplete="new-password">
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <div class="error-message"><?= e($errors['password']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Konfirmasi</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" id="password_confirm" name="password_confirm"
                               placeholder="Ulangi password"
                               class="<?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>"
                               autocomplete="new-password">
                    </div>
                    <?php if (isset($errors['password_confirm'])): ?>
                        <div class="error-message"><?= e($errors['password_confirm']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn-auth" id="btn-register">
                Buat Akun
            </button>
        </form>

        <div class="auth-footer">
            Sudah punya akun?
            <a href="<?= BASE_URL ?>/auth/login.php">Login di sini</a>
        </div>
    </div>
</div>

</body>
</html>
