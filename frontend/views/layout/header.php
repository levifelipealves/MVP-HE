<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Geek Heroes') ?></title>
    <?php if (!empty($meta_description)): ?>
    <meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
    <?php endif; ?>
    <?php if (!empty($canonical)): ?>
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>">
    <?php endif; ?>
    <?php if (!empty($og)): ?>
    <meta property="og:title"       content="<?= htmlspecialchars($og['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($og['description'] ?? '') ?>">
    <meta property="og:image"       content="<?= htmlspecialchars($og['image'] ?? '') ?>">
    <meta property="og:type"        content="<?= htmlspecialchars($og['type'] ?? 'website') ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= $base ?>/assets/css/base.css">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/layout.css">
    <?php if (!empty($page_css)): ?>
    <link rel="stylesheet" href="<?= $base ?>/assets/css/<?= htmlspecialchars($page_css) ?>">
    <?php endif; ?>
    <script>
        window.API_URL  = '<?= API_URL ?>';
        window.BASE_URL = '<?= $base ?>';
    </script>
</head>
<body>
<header class="site-header">
    <div class="header-inner">
        <a href="<?= $base ?>/" class="header-logo">
            <img src="<?= $base ?>/assets/images/logo-maior.png" alt="Geek Heroes">
        </a>
        <nav class="header-nav">
            <a href="<?= $base ?>/">Home</a>
        </nav>
        <div class="header-actions">
            <a href="<?= $base ?>/carrinho" class="cart-btn">
                🛒 <span id="cart-count">0</span>
            </a>
        </div>
    </div>
</header>
<main>
