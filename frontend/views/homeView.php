<?php
$title       = 'Geek Heroes — Colecionáveis e Action Figures';
$meta_description = 'A melhor loja de colecionáveis do Brasil. Funkos, Action Figures, Miniaturas e muito mais.';
$page_css    = 'home.css';
$page_js     = 'home.js';
require __DIR__ . '/layout/header.php';
?>
<section class="hero">
    <div class="hero-inner">
        <h1>Colecionáveis Geek</h1>
        <p>Funkos, Action Figures e muito mais</p>
    </div>
</section>

<section class="products-section">
    <div class="products-header">
        <h2>Produtos</h2>
    </div>
    <div id="products-grid" class="products-grid">
        <div class="loading">Carregando...</div>
    </div>
</section>
<?php require __DIR__ . '/layout/footer.php'; ?>
