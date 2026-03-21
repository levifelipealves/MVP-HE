<?php declare(strict_types=1);

define('FRONTEND_ROOT', __DIR__);
define('API_URL', getenv('API_URL') ?: 'http://api.geekheroes.com.br');

$base  = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$path  = '/' . ltrim(substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), strlen($base)), '/');
$path  = ($path === '') ? '/' : $path;
$slug  = '';
$page  = null;

$routes = ['/' => 'home', '/carrinho' => 'carrinho', '/checkout' => 'checkout'];

if (isset($routes[$path])) {
    $page = $routes[$path];
} elseif (preg_match('#^/produto/([a-z0-9][a-z0-9\-]{0,199})$#', $path, $m)) {
    $page = 'produto';
    $slug = $m[1];
} elseif (preg_match('#^/pedido/(\d+)$#', $path, $m)) {
    $page = 'confirmado';
    $order_id = (int) $m[1];
}

if (!$page) {
    http_response_code(404);
    $title = '404 — Página não encontrada';
    require __DIR__ . '/views/layout/header.php';
    echo '<main class="not-found"><h1>404</h1><p>Página não encontrada.</p><a href="' . $base . '/">Voltar</a></main>';
    require __DIR__ . '/views/layout/footer.php';
    exit;
}

require __DIR__ . '/views/' . $page . '.php';
