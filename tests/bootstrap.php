<?php
define('API_ROOT', __DIR__ . '/../api');

// Stub functions for unit tests — no HTTP headers, no exit, no DB
if (!function_exists('json_response')) {
    function json_response(mixed $data, int $status = 200): never
    {
        throw new \Exception(json_encode($data));
    }
}

if (!function_exists('json_error')) {
    function json_error(string $message, int $status = 400): never
    {
        throw new \Exception($message);
    }
}

if (!function_exists('db')) {
    function db(): PDO
    {
        throw new \RuntimeException('DB not available in unit tests');
    }
}

// Load model and controller classes (no side-effects at include time)
require_once API_ROOT . '/src/helpers.php';
require_once API_ROOT . '/src/Models/Product.php';
require_once API_ROOT . '/src/Models/Order.php';
require_once API_ROOT . '/src/Models/Review.php';
require_once API_ROOT . '/src/Controllers/CheckoutController.php';
require_once API_ROOT . '/src/Controllers/ReviewController.php';
