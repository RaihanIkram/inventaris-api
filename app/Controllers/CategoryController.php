<?php

namespace App\Controllers;

use App\Core\Response;
use App\Services\CategoryService;

class CategoryController
{
    public function __construct(
        private CategoryService $service
    ) {}

    // Mengambil seluruh kategori
    public function index(): void
    {
        Response::success($this->service->getAll());
    }

    // Mengambil detail kategori berdasarkan ID
    public function show(int $id): void
    {
        Response::success($this->service->getById($id));
    }

    // Menambahkan kategori baru
    public function store(): void
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        if (!is_array($data) || array_is_list($data)) {
            Response::error('JSON object tidak valid', 400);
        }

        Response::success(
            $this->service->create($data),
            'Kategori berhasil ditambahkan',
            201
        );
    }

    // Memperbarui kategori
    public function update(int $id): void
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        if (!is_array($data) || array_is_list($data)) {
            Response::error('JSON object tidak valid', 400);
        }

        Response::success(
            $this->service->update($id, $data),
            'Kategori berhasil diperbarui'
        );
    }

    // Menghapus kategori
    public function destroy(int $id): void
    {
        $this->service->delete($id);

        Response::json(null, 204);
    }
}
