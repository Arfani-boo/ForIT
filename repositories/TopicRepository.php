<?php
/**
 * TopicRepository — Query database untuk tabel topics
 */
class TopicRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /** Ambil semua topik */
    public function getAll(): array
    {
        return $this->db->query(
            "SELECT * FROM topics ORDER BY topic_name ASC"
        )->fetchAll();
    }

    /** Cari topik berdasarkan ID */
    public function findById(string $topicId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM topics WHERE topic_id = :id LIMIT 1");
        $stmt->execute([':id' => $topicId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /** Buat topik baru */
    public function create(string $topicId, string $topicName): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO topics (topic_id, topic_name) VALUES (:id, :name)"
        );
        return $stmt->execute([':id' => $topicId, ':name' => $topicName]);
    }

    /** Update topik */
    public function update(string $topicId, string $topicName): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE topics SET topic_name = :name WHERE topic_id = :id"
        );
        return $stmt->execute([':name' => $topicName, ':id' => $topicId]);
    }

    /** Hapus topik */
    public function delete(string $topicId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM topics WHERE topic_id = :id");
        return $stmt->execute([':id' => $topicId]);
    }

    /** Ambil topik dari sebuah thread */
    public function getByThread(string $threadId): array
    {
        $stmt = $this->db->prepare(
            "SELECT t.* FROM topics t
             INNER JOIN thread_topic tt ON t.topic_id = tt.topic_id
             WHERE tt.thread_id = :thread_id"
        );
        $stmt->execute([':thread_id' => $threadId]);
        return $stmt->fetchAll();
    }
}
