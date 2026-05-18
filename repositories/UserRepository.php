<?php
/**
 * UserRepository — Query database untuk tabel users
 */
class UserRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /** Cari user berdasarkan email atau username */
    public function findByEmailOrUsername(string $identifier): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = :id OR username = :id LIMIT 1"
        );
        $stmt->execute([':id' => $identifier]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /** Cari user berdasarkan ID */
    public function findById(string $userId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :id LIMIT 1");
        $stmt->execute([':id' => $userId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /** Cari user berdasarkan username */
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /** Cek apakah email sudah digunakan */
    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT 1 FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return (bool)$stmt->fetch();
    }

    /** Cek apakah username sudah digunakan */
    public function usernameExists(string $username): bool
    {
        $stmt = $this->db->prepare("SELECT 1 FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        return (bool)$stmt->fetch();
    }

    /** Simpan user baru */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (user_id, username, email, fullname, password, role, status)
             VALUES (:user_id, :username, :email, :fullname, :password, 'user', 'active')"
        );
        return $stmt->execute([
            ':user_id'  => $data['user_id'],
            ':username' => $data['username'],
            ':email'    => $data['email'],
            ':fullname' => $data['fullname'],
            ':password' => $data['password'],
        ]);
    }

    /** Ambil semua user (untuk panel admin) */
    public function getAll(int $limit = 50, int $offset = 0): array
    {
        $stmt = $this->db->prepare(
            "SELECT user_id, username, email, fullname, role, status, created_at
             FROM users ORDER BY created_at DESC LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Update role user */
    public function updateRole(string $userId, string $role): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET role = :role WHERE user_id = :id");
        return $stmt->execute([':role' => $role, ':id' => $userId]);
    }

    /** Update status user (banned / restricted / active) */
    public function updateStatus(string $userId, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET status = :status WHERE user_id = :id");
        return $stmt->execute([':status' => $status, ':id' => $userId]);
    }

    /** Hapus user */
    public function delete(string $userId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = :id");
        return $stmt->execute([':id' => $userId]);
    }

    /** Hitung total user */
    public function count(): int
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
