<?php
$title    = 'Checkout | Geek Heroes';
$page_css = 'checkout.css';
$page_js  = 'checkout.js';
require __DIR__ . '/layout/header.php';
?>
<div class="checkout-page">
    <h1>Finalizar Pedido</h1>
    <div class="checkout-grid">
        <form id="checkout-form" class="checkout-form" novalidate>
            <h2>Seus Dados</h2>
            <div class="form-group">
                <label for="name">Nome completo *</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail *</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="tel" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" maxlength="14">
            </div>
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" maxlength="9">
            </div>
            <div class="form-group">
                <label for="address">Endereço completo *</label>
                <textarea id="address" name="address" rows="3" required></textarea>
            </div>
            <div id="form-error" class="form-error" hidden></div>
            <button type="submit" class="btn-primary" id="submit-btn">Confirmar Pedido</button>
        </form>
        <aside class="order-summary">
            <h2>Resumo</h2>
            <div id="summary-items"><div class="loading">Carregando...</div></div>
            <div class="summary-total">
                <span>Total</span>
                <strong id="summary-total">—</strong>
            </div>
        </aside>
    </div>
</div>
<?php require __DIR__ . '/layout/footer.php'; ?>
