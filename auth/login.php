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
$flash = get_flash();

// Cek reason=banned di URL
$bannedMsg = '';
if (isset($_GET['reason']) && $_GET['reason'] === 'banned') {
    $bannedMsg = 'Akun kamu telah dinonaktifkan secara permanen.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $errors['general'] = 'Permintaan tidak valid. Silakan coba lagi.';
    } else {
        $result = handle_login($userRepo);
        if ($result['success']) {
            // Redirect berdasarkan role
            $role = $result['user']['role'];
            if ($role === 'superadmin') {
                redirect(BASE_URL . '/admin/');
            } elseif ($role === 'moderator') {
                redirect(BASE_URL . '/moderator/reports.php');
            } else {
                redirect(BASE_URL . '/');
            }
        } else {
            $errors = $result['errors'];
            $old = ['identifier' => trim($_POST['identifier'] ?? '')];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForIT — Login</title>
    <meta name="description" content="Login ke ForIT dan bergabung dengan diskusi teknologi informasi bersama komunitas.">
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
        <h1>Selamat Datang Kembali</h1>
        <p class="auth-subtitle">Masuk ke akun ForIT kamu</p>

        <!-- Flash message sukses (dari registrasi) -->
        <?php if ($flash && $flash['type'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?= e($flash['message']) ?>
            </div>
        <?php endif; ?>

        <!-- Alert banned -->
        <?php if ($bannedMsg): ?>
            <div class="alert alert-error" role="alert">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                <?= e($bannedMsg) ?>
            </div>
        <?php endif; ?>

        <!-- Alert error umum -->
        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-error" role="alert">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <?= e($errors['general']) ?>
            </div>
        <?php endif; ?>

        <!-- Flash error -->
        <?php if ($flash && $flash['type'] === 'error'): ?>
            <div class="alert alert-error" role="alert">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                <?= e($flash['message']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" novalidate>
            <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">

            <!-- Email / Username -->
            <div class="form-group">
                <label for="identifier">Email atau Username</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input type="text" id="identifier" name="identifier"
                           placeholder="email@kamu.com atau username"
                           value="<?= e($old['identifier'] ?? '') ?>"
                           class="<?= isset($errors['identifier']) ? 'is-invalid' : '' ?>"
                           autocomplete="username"
                           autofocus>
                </div>
                <?php if (isset($errors['identifier'])): ?>
                    <div class="error-message"><?= e($errors['identifier']) ?></div>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password" name="password"
                           placeholder="Password kamu"
                           class="<?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                           autocomplete="current-password">
                </div>
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message"><?= e($errors['password']) ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-auth" id="btn-login">
                Masuk ke ForIT
            </button>
        </form>

        <div class="auth-footer">
            Belum punya akun?
            <a href="<?= BASE_URL ?>/auth/register.php">Daftar sekarang</a>
        </div>
    </div>
</div>

</body>
</html>
