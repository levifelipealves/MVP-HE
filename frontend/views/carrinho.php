<?php
$title    = 'Carrinho | Geek Heroes';
$page_css = 'carrinho.css';
$page_js  = 'carrinho.js';
require __DIR__ . '/layout/header.php';
?>
<div class="cart-page">
    <h1>Meu Carrinho</h1>
    <div id="cart-container">
        <div class="loading">Carregando...</div>
    </div>
</div>
<?php require __DIR__ . '/layout/footer.php'; ?>
