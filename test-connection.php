<?php

require __DIR__ . '/vendor/autoload.php';

try {
    // Membaca konfigurasi dari file .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Membuat koneksi ke MySQL
    $pdo = App\Config\Database::connection();

    echo "Koneksi database berhasil!" . PHP_EOL;

} catch (Throwable $e) {
    echo "Koneksi gagal: " . $e->getMessage() . PHP_EOL;
}
