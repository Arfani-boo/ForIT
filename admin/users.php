<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

$allowedRoles = ['superadmin'];
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../middleware/role.php';

require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/ReportRepository.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$user       = auth_user();
$userRepo   = new UserRepository(DBH);
$reportRepo = new ReportRepository(DBH);

// Handle aksi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    $action = $_POST['action'] ?? '';
    $uid    = trim($_POST['user_id'] ?? '');

    if (empty($uid) || $uid === $user['user_id']) {
        set_flash('error', 'Aksi tidak valid.');
        redirect(BASE_URL . '/admin/users.php');
    }

    switch ($action) {
        case 'promote_moderator':
            $userRepo->updateRole($uid, 'moderator');
            set_flash('success', 'User berhasil dipromosikan menjadi Moderator.');
            break;
        case 'demote_user':
            $userRepo->updateRole($uid, 'user');
            set_flash('success', 'Moderator berhasil diturunkan menjadi User.');
            break;
        case 'ban':
            $userRepo->updateStatus($uid, 'banned');
            set_flash('success', 'Akun berhasil di-banned secara permanen.');
            break;
        case 'unban':
            $userRepo->updateStatus($uid, 'active');
            set_flash('success', 'Akun berhasil diaktifkan kembali.');
            break;
        case 'restrict':
            $userRepo->updateStatus($uid, 'restricted');
            set_flash('success', 'Hak posting user dibatasi.');
            break;
        case 'unrestrict':
            $userRepo->updateStatus($uid, 'active');
            set_flash('success', 'Batasan posting user dihapus.');
            break;
        case 'delete':
            $userRepo->delete($uid);
            set_flash('success', 'Akun berhasil dihapus.');
            break;
    }

    redirect(BASE_URL . '/admin/users.php');
}

$search  = trim($_GET['q'] ?? '');
$users   = $userRepo->getAll(100);
$pendingReports = $reportRepo->countPending();
$flash   = get_flash();
$pageCSS = ['homepage.css', 'dashboard.css'];
$title   = 'Manajemen Pengguna';
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
            <a href="<?= BASE_URL ?>/admin/users.php" class="dash-nav-item active">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Pengguna
            </a>
            <a href="<?= BASE_URL ?>/admin/topics.php" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/></svg>
                Topik Forum
            </a>
            <a href="<?= BASE_URL ?>/moderator/reports.php" class="dash-nav-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/></svg>
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

        <main class="dash-content">
            <div class="dash-header">
                <h1>Manajemen Pengguna</h1>
                <p>Kelola akun, role, dan status pengguna ForIT</p>
            </div>

            <?php if ($flash): ?>
                <div class="flash-message flash-<?= e($flash['type']) ?>" style="margin-bottom:1.5rem;">
                    <?= e($flash['message']) ?>
                </div>
            <?php endif; ?>

            <div class="dash-table-card">
                <div class="dash-table-card-header">
                    <h2>Daftar Pengguna (<?= count($users) ?>)</h2>
                </div>

                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <?php $isSelf = $u['user_id'] === $user['user_id']; ?>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:0.5rem;">
                                        <div style="width:1.875rem;height:1.875rem;border-radius:50%;background:linear-gradient(135deg,#155DFC,#6366f1);color:white;font-size:0.7rem;font-weight:700;display:flex;align-items:center;justify-content:center;">
                                            <?= e(mb_strtoupper(mb_substr($u['fullname'], 0, 1))) ?>
                                        </div>
                                        <div>
                                            <div style="font-weight:600;font-size:0.875rem;"><?= e($u['fullname']) ?></div>
                                            <div style="font-size:0.775rem;color:var(--gray-400,#9ca3af);">@<?= e($u['username']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:0.8375rem;"><?= e($u['email']) ?></td>
                                <td><span class="role-badge role-<?= e($u['role']) ?>"><?= e(ucfirst($u['role'])) ?></span></td>
                                <td><span class="status-badge status-<?= e($u['status']) ?>"><?= e(ucfirst($u['status'])) ?></span></td>
                                <td style="font-size:0.8125rem;white-space:nowrap;"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                                <td>
                                    <?php if ($isSelf): ?>
                                        <span style="font-size:0.8125rem;color:var(--gray-400,#9ca3af);">Akun sendiri</span>
                                    <?php elseif ($u['role'] !== 'superadmin'): ?>
                                        <div style="display:flex;gap:0.375rem;flex-wrap:wrap;">
                                            <!-- Promote/Demote -->
                                            <?php if ($u['role'] === 'user'): ?>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="action" value="promote_moderator">
                                                    <input type="hidden" name="user_id" value="<?= e($u['user_id']) ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                                    <button type="submit" class="table-action-btn table-action-success" title="Jadikan Moderator">↑ Mod</button>
                                                </form>
                                            <?php elseif ($u['role'] === 'moderator'): ?>
                                                <form method="POST" style="display:inline;" onsubmit="return confirm('Turunkan ke User?')">
                                                    <input type="hidden" name="action" value="demote_user">
                                                    <input type="hidden" name="user_id" value="<?= e($u['user_id']) ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                                    <button type="submit" class="table-action-btn table-action-warning">↓ User</button>
                                                </form>
                                            <?php endif; ?>

                                            <!-- Ban/Restrict -->
                                            <?php if ($u['status'] === 'active'): ?>
                                                <form method="POST" style="display:inline;" onsubmit="return confirm('Batasi posting user ini?')">
                                                    <input type="hidden" name="action" value="restrict">
                                                    <input type="hidden" name="user_id" value="<?= e($u['user_id']) ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                                    <button type="submit" class="table-action-btn table-action-warning">Restrict</button>
                                                </form>
                                                <form method="POST" style="display:inline;" onsubmit="return confirm('BAN PERMANEN akun ini?')">
                                                    <input type="hidden" name="action" value="ban">
                                                    <input type="hidden" name="user_id" value="<?= e($u['user_id']) ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                                    <button type="submit" class="table-action-btn table-action-danger">Ban</button>
                                                </form>
                                            <?php elseif ($u['status'] === 'banned' || $u['status'] === 'restricted'): ?>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="action" value="unban">
                                                    <input type="hidden" name="user_id" value="<?= e($u['user_id']) ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                                    <button type="submit" class="table-action-btn table-action-success">Aktifkan</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span style="font-size:0.8125rem;color:var(--gray-400,#9ca3af);">Super Admin</span>
                                    <?php endif; ?>
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
