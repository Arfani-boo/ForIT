<?php
/**
 * API: Bookmark Toggle
 * POST /api/bookmark.php
 * Body (JSON): { thread_id, csrf_token }
 * Response (JSON): { bookmarked: bool }
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../repositories/BookmarkRepository.php';

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (!is_logged_in()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthenticated']);
    exit;
}

$body     = json_decode(file_get_contents('php://input'), true);
$threadId = trim($body['thread_id'] ?? '');
$token    = $body['csrf_token'] ?? '';

// Verifikasi CSRF (manual karena JSON body)
if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

if (empty($threadId)) {
    http_response_code(400);
    echo json_encode(['error' => 'thread_id required']);
    exit;
}

$user   = auth_user();
$repo   = new BookmarkRepository(DBH);
$exists = $repo->exists($user['user_id'], $threadId);

if ($exists) {
    $repo->remove($user['user_id'], $threadId);
    echo json_encode(['bookmarked' => false]);
} else {
    $repo->add(generate_ulid(), $user['user_id'], $threadId);
    echo json_encode(['bookmarked' => true]);
}
