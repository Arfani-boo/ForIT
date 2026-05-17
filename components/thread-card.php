<?php
/**
 * Komponen Thread Card
 * Variabel yang diharapkan:
 * - $thread: array berisi data thread (dari ThreadRepository::getList)
 * - $topics: array topik thread ini (optional)
 * - $bookmarkedIds: array thread_id yang dibookmark user (optional)
 */

require_once __DIR__ . '/../helpers.php';

$topics        ??= [];
$bookmarkedIds ??= [];
$isBookmarked   = in_array($thread['thread_id'], $bookmarkedIds);
$user           = auth_user();
?>

<article class="thread-card" data-thread-id="<?= e($thread['thread_id']) ?>">
    <!-- Header: Avatar + Author + Waktu -->
    <div class="thread-card-header">
        <div class="thread-author-avatar">
            <?= e(mb_strtoupper(mb_substr($thread['author_fullname'], 0, 1))) ?>
        </div>
        <div class="thread-author-meta">
            <a href="<?= BASE_URL ?>/profile/?u=<?= e($thread['author_username']) ?>" class="thread-author-name">
                <?= e($thread['author_fullname']) ?>
            </a>
            <span class="thread-meta-dot">·</span>
            <time class="thread-time" datetime="<?= e($thread['created_at']) ?>" title="<?= e($thread['created_at']) ?>">
                <?= time_ago($thread['created_at']) ?>
            </time>
        </div>
    </div>

    <!-- Topik badges -->
    <?php if (!empty($topics)): ?>
        <div class="thread-topics">
            <?php foreach ($topics as $topic): ?>
                <a href="<?= BASE_URL ?>/?topic=<?= e($topic['topic_id']) ?>" class="thread-topic-badge">
                    <?= e($topic['topic_name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Konten Thread -->
    <div class="thread-card-body">
        <h2 class="thread-card-title">
            <a href="<?= BASE_URL ?>/thread.php?id=<?= e($thread['thread_id']) ?>">
                <?= e($thread['thread_title']) ?>
            </a>
        </h2>
        <p class="thread-card-excerpt">
            <?= e(truncate(strip_tags($thread['thread_description']), 180)) ?>
        </p>
    </div>

    <!-- Footer: Jumlah komentar + Aksi -->
    <div class="thread-card-footer">
        <div class="thread-stats">
            <span class="thread-stat">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <?= (int)($thread['comment_count'] ?? 0) ?> komentar
            </span>
        </div>

        <div class="thread-actions">
            <!-- Share -->
            <button
                class="thread-action-btn btn-share"
                data-url="<?= BASE_URL ?>/thread.php?id=<?= e($thread['thread_id']) ?>"
                data-title="<?= e($thread['thread_title']) ?>"
                title="Bagikan thread ini"
                aria-label="Bagikan">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                Bagikan
            </button>

            <!-- Bookmark (hanya jika login) -->
            <?php if ($user): ?>
                <button
                    class="thread-action-btn btn-bookmark <?= $isBookmarked ? 'bookmarked' : '' ?>"
                    data-thread-id="<?= e($thread['thread_id']) ?>"
                    data-action="<?= BASE_URL ?>/api/bookmark.php"
                    title="<?= $isBookmarked ? 'Hapus bookmark' : 'Simpan ke bookmark' ?>"
                    aria-label="Bookmark">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="<?= $isBookmarked ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                    <?= $isBookmarked ? 'Tersimpan' : 'Simpan' ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
</article>
