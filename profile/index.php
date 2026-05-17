<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/ThreadRepository.php';
require_once __DIR__ . '/../repositories/BookmarkRepository.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$username = trim($_GET['u'] ?? '');
$tab      = trim($_GET['tab'] ?? 'threads');

if (empty($username)) redirect(BASE_URL . '/');

$userRepo     = new UserRepository(DBH);
$threadRepo   = new ThreadRepository(DBH);
$bookmarkRepo = new BookmarkRepository(DBH);

$profileUser  = $userRepo->findByUsername($username);
if (!$profileUser) {
    set_flash('error', 'Pengguna tidak ditemukan.');
    redirect(BASE_URL . '/');
}

$threads   = $threadRepo->getByUser($profileUser['user_id']);
$bookmarks = ($tab === 'bookmark') ? $bookmarkRepo->getByUser($profileUser['user_id']) : [];
$authUser  = auth_user();
$isOwnProfile = $authUser && $authUser['user_id'] === $profileUser['user_id'];

$pageCSS = ['homepage.css'];
$title   = e($profileUser['fullname']) . ' — Profil';
?>
<!DOCTYPE html>
<html lang="id">
<?php include_once __DIR__ . '/../components/metadata.php'; ?>
<style>
.profile-page { max-width: 900px; margin: 0 auto; padding: 0 1.5rem; }
.profile-card {
    background: white;
    border: 1px solid var(--gray-200, #e5e7eb);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.profile-header { display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap; }
.profile-big-avatar {
    width: 5rem;
    height: 5rem;
    border-radius: 50%;
    background: linear-gradient(135deg, #155DFC, #6366f1);
    color: white;
    font-size: 2rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(21,93,252,0.3);
}
.profile-info h1 { font-size: 1.5rem; margin-bottom: 0.25rem; }
.profile-username { color: var(--gray-400,#9ca3af); font-size:0.9rem; }
.profile-meta { display:flex; gap:1.5rem; margin-top:1rem; flex-wrap:wrap; }
.profile-meta-item { font-size:0.875rem; color:var(--gray-500,#6b7280); }
.profile-meta-item strong { color:var(--gray-800,#1f2937); font-size:1.125rem; display:block; }
.profile-role-badge { display:inline-block;padding:0.2rem 0.75rem;border-radius:50px;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-left:0.5rem; }
.role-user { background:#eff6ff;color:#155DFC; }
.role-moderator { background:#fef3c7;color:#d97706; }
.role-superadmin { background:#fdf4ff;color:#9333ea; }

.profile-tabs { display:flex;gap:0;border-bottom:2px solid var(--gray-200,#e5e7eb);margin-bottom:1.5rem; }
.profile-tab {
    padding: 0.75rem 1.25rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--gray-500,#6b7280);
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    text-decoration: none;
    transition: color 0.15s;
}
.profile-tab.active { color: #155DFC; border-bottom-color: #155DFC; }
.profile-tab:hover { color: var(--gray-700,#374151); }
</style>
<body style="background:var(--gray-50,#f9fafb);">
    <?php include_once __DIR__ . '/../components/navbar.php'; ?>

    <main style="padding-top:2rem;padding-bottom:3rem;">
        <div class="profile-page">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-big-avatar">
                        <?= e(mb_strtoupper(mb_substr($profileUser['fullname'], 0, 1))) ?>
                    </div>
                    <div class="profile-info">
                        <h1>
                            <?= e($profileUser['fullname']) ?>
                            <span class="profile-role-badge role-<?= e($profileUser['role']) ?>">
                                <?= match($profileUser['role']) {
                                    'superadmin' => 'Super Admin',
                                    'moderator'  => 'Moderator',
                                    default      => 'Member',
                                } ?>
                            </span>
                        </h1>
                        <div class="profile-username">@<?= e($profileUser['username']) ?></div>

                        <div class="profile-meta">
                            <div class="profile-meta-item">
                                <strong><?= count($threads) ?></strong>
                                Thread
                            </div>
                            <div class="profile-meta-item">
                                <strong><?= date('M Y', strtotime($profileUser['created_at'])) ?></strong>
                                Bergabung
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="profile-tabs">
                <a href="?u=<?= e($username) ?>&tab=threads" class="profile-tab <?= $tab === 'threads' ? 'active' : '' ?>">
                    📝 Thread (<?= count($threads) ?>)
                </a>
                <?php if ($isOwnProfile): ?>
                    <a href="?u=<?= e($username) ?>&tab=bookmark" class="profile-tab <?= $tab === 'bookmark' ? 'active' : '' ?>">
                        🔖 Bookmark
                    </a>
                <?php endif; ?>
            </div>

            <!-- Thread List -->
            <?php if ($tab === 'threads'): ?>
                <?php if (empty($threads)): ?>
                    <div class="empty-state">
                        <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <h3>Belum ada thread</h3>
                        <p><?= $isOwnProfile ? 'Kamu belum membuat thread apapun.' : 'Pengguna ini belum membuat thread apapun.' ?></p>
                        <?php if ($isOwnProfile): ?>
                            <a href="<?= BASE_URL ?>/forum/create-thread.php" class="btn btn-primary">Buat Thread Pertama</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="thread-list">
                        <?php foreach ($threads as $t): ?>
                            <article class="thread-card">
                                <div class="thread-card-body">
                                    <h2 class="thread-card-title">
                                        <a href="<?= BASE_URL ?>/thread.php?id=<?= e($t['thread_id']) ?>">
                                            <?= e($t['thread_title']) ?>
                                        </a>
                                    </h2>
                                    <p class="thread-card-excerpt"><?= e(truncate(strip_tags($t['thread_description']), 160)) ?></p>
                                </div>
                                <div class="thread-card-footer">
                                    <div class="thread-stats">
                                        <span class="thread-stat">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                            <?= (int)($t['comment_count'] ?? 0) ?> komentar
                                        </span>
                                        <span class="thread-stat"><?= time_ago($t['created_at']) ?></span>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php elseif ($tab === 'bookmark' && $isOwnProfile): ?>
                <?php if (empty($bookmarks)): ?>
                    <div class="empty-state">
                        <h3>Belum ada bookmark</h3>
                        <p>Simpan thread menarik untuk dibaca nanti.</p>
                    </div>
                <?php else: ?>
                    <div class="thread-list">
                        <?php foreach ($bookmarks as $b): ?>
                            <article class="thread-card">
                                <div class="thread-card-body">
                                    <h2 class="thread-card-title">
                                        <a href="<?= BASE_URL ?>/thread.php?id=<?= e($b['thread_id']) ?>">
                                            <?= e($b['thread_title']) ?>
                                        </a>
                                    </h2>
                                    <p class="thread-card-excerpt"><?= e(truncate(strip_tags($b['thread_description']), 160)) ?></p>
                                </div>
                                <div class="thread-card-footer">
                                    <div class="thread-stats">
                                        <span class="thread-stat">
                                            oleh <?= e($b['author_username']) ?>
                                        </span>
                                        <span class="thread-stat"><?= time_ago($b['bookmarked_at']) ?></span>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
