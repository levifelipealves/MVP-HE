<?php
$title    = 'Termos de Uso | Geek Heroes';
$page_css = 'institutional.css';
require __DIR__ . '/layout/header.php';
?>
<main>
<div class="institutional-page">

    <nav class="institutional-breadcrumb">
        <a href="<?= $base ?>/">Home</a>
        <span>/</span>
        <span>Termos de Uso</span>
    </nav>

    <div class="institutional-card">

        <h1 class="institutional-title">Termos de Uso</h1>
        <div class="institutional-divider"></div>

        <div class="institutional-body">

            <p>Ao utilizar o site da <strong>Geek Heroes</strong>, você concorda com os termos e condições descritos
               abaixo. Leia atentamente antes de realizar qualquer compra.</p>

            <div class="institutional-section">
                <h2 class="institutional-section-title">1. Uso do Site</h2>
                <p>O site é destinado exclusivamente para uso pessoal e não comercial. É proibido utilizar qualquer
                   conteúdo do site sem autorização prévia por escrito da Geek Heroes.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">2. Cadastro e Conta</h2>
                <p>Para realizar compras, o cliente pode utilizar o modo convidado. O cliente é responsável pela
                   veracidade das informações fornecidas.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">3. Preços e Disponibilidade</h2>
                <p>Os preços podem ser alterados sem aviso prévio. A disponibilidade dos produtos está sujeita ao
                   estoque. Em caso de divergência de preço, o cliente será consultado antes da confirmação do pedido.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">4. Pagamento</h2>
                <p>Aceitamos cartão de crédito, débito, PIX e boleto bancário. Todos os pagamentos são processados de
                   forma segura por gateways certificados. O pedido é confirmado apenas após aprovação do pagamento.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">5. Entrega</h2>
                <p>Os prazos de entrega são estimativas fornecidas pela transportadora. A Geek Heroes não se
                   responsabiliza por atrasos causados por motivos de força maior ou falhas dos Correios/transportadoras.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">6. Propriedade Intelectual</h2>
                <p>Todo o conteúdo do site (imagens, textos, logotipos) é protegido por direitos autorais. Os nomes e
                   imagens de personagens são marcas registradas de seus respectivos detentores.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">7. Limitação de Responsabilidade</h2>
                <p>A Geek Heroes não se responsabiliza por danos indiretos decorrentes do uso do site ou dos produtos
                   adquiridos, exceto nos casos previstos pelo Código de Defesa do Consumidor.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">8. Foro</h2>
                <p>Fica eleito o foro da Comarca de Peruíbe – SP para dirimir quaisquer controvérsias decorrentes
                   destes termos.</p>
            </div>

            <p class="institutional-footer-note">Última atualização: Janeiro de 2026.</p>

        </div>
    </div>

</div>
</main>
<?php require __DIR__ . '/layout/footer.php'; ?>
