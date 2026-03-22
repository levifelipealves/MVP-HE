<?php
$res     = @file_get_contents(API_URL . '/products/' . rawurlencode($slug));
$product = $res ? (json_decode($res, true)['data'] ?? null) : null;

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

<!-- BREADCRUMB -->
<nav class="breadcrumb-wrap">
    <div class="breadcrumb-inner">
        <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="<?= $base ?>/" itemprop="item"><span itemprop="name">Home</span></a>
                <meta itemprop="position" content="1">
            </li>
            <li class="breadcrumb-sep">›</li>
            <li class="breadcrumb-item" id="breadcrumb-category" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="<?= $base ?>/" itemprop="item"><span itemprop="name" id="breadcrumb-cat-name">Produtos</span></a>
                <meta itemprop="position" content="2">
            </li>
            <li class="breadcrumb-sep">›</li>
            <li class="breadcrumb-item breadcrumb-current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name" id="breadcrumb-product-name"><?= $product ? htmlspecialchars($product['name']) : 'Carregando...' ?></span>
                <meta itemprop="position" content="3">
            </li>
        </ol>
    </div>
</nav>

<!-- PRODUTO -->
<div class="produto-container" data-slug="<?= htmlspecialchars($slug) ?>">

    <div class="produto-grid">

        <!-- GALERIA -->
        <div class="produto-galeria">
            <div class="gallery-main">
                <img id="main-img" src="<?= $product['image'] ?? ($base . '/assets/images/placeholder.jpg') ?>" alt="<?= $product ? htmlspecialchars($product['name']) : '' ?>">
            </div>
            <div class="gallery-thumbs" id="gallery-thumbs"></div>
        </div>

        <!-- BUY BOX -->
        <div class="produto-buybox">

            <h1 class="product-title" id="p-name"><?= $product ? htmlspecialchars($product['name']) : '' ?></h1>

            <!-- Rating inline -->
            <div class="rating-inline" id="rating-inline">
                <span class="rating-stars" id="rating-stars"></span>
                <span class="rating-avg" id="rating-avg"></span>
                <span class="rating-count" id="rating-count"></span>
            </div>

            <hr class="produto-divider">

            <!-- Preço PIX -->
            <div class="preco-pix-wrap">
                <svg class="pix-icon" width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L6.5 7.5L9 10L12 7L15 10L17.5 7.5L12 2Z" fill="#ff6600"/>
                    <path d="M12 22L17.5 16.5L15 14L12 17L9 14L6.5 16.5L12 22Z" fill="#ff6600"/>
                    <path d="M2 12L7.5 6.5L10 9L7 12L10 15L7.5 17.5L2 12Z" fill="#ff6600"/>
                    <path d="M22 12L16.5 17.5L14 15L17 12L14 9L16.5 6.5L22 12Z" fill="#ff6600"/>
                </svg>
                <span class="pix-price" id="p-price-pix"></span>
            </div>
            <p class="pix-badge" id="p-pix-label">10% desconto no PIX</p>

            <!-- Preço cartão -->
            <div class="preco-cartao-wrap">
                <svg class="cartao-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <rect x="2" y="5" width="20" height="14" rx="2" stroke="#999" stroke-width="2"/>
                    <path d="M2 10h20" stroke="#999" stroke-width="2"/>
                </svg>
                <span class="card-price" id="p-price"></span>
            </div>

            <!-- Descrição curta -->
            <p class="produto-desc-curta" id="p-desc"></p>

            <!-- Estoque -->
            <p class="produto-estoque" id="p-stock"></p>

            <!-- Quantidade + Comprar -->
            <div class="produto-acoes">
                <div class="qty-wrap">
                    <button class="qty-btn" id="btn-qty-minus">−</button>
                    <input class="qty-input" id="qty-input" type="number" value="1" min="1" max="99">
                    <button class="qty-btn" id="btn-qty-plus">+</button>
                </div>
                <button class="btn-comprar" id="btn-add-cart">ADICIONAR NO CARRINHO</button>
            </div>

            <!-- Calculadora de frete -->
            <div class="frete-box">
                <p class="frete-label">Consulte prazo e valor de entrega</p>
                <div class="frete-input-wrap">
                    <span class="frete-icon">🚚</span>
                    <input class="cep-input" id="cep-input" type="text" maxlength="9" placeholder="Insira o seu CEP">
                    <button class="cep-btn" id="btn-calcular-frete">CALCULAR</button>
                </div>
                <div class="frete-result" id="frete-result"></div>
                <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank" rel="noopener" class="frete-nao-sei">Não sei meu CEP</a>
            </div>

        </div>
    </div>

    <!-- ABAS -->
    <section class="produto-tabs-section" id="produto-tabs">
        <div class="tabs-nav">
            <button class="tab-btn tab-btn-active" data-target="tab-descricao">Descrição</button>
            <button class="tab-btn" data-target="tab-avaliacoes">Avaliações <span class="tab-badge" id="review-count-badge"></span></button>
        </div>

        <div class="tabs-body">

            <!-- Descrição -->
            <div class="tab-panel" id="tab-descricao">
                <div class="product-description-rich" id="p-full-desc"></div>
            </div>

            <!-- Avaliações -->
            <div class="tab-panel tab-panel-hidden" id="tab-avaliacoes">

                <div class="reviews-summary" id="reviews-summary">
                    <div class="reviews-avg-box">
                        <p class="reviews-avg-num" id="reviews-avg">—</p>
                        <div class="reviews-avg-stars" id="reviews-avg-stars"></div>
                        <p class="reviews-total" id="reviews-total"></p>
                    </div>
                </div>

                <div class="reviews-list" id="reviews-list"></div>

                <!-- Formulário -->
                <div class="review-form">
                    <h3 class="review-form-title">Sua avaliação</h3>
                    <div class="star-picker" id="star-picker">
                        <button class="star-btn" data-star="1">★</button>
                        <button class="star-btn" data-star="2">★</button>
                        <button class="star-btn" data-star="3">★</button>
                        <button class="star-btn" data-star="4">★</button>
                        <button class="star-btn" data-star="5">★</button>
                    </div>
                    <input class="review-name-input" id="review-name" type="text" placeholder="Seu nome *">
                    <textarea class="review-comment-input" id="review-comment" rows="3" placeholder="Sua experiência com o produto (opcional)..."></textarea>
                    <button class="btn-review-submit" id="btn-submit-review">Enviar avaliação</button>
                    <p class="review-msg" id="review-msg"></p>
                </div>

            </div>
        </div>
    </section>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
