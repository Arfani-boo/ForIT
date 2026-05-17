<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

$allowedRoles = ['superadmin'];
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../middleware/role.php';

require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../repositories/TopicRepository.php';
require_once __DIR__ . '/../repositories/ReportRepository.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$user       = auth_user();
$topicRepo  = new TopicRepository(DBH);
$reportRepo = new ReportRepository(DBH);

// Handle aksi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $action  = $_POST['action'] ?? '';
    $topicId = trim($_POST['topic_id'] ?? '');
    $name    = trim($_POST['topic_name'] ?? '');

    switch ($action) {
        case 'create':
            if (!empty($name)) {
                $topicRepo->create(generate_ulid(), $name);
                set_flash('success', 'Topik "' . $name . '" berhasil dibuat.');
            } else {
                set_flash('error', 'Nama topik tidak boleh kosong.');
            }
            break;
        case 'update':
            if (!empty($topicId) && !empty($name)) {
                $topicRepo->update($topicId, $name);
                set_flash('success', 'Topik berhasil diperbarui.');
            }
            break;
        case 'delete':
            if (!empty($topicId)) {
                $topicRepo->delete($topicId);
                set_flash('success', 'Topik berhasil dihapus.');
            }
            break;
    }

    redirect(BASE_URL . '/admin/topics.php');
}

$topics  = $topicRepo->getAll();
$pendingReports = $reportRepo->countPending();
$flash   = get_flash();
$pageCSS = ['homepage.css', 'dashboard.css'];
$title   = 'Manajemen Topik';
?>
<!DOCTYPE html>
<html lang="id">
<?php include_once __DIR__ . '/../components/metadata.php'; ?>
<body style="background:var(--gray-50,#f9fafb);">
    <?php include_once __DIR__ . '/../components/navbar.php'; ?>

    <div class="dashboard-page">
        <aside class="dash-sidebar">
            <p class="dash-sidebar-title">Dashboard</p>
            <a href="<?= BASE_URL ?>/admin/" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Overview
            </a>
            <p class="dash-sidebar-title">Manajemen</p>
            <a href="<?= BASE_URL ?>/admin/users.php" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Pengguna
            </a>
            <a href="<?= BASE_URL ?>/admin/topics.php" class="dash-nav-item active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/></svg>
                Topik Forum
            </a>
            <a href="<?= BASE_URL ?>/moderator/reports.php" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/></svg>
                Laporan <?php if ($pendingReports > 0): ?><span class="dash-badge"><?= $pendingReports ?></span><?php endif; ?>
            </a>
            <p class="dash-sidebar-title">Navigasi</p>
            <a href="<?= BASE_URL ?>/" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                Kembali ke Forum
            </a>
        </aside>

        <main class="dash-content">
            <div class="dash-header">
                <h1>Manajemen Topik</h1>
                <p>Tambah, edit, dan hapus kategori/topik forum</p>
            </div>

            <?php if ($flash): ?>
                <div class="flash-message flash-<?= e($flash['type']) ?>" style="margin-bottom:1.5rem;">
                    <?= e($flash['message']) ?>
                </div>
            <?php endif; ?>

            <!-- Form Tambah Topik -->
            <div class="dash-table-card" style="margin-bottom:1.5rem;">
                <div class="dash-table-card-header">
                    <h2>Tambah Topik Baru</h2>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    <form method="POST" style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap;">
                        <input type="hidden" name="action" value="create">
                        <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                        <input type="text" name="topic_name" id="new-topic-name"
                               placeholder="Nama topik baru..."
                               style="padding:0.625rem 1rem;border:1.5px solid var(--gray-200,#e5e7eb);border-radius:10px;font-family:inherit;font-size:0.875rem;outline:none;flex:1;min-width:200px;"
                               maxlength="50" required>
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-add-topic">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Topik
                        </button>
                    </form>
                </div>
            </div>

            <!-- Daftar Topik -->
            <div class="dash-table-card">
                <div class="dash-table-card-header">
                    <h2>Daftar Topik (<?= count($topics) ?>)</h2>
                </div>
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Topik</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topics as $i => $t): ?>
                            <tr>
                                <td style="color:var(--gray-400,#9ca3af);font-size:0.8125rem;"><?= $i + 1 ?></td>
                                <td>
                                    <form method="POST" style="display:inline-flex;align-items:center;gap:0.5rem;" id="form-edit-<?= e($t['topic_id']) ?>">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="topic_id" value="<?= e($t['topic_id']) ?>">
                                        <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                        <input type="text" name="topic_name"
                                               value="<?= e($t['topic_name']) ?>"
                                               style="padding:0.375rem 0.625rem;border:1.5px solid var(--gray-200,#e5e7eb);border-radius:8px;font-family:inherit;font-size:0.875rem;outline:none;width:200px;"
                                               maxlength="50">
                                        <button type="submit" class="table-action-btn table-action-primary">Simpan</button>
                                    </form>
                                </td>
                                <td style="font-size:0.8125rem;white-space:nowrap;"><?= date('d M Y', strtotime($t['created_at'])) ?></td>
                                <td>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Hapus topik ini? Thread yang menggunakan topik ini tidak akan terhapus.')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="topic_id" value="<?= e($t['topic_id']) ?>">
                                        <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                        <button type="submit" class="table-action-btn table-action-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php include_once __DIR__ . '/../components/footer.php'; ?>
</body>
</html>
