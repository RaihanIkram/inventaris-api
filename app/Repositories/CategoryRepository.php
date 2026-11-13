<?php

namespace App\Repositories;

use PDO;
use App\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private PDO $db
    ) {}

    // Mengambil seluruh kategori
    public function getAll(): array
    {
        return $this->db->query(
            "SELECT * FROM categories ORDER BY id DESC"
        )->fetchAll();
    }

    // Mengambil kategori berdasarkan ID
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM categories WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    // Menambahkan kategori baru
    public function create(array $data): array
    {
        $stmt = $this->db->prepare(
            "INSERT INTO categories (name, description)
             VALUES (?, ?)"
        );

        $stmt->execute([
            $data['name'],
            $data['description']
        ]);

        return $this->findById(
            (int) $this->db->lastInsertId()
        );
    }

    // Memperbarui kategori
    public function update(int $id, array $data): ?array
    {
        $stmt = $this->db->prepare(
            "UPDATE categories
             SET name = ?, description = ?
             WHERE id = ?"
        );

        $stmt->execute([
            $data['name'],
            $data['description'],
            $id
        ]);

        return $this->findById($id);
    }

    // Menghapus kategori
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM categories WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }
}