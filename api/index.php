<?php declare(strict_types=1);

require __DIR__ . '/src/bootstrap.php';
require __DIR__ . '/src/Models/Product.php';
require __DIR__ . '/src/Models/Order.php';
require __DIR__ . '/src/Controllers/ProductController.php';
require __DIR__ . '/src/Controllers/CheckoutController.php';
require __DIR__ . '/src/Controllers/OrderController.php';

// CORS
$origin  = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowed = getenv('FRONTEND_URL') ?: 'http://localhost';
if ($origin === $allowed) {
    header("Access-Control-Allow-Origin: $origin");
}
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

// Route
$base   = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$path   = '/' . ltrim(substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), strlen($base)), '/');
$method = $_SERVER['REQUEST_METHOD'];

$productModel  = new ProductModel(db());
$orderModel    = new OrderModel(db());

// GET /products
if ($method === 'GET' && $path === '/products') {
    (new ProductController($productModel))->list();
}

// GET /products/{slug}
if ($method === 'GET' && preg_match('#^/products/([a-z0-9][a-z0-9\-]{0,199})$#', $path, $m)) {
    (new ProductController($productModel))->show($m[1]);
}

// POST /checkout
if ($method === 'POST' && $path === '/checkout') {
    (new CheckoutController($productModel, $orderModel))->process();
}

// GET /orders/{id}
if ($method === 'GET' && preg_match('#^/orders/(\d+)$#', $path, $m)) {
    (new OrderController($orderModel))->show((int) $m[1]);
}

json_error('Rota não encontrada.', 404);
