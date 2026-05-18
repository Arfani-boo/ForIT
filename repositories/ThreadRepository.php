<?php
/**
 * ThreadRepository — Query database untuk tabel threads
 */
class ThreadRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Ambil daftar thread dengan filter pencarian & topik
     * Dilengkapi dengan info author dan jumlah komentar
     */
    public function getList(string $search = '', string $topicId = '', int $limit = 20, int $offset = 0): array
    {
        $conditions = ["t.is_active = 1"];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "(t.thread_title LIKE :search OR t.thread_description LIKE :search)";
            $params[':search'] = "%$search%";
        }

        if (!empty($topicId)) {
            $conditions[] = "EXISTS (SELECT 1 FROM thread_topic tt WHERE tt.thread_id = t.thread_id AND tt.topic_id = :topic_id)";
            $params[':topic_id'] = $topicId;
        }

        $where = implode(' AND ', $conditions);

        $sql = "
            SELECT
                t.thread_id,
                t.thread_title,
                t.thread_description,
                t.created_at,
                t.updated_at,
                u.user_id AS author_id,
                u.username AS author_username,
                u.fullname AS author_fullname,
                (SELECT COUNT(*) FROM comments c WHERE c.thread_id = t.thread_id AND c.is_active = 1) AS comment_count
            FROM threads t
            INNER JOIN users u ON t.author_id = u.user_id
            WHERE $where
            ORDER BY t.created_at DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Hitung total thread (untuk pagination) */
    public function countList(string $search = '', string $topicId = ''): int
    {
        $conditions = ["t.is_active = 1"];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "(t.thread_title LIKE :search OR t.thread_description LIKE :search)";
            $params[':search'] = "%$search%";
        }

        if (!empty($topicId)) {
            $conditions[] = "EXISTS (SELECT 1 FROM thread_topic tt WHERE tt.thread_id = t.thread_id AND tt.topic_id = :topic_id)";
            $params[':topic_id'] = $topicId;
        }

        $where = implode(' AND ', $conditions);

        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM threads t WHERE $where"
        );
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    /** Ambil detail satu thread berdasarkan ID */
    public function findById(string $threadId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                t.*,
                u.username AS author_username,
                u.fullname AS author_fullname,
                u.role AS author_role,
                (SELECT COUNT(*) FROM comments c WHERE c.thread_id = t.thread_id AND c.is_active = 1) AS comment_count
            FROM threads t
            INNER JOIN users u ON t.author_id = u.user_id
            WHERE t.thread_id = :id AND t.is_active = 1
            LIMIT 1
        ");
        $stmt->execute([':id' => $threadId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /** Buat thread baru */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO threads (thread_id, thread_title, thread_description, author_id)
            VALUES (:thread_id, :title, :description, :author_id)
        ");
        return $stmt->execute([
            ':thread_id'   => $data['thread_id'],
            ':title'       => $data['thread_title'],
            ':description' => $data['thread_description'],
            ':author_id'   => $data['author_id'],
        ]);
    }

    /** Assign topik ke thread */
    public function assignTopic(string $threadId, string $topicId, string $assignedBy): bool
    {
        $stmt = $this->db->prepare("
            INSERT IGNORE INTO thread_topic (thread_id, topic_id, assigned_by)
            VALUES (:thread_id, :topic_id, :assigned_by)
        ");
        return $stmt->execute([
            ':thread_id'   => $threadId,
            ':topic_id'    => $topicId,
            ':assigned_by' => $assignedBy,
        ]);
    }

    /** Hapus semua topik dari thread */
    public function clearTopics(string $threadId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM thread_topic WHERE thread_id = :id");
        return $stmt->execute([':id' => $threadId]);
    }

    /** Update thread */
    public function update(string $threadId, string $title, string $description): bool
    {
        $stmt = $this->db->prepare("
            UPDATE threads SET thread_title = :title, thread_description = :description
            WHERE thread_id = :id
        ");
        return $stmt->execute([':title' => $title, ':description' => $description, ':id' => $threadId]);
    }

    /** Soft delete thread (set is_active = 0) */
    public function delete(string $threadId): bool
    {
        $stmt = $this->db->prepare("UPDATE threads SET is_active = 0 WHERE thread_id = :id");
        return $stmt->execute([':id' => $threadId]);
    }

    /** Ambil thread milik seorang user */
    public function getByUser(string $userId, int $limit = 20): array
    {
        $stmt = $this->db->prepare("
            SELECT t.*,
                (SELECT COUNT(*) FROM comments c WHERE c.thread_id = t.thread_id AND c.is_active = 1) AS comment_count
            FROM threads t
            WHERE t.author_id = :user_id AND t.is_active = 1
            ORDER BY t.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Hitung total thread (semua, untuk admin) */
    public function count(): int
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM threads WHERE is_active = 1")->fetchColumn();
    }
}
