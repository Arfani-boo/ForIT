<?php
/**
 * CommentRepository — Query database untuk tabel comments
 */
class CommentRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /** Ambil semua komentar (top-level & balasan) dari sebuah thread */
    public function getByThread(string $threadId): array
    {
        $stmt = $this->db->prepare("
            SELECT
                c.comment_id,
                c.content,
                c.parent_comment_id,
                c.thread_id,
                c.author_id,
                c.created_at,
                c.updated_at,
                u.username AS author_username,
                u.fullname AS author_fullname,
                u.role     AS author_role
            FROM comments c
            INNER JOIN users u ON c.author_id = u.user_id
            WHERE c.thread_id = :thread_id AND c.is_active = 1
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([':thread_id' => $threadId]);
        return $stmt->fetchAll();
    }

    /** Tambah komentar baru */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO comments (comment_id, content, parent_comment_id, thread_id, author_id)
            VALUES (:comment_id, :content, :parent_comment_id, :thread_id, :author_id)
        ");
        return $stmt->execute([
            ':comment_id'        => $data['comment_id'],
            ':content'           => $data['content'],
            ':parent_comment_id' => $data['parent_comment_id'] ?? null,
            ':thread_id'         => $data['thread_id'],
            ':author_id'         => $data['author_id'],
        ]);
    }

    /** Cari komentar berdasarkan ID */
    public function findById(string $commentId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE comment_id = :id AND is_active = 1 LIMIT 1");
        $stmt->execute([':id' => $commentId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /** Update isi komentar */
    public function update(string $commentId, string $content): bool
    {
        $stmt = $this->db->prepare("UPDATE comments SET content = :content WHERE comment_id = :id");
        return $stmt->execute([':content' => $content, ':id' => $commentId]);
    }

    /** Soft delete komentar */
    public function delete(string $commentId): bool
    {
        $stmt = $this->db->prepare("UPDATE comments SET is_active = 0 WHERE comment_id = :id");
        return $stmt->execute([':id' => $commentId]);
    }

    /** Hitung komentar di sebuah thread */
    public function countByThread(string $threadId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM comments WHERE thread_id = :id AND is_active = 1"
        );
        $stmt->execute([':id' => $threadId]);
        return (int)$stmt->fetchColumn();
    }
}
