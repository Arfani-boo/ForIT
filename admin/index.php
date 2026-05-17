<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

$allowedRoles = ['superadmin'];
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../middleware/role.php';

require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/ThreadRepository.php';
require_once __DIR__ . '/../repositories/ReportRepository.php';
require_once __DIR__ . '/../repositories/TopicRepository.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$user = auth_user();

$userRepo   = new UserRepository(DBH);
$threadRepo = new ThreadRepository(DBH);
$reportRepo = new ReportRepository(DBH);
$topicRepo  = new TopicRepository(DBH);

$totalUsers   = $userRepo->count();
$totalThreads = $threadRepo->count();
$pendingReports = $reportRepo->countPending();
$totalTopics  = count($topicRepo->getAll());
$recentUsers  = $userRepo->getAll(5);

$flash   = get_flash();
$pageCSS = ['homepage.css', 'dashboard.css'];
$title   = 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<?php include_once __DIR__ . '/../components/metadata.php'; ?>
<body style="background:var(--gray-50,#f9fafb);">
    <?php include_once __DIR__ . '/../components/navbar.php'; ?>

    <div class="dashboard-page">
        <!-- Admin Sidebar -->
        <aside class="dash-sidebar">
            <p class="dash-sidebar-title">Dashboard</p>
            <a href="<?= BASE_URL ?>/admin/" class="dash-nav-item active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Overview
            </a>

            <p class="dash-sidebar-title">Manajemen</p>
            <a href="<?= BASE_URL ?>/admin/users.php" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Pengguna
            </a>
            <a href="<?= BASE_URL ?>/admin/topics.php" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                Topik Forum
            </a>
            <a href="<?= BASE_URL ?>/moderator/reports.php" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>
                Laporan
                <?php if ($pendingReports > 0): ?>
                    <span class="dash-badge"><?= $pendingReports ?></span>
                <?php endif; ?>
            </a>

            <p class="dash-sidebar-title">Navigasi</p>
            <a href="<?= BASE_URL ?>/" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                Kembali ke Forum
            </a>
        </aside>

        <!-- Main -->
        <main class="dash-content">
            <div class="dash-header">
                <h1>Dashboard Admin</h1>
                <p>Selamat datang kembali, <?= e($user['fullname']) ?>!</p>
            </div>

            <?php if ($flash): ?>
                <div class="flash-message flash-<?= e($flash['type']) ?>" style="margin-bottom:1.5rem;">
                    <?= e($flash['message']) ?>
                </div>
            <?php endif; ?>

            <!-- Stats -->
            <div class="dash-stats-grid">
                <div class="dash-stat-card primary">
                    <div class="dash-stat-label">Total Pengguna</div>
                    <div class="dash-stat-number"><?= number_format($totalUsers) ?></div>
                </div>
                <div class="dash-stat-card success">
                    <div class="dash-stat-label">Total Thread</div>
                    <div class="dash-stat-number"><?= number_format($totalThreads) ?></div>
                </div>
                <div class="dash-stat-card danger">
                    <div class="dash-stat-label">Laporan Pending</div>
                    <div class="dash-stat-number"><?= $pendingReports ?></div>
                </div>
                <div class="dash-stat-card warning">
                    <div class="dash-stat-label">Topik Forum</div>
                    <div class="dash-stat-number"><?= $totalTopics ?></div>
                </div>
            </div>

            <!-- Pengguna Terbaru -->
            <div class="dash-table-card">
                <div class="dash-table-card-header">
                    <h2>Pengguna Terbaru</h2>
                    <a href="<?= BASE_URL ?>/admin/users.php" class="table-action-btn table-action-primary">Lihat Semua</a>
                </div>
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentUsers as $u): ?>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:0.5rem;">
                                        <div style="width:1.75rem;height:1.75rem;border-radius:50%;background:linear-gradient(135deg,#155DFC,#6366f1);color:white;font-size:0.7rem;font-weight:700;display:flex;align-items:center;justify-content:center;">
                                            <?= e(mb_strtoupper(mb_substr($u['fullname'], 0, 1))) ?>
                                        </div>
                                        <div>
                                            <div style="font-weight:600;"><?= e($u['fullname']) ?></div>
                                            <div style="font-size:0.775rem;color:var(--gray-400,#9ca3af);">@<?= e($u['username']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= e($u['email']) ?></td>
                                <td><span class="role-badge role-<?= e($u['role']) ?>"><?= e(ucfirst($u['role'])) ?></span></td>
                                <td><span class="status-badge status-<?= e($u['status']) ?>"><?= e(ucfirst($u['status'])) ?></span></td>
                                <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
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
