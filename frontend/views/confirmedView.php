<?php
$title    = 'Pedido Confirmado | Geek Heroes';
$page_css = 'confirmed.css';
$page_js  = 'confirmed.js';
require __DIR__ . '/layout/header.php';
?>
<div id="order-summary" data-order-id="<?= (int)($order_id ?? 0) ?>">
    <div class="loading">Carregando...</div>
</div>
<?php require __DIR__ . '/layout/footer.php'; ?>
