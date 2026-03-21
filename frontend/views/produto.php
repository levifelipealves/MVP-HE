<?php
// SEO: busca dados do produto na API para meta tags
$product = null;
if (!empty($slug)) {
    $res = @file_get_contents(API_URL . '/products/' . rawurlencode($slug));
    if ($res) {
        $json = json_decode($res, true);
        $product = $json['data'] ?? null;
    }
}

$title            = $product ? htmlspecialchars($product['name']) . ' | Geek Heroes' : 'Produto | Geek Heroes';
$meta_description = $product ? mb_substr(strip_tags($product['description'] ?? ''), 0, 160) : '';
$canonical        = 'https://geekheroes.com.br/produto/' . htmlspecialchars($slug);
$og = $product ? [
    'title'       => $product['name'],
    'description' => $meta_description,
    'image'       => $product['image'] ?? '',
    'type'        => 'product',
] : null;
$page_css = 'produto.css';
$page_js  = 'produto.js';
require __DIR__ . '/layout/header.php';
?>
<div id="product-detail" data-slug="<?= htmlspecialchars($slug) ?>">
    <div class="loading">Carregando...</div>
</div>
<?php require __DIR__ . '/layout/footer.php'; ?>
