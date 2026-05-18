<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Hapus semua data session
session_unset();
session_destroy();

// Set flash dan redirect
// Karena session sudah destroy, kita start ulang untuk flash
session_start();
set_flash('success', 'Kamu berhasil keluar dari akun.');

redirect(BASE_URL . '/auth/login.php');
