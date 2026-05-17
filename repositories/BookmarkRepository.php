<?php
/**
 * BookmarkRepository — Query database untuk tabel bookmarks
 */
class BookmarkRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /** Tambah bookmark */
    public function add(string $bookmarkId, string $userId, string $threadId): bool
    {
        $stmt = $this->db->prepare(
            "INSERT IGNORE INTO bookmarks (bookmark_id, user_id, thread_id)
             VALUES (:bookmark_id, :user_id, :thread_id)"
        );
        return $stmt->execute([
            ':bookmark_id' => $bookmarkId,
            ':user_id'     => $userId,
            ':thread_id'   => $threadId,
        ]);
    }

    /** Hapus bookmark */
    public function remove(string $userId, string $threadId): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM bookmarks WHERE user_id = :user_id AND thread_id = :thread_id"
        );
        return $stmt->execute([':user_id' => $userId, ':thread_id' => $threadId]);
    }

    /** Cek apakah thread sudah dibookmark */
    public function exists(string $userId, string $threadId): bool
    {
        $stmt = $this->db->prepare(
            "SELECT 1 FROM bookmarks WHERE user_id = :user_id AND thread_id = :thread_id LIMIT 1"
        );
        $stmt->execute([':user_id' => $userId, ':thread_id' => $threadId]);
        return (bool)$stmt->fetch();
    }

    /** Ambil semua thread_id yang dibookmark user */
    public function getBookmarkedThreadIds(string $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT thread_id FROM bookmarks WHERE user_id = :user_id"
        );
        $stmt->execute([':user_id' => $userId]);
        return array_column($stmt->fetchAll(), 'thread_id');
    }

    /** Ambil thread yang dibookmark user (join dengan threads) */
    public function getByUser(string $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT t.*, b.created_at AS bookmarked_at,
                u.username AS author_username,
                u.fullname AS author_fullname,
                (SELECT COUNT(*) FROM comments c WHERE c.thread_id = t.thread_id AND c.is_active = 1) AS comment_count
            FROM bookmarks b
            INNER JOIN threads t ON b.thread_id = t.thread_id
            INNER JOIN users u ON t.author_id = u.user_id
            WHERE b.user_id = :user_id AND t.is_active = 1
            ORDER BY b.created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
