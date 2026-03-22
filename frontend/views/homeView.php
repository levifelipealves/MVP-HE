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

<!-- CATEGORY BANNERS -->
<section class="banners-section">
    <div class="banners-grid">
        <div class="banner-item">
            <img src="<?= $base ?>/assets/images/banner-jogos.jpg" alt="Games" loading="lazy">
            <div class="banner-overlay">
                <h3 class="banner-label">Games</h3>
            </div>
        </div>
        <div class="banner-item">
            <img src="<?= $base ?>/assets/images/banner-funkos.jpg" alt="Funkos" loading="lazy">
            <div class="banner-overlay">
                <h3 class="banner-label">Funkos</h3>
            </div>
        </div>
        <div class="banner-item">
            <img src="<?= $base ?>/assets/images/banner-acessorios.jpg" alt="Acessórios" loading="lazy">
            <div class="banner-overlay">
                <h3 class="banner-label">Acessórios</h3>
            </div>
        </div>
    </div>
</section>

<!-- BRAND STRIP -->
<section class="brands-section">
    <h2 class="brands-title">Marcas:</h2>
    <div class="brands-list">
        <img src="<?= $base ?>/assets/images/logo-funko.png"     alt="Funko"         class="brand-logo">
        <img src="<?= $base ?>/assets/images/logo-bandai.png"    alt="Bandai"        class="brand-logo">
        <img src="<?= $base ?>/assets/images/logo-hotwheels.png" alt="Hot Wheels"    class="brand-logo">
        <img src="<?= $base ?>/assets/images/logo-mcfarlane.png" alt="McFarlane Toys" class="brand-logo">
        <img src="<?= $base ?>/assets/images/logo-neca.png"      alt="NECA"          class="brand-logo">
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
