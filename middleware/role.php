<?php
/**
 * Middleware Role-Based Access Control
 * Gunakan setelah auth.php
 * Contoh: require_once __DIR__ . '/../middleware/role.php';
 * 
 * Set variabel $allowedRoles sebelum include:
 *   $allowedRoles = ['superadmin', 'moderator'];
 *   require_once __DIR__ . '/../middleware/role.php';
 */

require_once __DIR__ . '/../helpers.php';

if (!isset($allowedRoles)) {
    $allowedRoles = ['user', 'moderator', 'superadmin'];
}

if (!has_role(...$allowedRoles)) {
    set_flash('error', 'Kamu tidak memiliki akses ke halaman ini.');
    redirect(BASE_URL . '/');
}
