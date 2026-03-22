<?php $cfg = require dirname(__DIR__, 2) . '/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? ($cfg['store_name'] . ' — Colecionáveis e Action Figures')) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? 'Geek Heroes — Loja especializada em action figures, Funko Pop, mangás e colecionáveis.') ?>">
    <?php if (!empty($canonical)): ?>
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>">
    <?php endif; ?>
    <?php if (!empty($og)): ?>
    <meta property="og:title"       content="<?= htmlspecialchars($og['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($og['description'] ?? '') ?>">
    <meta property="og:image"       content="<?= htmlspecialchars($og['image'] ?? '') ?>">
    <meta property="og:type"        content="<?= htmlspecialchars($og['type'] ?? 'website') ?>">
    <meta property="og:site_name"   content="<?= htmlspecialchars($cfg['store_name']) ?>">
    <?php endif; ?>

    <link rel="stylesheet" href="<?= $base ?>/assets/css/tokens.css">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/footer.css">
    <?php if (!empty($page_css)): ?>
    <link rel="stylesheet" href="<?= $base ?>/assets/css/<?= htmlspecialchars($page_css) ?>">
    <?php endif; ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        window.API_URL  = '<?= API_URL ?>';
        window.BASE_URL = '<?= $base ?>';
    </script>
</head>
<body>

<!-- TOP BANNER -->
<div class="site-banner">
    <?= $cfg['banner_text'] ?>
</div>

<!-- MAIN HEADER -->
<header class="main-header">
    <div class="header-bg">
        <img src="<?= $base ?>/assets/images/header-background.png" alt="">
    </div>
    <div class="header-container">

        <a href="<?= $base ?>/" class="header-logo-link">
            <img src="<?= $base ?>/assets/images/logo-maior.png" alt="<?= htmlspecialchars($cfg['store_name']) ?>" class="header-logo-img">
        </a>

        <div class="header-search-box">
            <input type="text" id="search-input" placeholder="Pesquisa..." class="header-search-input">
            <button id="search-btn" class="header-search-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
            </button>
        </div>

        <div class="header-actions-group">

            <a href="<?= $base ?>/cart" class="header-icon-btn header-cart-btn">
                <div class="icon-circle">
                    <svg width="22" height="22" viewBox="0 0 48 48" fill="currentColor">
                        <path d="M14.35 43.95q-1.5 0-2.55-1.05-1.05-1.05-1.05-2.55 0-1.5 1.05-2.55 1.05-1.05 2.55-1.05 1.5 0 2.55 1.05 1.05 1.05 1.05 2.55 0 1.5-1.05 2.55-1.05 1.05-2.55 1.05Zm20 0q-1.5 0-2.55-1.05-1.05-1.05-1.05-2.55 0-1.5 1.05-2.55 1.05-1.05 2.55-1.05 1.5 0 2.55 1.05 1.05 1.05 1.05 2.55 0 1.5-1.05 2.55-1.05 1.05-2.55 1.05Zm-22.6-33 5.5 11.4h14.4l6.25-11.4Zm-1.5-3H39.7q1.15 0 1.75 1.05.6 1.05 0 2.1L34.7 23.25q-.55.95-1.425 1.525t-1.925.575H16.2l-2.8 5.2h24.55v3h-24.1q-2.1 0-3.025-1.4-.925-1.4.025-3.15l3.2-5.9L6.45 7h-3.9V4H8.4Zm7 14.4h14.4Z"/>
                    </svg>
                    <span id="cart-count-badge" class="cart-count">0</span>
                </div>
                <span id="cart-total-badge" class="cart-total-badge">R$ 0,00</span>
            </a>

        </div>
    </div>
</header>

<main>
