<?php
/**
 * Middleware Autentikasi
 * Gunakan di awal halaman yang memerlukan login
 * Contoh: require_once __DIR__ . '/../middleware/auth.php';
 */

require_once __DIR__ . '/../helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!is_logged_in()) {
    set_flash('error', 'Kamu harus login terlebih dahulu untuk mengakses halaman ini.');
    redirect(BASE_URL . '/auth/login.php');
}

// Cek jika akun di-banned
if (isset($_SESSION['status']) && $_SESSION['status'] === 'banned') {
    session_destroy();
    redirect(BASE_URL . '/auth/login.php?reason=banned');
}
