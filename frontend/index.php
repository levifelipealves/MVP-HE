<?php declare(strict_types=1);

define('FRONTEND_ROOT', __DIR__);

// Load .env
foreach (file(dirname(__DIR__) . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $_line) {
    if (str_starts_with(trim($_line), '#') || !str_contains($_line, '=')) continue;
    [$_k, $_v] = explode('=', $_line, 2);
    $_k = trim($_k); $_v = trim($_v);
    if (!getenv($_k)) { putenv("$_k=$_v"); $_ENV[$_k] = $_v; }
}

define('API_URL', getenv('API_URL') ?: 'http://api.geekheroes.com.br');

$base  = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$path  = '/' . ltrim(substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), strlen($base)), '/');
$path  = ($path === '') ? '/' : $path;
$slug  = '';
$page  = null;

$routes = [
    '/'        => 'homeView',
    '/cart'    => 'cartView',
    '/checkout'=> 'checkoutView',
    '/about'   => 'aboutView',
    '/privacy' => 'privacyView',
    '/terms'   => 'termsView',
    '/returns' => 'returnsView',
];

if (isset($routes[$path])) {
    $page = $routes[$path];
} elseif (preg_match('#^/product/([a-z0-9][a-z0-9\-]{0,199})$#', $path, $m)) {
    $page = 'productView';
    $slug = $m[1];
} elseif (preg_match('#^/order/(\d+)$#', $path, $m)) {
    $page = 'confirmedView';
    $order_id = (int) $m[1];
} elseif ($path === '/admin/products') {
    $page = 'admin/products';
}

if (!$page) {
    http_response_code(404);
    $title = '404 — Página não encontrada';
    require __DIR__ . '/views/layout/header.php';
    echo '<main class="not-found"><h1>404</h1><p>Página não encontrada.</p><a href="' . $base . '/">Voltar</a></main>';
    require __DIR__ . '/views/layout/footer.php';
    exit;
}

if ($page === 'admin/products') {
    require __DIR__ . '/views/admin/productCrudView.php';
    exit;
}

require __DIR__ . '/views/' . $page . '.php';
