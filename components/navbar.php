<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$user = auth_user();
$isLoggedIn = $user !== null;
?>

<nav>
    <div class="left-side">
        <a href="<?= BASE_URL ?>/" class="branding">
            <div class="branding-logo">F</div>
            <div class="branding-text">ForIT</div>
        </a>
    </div>

    <div class="middle">
        <a href="<?= BASE_URL ?>/" class="forum-navigation">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Forum
        </a>

        <form class="search-container" method="GET" action="<?= BASE_URL ?>/" role="search">
            <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="search" name="q" id="forum-search"
                   placeholder="Cari thread..."
                   value="<?= e($_GET['q'] ?? '') ?>"
                   autocomplete="off">
        </form>
    </div>

    <div class="right-side">
        <?php if ($isLoggedIn): ?>
            <!-- User sudah login -->
            <?php if (has_role('superadmin')): ?>
                <a href="<?= BASE_URL ?>/admin/" class="btn btn-primary nav-admin-btn" id="btn-nav-admin">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Admin Panel
                </a>
            <?php elseif (has_role('moderator')): ?>
                <a href="<?= BASE_URL ?>/moderator/reports.php" class="btn btn-ghost btn-primary nav-admin-btn" id="btn-nav-mod">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Moderasi
                </a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/forum/create-thread.php" class="btn btn-ghost btn-primary nav-new-thread-btn" id="btn-nav-new-thread">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Buat Thread
                </a>
            <?php endif; ?>

            <!-- Dropdown profil -->
            <div class="nav-user-menu" id="nav-user-menu">
                <button class="nav-user-btn" id="nav-user-btn" aria-expanded="false" aria-haspopup="true">
                    <div class="nav-avatar">
                        <?= e(mb_strtoupper(mb_substr($user['fullname'], 0, 1))) ?>
                    </div>
                    <span class="nav-username"><?= e($user['username']) ?></span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>

                <div class="nav-dropdown" id="nav-dropdown" role="menu" aria-labelledby="nav-user-btn">
                    <div class="nav-dropdown-header">
                        <strong><?= e($user['fullname']) ?></strong>
                        <span class="nav-role-badge nav-role-<?= e($user['role']) ?>">
                            <?= match($user['role']) {
                                'superadmin' => 'Super Admin',
                                'moderator'  => 'Moderator',
                                default      => 'Member',
                            } ?>
                        </span>
                    </div>
                    <hr class="nav-dropdown-divider">
                    <a href="<?= BASE_URL ?>/profile/?u=<?= e($user['username']) ?>" class="nav-dropdown-item" role="menuitem">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Profil Saya
                    </a>
                    <a href="<?= BASE_URL ?>/profile/?u=<?= e($user['username']) ?>&tab=bookmark" class="nav-dropdown-item" role="menuitem">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                        Bookmark
                    </a>
                    <hr class="nav-dropdown-divider">
                    <a href="<?= BASE_URL ?>/auth/logout.php" class="nav-dropdown-item nav-dropdown-danger" role="menuitem">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Keluar
                    </a>
                </div>
            </div>

        <?php else: ?>
            <!-- Guest: belum login -->
            <a href="<?= BASE_URL ?>/auth/register.php" class="btn btn-ghost btn-primary" id="btn-nav-register">
                Daftar
            </a>
            <a href="<?= BASE_URL ?>/auth/login.php" class="btn btn-primary" id="btn-nav-login">
                Login
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        <?php endif; ?>
    </div>
</nav>

<script>
// Toggle dropdown profil
(function () {
    const btn = document.getElementById('nav-user-btn');
    const dropdown = document.getElementById('nav-dropdown');
    if (!btn || !dropdown) return;

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        const isOpen = dropdown.classList.toggle('open');
        btn.setAttribute('aria-expanded', isOpen);
    });

    document.addEventListener('click', function () {
        dropdown.classList.remove('open');
        btn.setAttribute('aria-expanded', false);
    });
})();
</script>