<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$file = __DIR__ . $path;

// Melayani file statis dan folder yang memiliki index.html
if (
    $path !== '/' &&
    (
        is_file($file) ||
        (
            is_dir($file) &&
            is_file(rtrim($file, '/\\') . DIRECTORY_SEPARATOR . 'index.html')
        )
    )
) {
    return false;
}

// Request API diteruskan ke Front Controller
require __DIR__ . '/index.php';