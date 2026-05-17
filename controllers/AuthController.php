<?php
/**
 * AuthController — Logika registrasi, login, dan logout
 */

require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

$userRepo = new UserRepository(DBH);

/**
 * Handle registrasi user baru
 */
function handle_register(UserRepository $repo): array
{
    $errors = [];

    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['password_confirm'] ?? '';

    // Validasi
    if (empty($fullname)) $errors['fullname'] = 'Nama lengkap wajib diisi.';
    if (empty($username)) {
        $errors['username'] = 'Username wajib diisi.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $errors['username'] = 'Username hanya boleh mengandung huruf, angka, dan underscore (3–20 karakter).';
    }
    if (empty($email)) {
        $errors['email'] = 'Email wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid.';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Password minimal 8 karakter.';
    }
    if ($password !== $confirm) {
        $errors['password_confirm'] = 'Konfirmasi password tidak cocok.';
    }

    if (empty($errors)) {
        if ($repo->emailExists($email)) {
            $errors['email'] = 'Email sudah digunakan.';
        }
        if ($repo->usernameExists($username)) {
            $errors['username'] = 'Username sudah digunakan.';
        }
    }

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    // Simpan user baru
    $success = $repo->create([
        'user_id'  => generate_ulid(),
        'username' => $username,
        'email'    => $email,
        'fullname' => $fullname,
        'password' => password_hash($password, PASSWORD_BCRYPT),
    ]);

    if (!$success) {
        return ['success' => false, 'errors' => ['general' => 'Terjadi kesalahan. Silakan coba lagi.']];
    }

    return ['success' => true];
}

/**
 * Handle proses login
 */
function handle_login(UserRepository $repo): array
{
    $identifier = trim($_POST['identifier'] ?? '');
    $password   = $_POST['password'] ?? '';
    $errors     = [];

    if (empty($identifier)) $errors['identifier'] = 'Email atau username wajib diisi.';
    if (empty($password))   $errors['password']   = 'Password wajib diisi.';

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    $user = $repo->findByEmailOrUsername($identifier);

    if (!$user || !password_verify($password, $user['password'])) {
        return ['success' => false, 'errors' => ['general' => 'Email/username atau password salah.']];
    }

    if ($user['status'] === 'banned') {
        return ['success' => false, 'errors' => ['general' => 'Akun kamu telah dinonaktifkan secara permanen.']];
    }

    // Set session
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['user_id']  = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['fullname'] = $user['fullname'];
    $_SESSION['role']     = $user['role'];
    $_SESSION['status']   = $user['status'];

    return ['success' => true, 'user' => $user];
}
