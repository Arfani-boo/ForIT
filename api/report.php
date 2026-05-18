<?php
/**
 * API: Report Konten
 * POST /api/report.php
 * Body (form): { thread_id?, comment_id?, reason, csrf_token }
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../repositories/ReportRepository.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if (!is_logged_in()) {
    set_flash('error', 'Kamu harus login untuk melaporkan konten.');
    redirect(BASE_URL . '/auth/login.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
    set_flash('error', 'Permintaan tidak valid.');
    redirect(BASE_URL . '/');
}

$user      = auth_user();
$threadId  = trim($_POST['thread_id'] ?? '') ?: null;
$commentId = trim($_POST['comment_id'] ?? '') ?: null;
$reason    = trim($_POST['reason'] ?? '');

if (empty($reason)) {
    set_flash('error', 'Alasan laporan tidak boleh kosong.');
    $back = $threadId ? BASE_URL . '/thread.php?id=' . $threadId : BASE_URL . '/';
    redirect($back);
}

$reportRepo = new ReportRepository(DBH);
$reportRepo->create([
    'report_id'   => generate_ulid(),
    'thread_id'   => $threadId,
    'comment_id'  => $commentId,
    'reporter_id' => $user['user_id'],
    'reason'      => $reason,
]);

set_flash('success', 'Laporan kamu telah diterima. Terima kasih telah menjaga komunitas ForIT!');
$back = $threadId ? BASE_URL . '/thread.php?id=' . $threadId : BASE_URL . '/';
redirect($back);
