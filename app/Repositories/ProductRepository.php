<?php

namespace App\Repositories;

use PDO;
use App\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private PDO $db
    ) {}

    // Mengambil semua produk atau mencari berdasarkan nama
    public function getAll(?string $search = null): array
    {
        if ($search !== null && trim($search) !== '') {
            $stmt = $this->db->prepare(
                "SELECT * FROM products
                 WHERE name LIKE :search
                 ORDER BY id DESC"
            );

            $stmt->execute([
                'search' => '%' . trim($search) . '%'
            ]);

            return $stmt->fetchAll();
        }

        return $this->db->query(
            "SELECT * FROM products ORDER BY id DESC"
        )->fetchAll();
    }

    // Mengambil produk berdasarkan ID
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM products WHERE id = :id"
        );

        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    // Menambahkan produk
    public function create(array $data): array
    {
        $sql = "INSERT INTO products
                (category_id, name, price, stock)
                VALUES (:category_id, :name, :price, :stock)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return $this->findById(
            (int) $this->db->lastInsertId()
        );
    }

    // Memperbarui produk
    public function update(int $id, array $data): ?array
    {
        $sql = "UPDATE products
                SET category_id = :category_id,
                    name = :name,
                    price = :price,
                    stock = :stock
                WHERE id = :id";

        $data['id'] = $id;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return $this->findById($id);
    }

    // Menghapus produk
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM products WHERE id = :id"
        );

        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
