<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

$allowedRoles = ['user', 'moderator', 'superadmin'];
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../middleware/role.php';

require_once __DIR__ . '/../controllers/ThreadController.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$user = auth_user();

$threadId = trim($_GET['id'] ?? '');
if (empty($threadId)) redirect(BASE_URL . '/');

$thread = $threadRepo->findById($threadId);
if (!$thread) {
    set_flash('error', 'Thread tidak ditemukan.');
    redirect(BASE_URL . '/');
}

// Cek kepemilikan
if ($thread['author_id'] !== $user['user_id'] && !has_role('moderator', 'superadmin')) {
    set_flash('error', 'Kamu tidak memiliki akses untuk mengedit thread ini.');
    redirect(BASE_URL . '/thread.php?id=' . $threadId);
}

$errors  = [];
$currentTopics = $topicRepo->getByThread($threadId);
$currentTopicIds = array_column($currentTopics, 'topic_id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $errors['general'] = 'Permintaan tidak valid.';
    } else {
        $result = handle_update_thread($threadRepo, $topicRepo, $threadId, $user);
        if ($result['success']) {
            set_flash('success', 'Thread berhasil diperbarui!');
            redirect(BASE_URL . '/thread.php?id=' . $threadId);
        } else {
            $errors = $result['errors'];
        }
    }
}

$topics  = $topicRepo->getAll();
$pageCSS = ['thread.css'];
$title   = 'Edit Thread';
?>
<!DOCTYPE html>
<html lang="id">
<?php include_once __DIR__ . '/../components/metadata.php'; ?>
<style>
.create-thread-page { max-width: 780px; margin: 0 auto; padding: 2rem; }
.create-thread-card { background:white;border:1px solid var(--gray-200,#e5e7eb);border-radius:20px;padding:2.5rem;box-shadow:0 4px 16px rgba(0,0,0,0.06); }
.create-thread-card h1 { font-size:1.5rem;margin-bottom:0.5rem; }
.create-thread-subtitle { color:var(--gray-500,#6b7280);font-size:0.875rem;margin-bottom:2rem; }
.form-group { margin-bottom:1.5rem; }
.form-group label { display:block;font-weight:600;font-size:0.875rem;color:var(--gray-700,#374151);margin-bottom:0.5rem; }
.form-group input[type="text"], .form-group textarea { width:100%;padding:0.75rem 1rem;border:1.5px solid var(--gray-200,#e5e7eb);border-radius:12px;font-family:inherit;font-size:0.9375rem;outline:none;transition:border-color 0.2s,box-shadow 0.2s;color:var(--gray-800,#1f2937);resize:vertical; }
.form-group input:focus, .form-group textarea:focus { border-color:#155DFC;box-shadow:0 0 0 3px rgba(21,93,252,0.12); }
.error-msg { color:#ef4444;font-size:0.8rem;margin-top:0.375rem; }
.topic-grid { display:flex;flex-wrap:wrap;gap:0.5rem; }
.topic-check { display:none; }
.topic-label { display:inline-block;padding:0.35rem 0.875rem;border:1.5px solid var(--gray-200,#e5e7eb);border-radius:50px;font-size:0.8125rem;font-weight:500;color:var(--gray-600,#4b5563);cursor:pointer;transition:all 0.15s; }
.topic-check:checked + .topic-label { background:#155DFC;border-color:#155DFC;color:white; }
.topic-label:hover { border-color:#155DFC;color:#155DFC; }
</style>
<body style="background:var(--gray-50,#f9fafb);">
    <?php include_once __DIR__ . '/../components/navbar.php'; ?>

    <main class="create-thread-page">
        <div class="create-thread-card">
            <h1>Edit Thread</h1>
            <p class="create-thread-subtitle">Perbarui konten thread kamu</p>

            <?php if (!empty($errors['general'])): ?>
                <div class="flash-message flash-error"><?= e($errors['general']) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">

                <div class="form-group">
                    <label for="thread_title">Judul Thread <span style="color:#ef4444">*</span></label>
                    <input type="text" id="thread_title" name="thread_title"
                           value="<?= e($_POST['thread_title'] ?? $thread['thread_title']) ?>"
                           maxlength="100"
                           class="<?= isset($errors['thread_title']) ? 'is-invalid' : '' ?>">
                    <?php if (isset($errors['thread_title'])): ?>
                        <div class="error-msg"><?= e($errors['thread_title']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Topik (opsional)</label>
                    <div class="topic-grid">
                        <?php
                        $selectedTopics = $_POST['topic_ids'] ?? $currentTopicIds;
                        foreach ($topics as $topic): ?>
                            <input type="checkbox"
                                id="topic-<?= e($topic['topic_id']) ?>"
                                name="topic_ids[]"
                                value="<?= e($topic['topic_id']) ?>"
                                class="topic-check"
                                <?= in_array($topic['topic_id'], $selectedTopics) ? 'checked' : '' ?>>
                            <label for="topic-<?= e($topic['topic_id']) ?>" class="topic-label">
                                <?= e($topic['topic_name']) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="thread_description">Konten Thread <span style="color:#ef4444">*</span></label>
                    <textarea id="thread_description" name="thread_description" rows="14"
                              class="<?= isset($errors['thread_description']) ? 'is-invalid' : '' ?>"><?= e($_POST['thread_description'] ?? $thread['thread_description']) ?></textarea>
                    <?php if (isset($errors['thread_description'])): ?>
                        <div class="error-msg"><?= e($errors['thread_description']) ?></div>
                    <?php endif; ?>
                </div>

                <div style="display:flex;gap:0.75rem;justify-content:flex-end;">
                    <a href="<?= BASE_URL ?>/thread.php?id=<?= e($threadId) ?>" class="btn btn-ghost btn-primary">Batal</a>
                    <button type="submit" class="btn btn-primary" id="btn-update-thread">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <?php include_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
