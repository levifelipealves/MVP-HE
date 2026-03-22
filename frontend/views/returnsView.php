<?php
$title    = 'Políticas de Trocas e Devoluções | Geek Heroes';
$page_css = 'institutional.css';
require __DIR__ . '/layout/header.php';
?>
<main>
<div class="institutional-page">

    <nav class="institutional-breadcrumb">
        <a href="<?= $base ?>/">Home</a>
        <span>/</span>
        <span>Políticas de Trocas</span>
    </nav>

    <div class="institutional-card">

        <h1 class="institutional-title">Políticas de Trocas e Devoluções</h1>
        <div class="institutional-divider"></div>

        <div class="institutional-body">

            <div class="institutional-section">
                <h2 class="institutional-section-title">1. Prazo para Troca ou Devolução</h2>
                <p>O cliente tem até <strong>7 dias corridos</strong> após o recebimento do produto para solicitar troca
                   ou devolução, conforme o Código de Defesa do Consumidor (Art. 49).</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">2. Condições para Troca</h2>
                <ul>
                    <li>Produto deve estar em sua embalagem original, sem sinais de uso.</li>
                    <li>Todos os acessórios, manuais e brindes originais devem estar presentes.</li>
                    <li>O produto não deve ter sido montado, pintado ou customizado.</li>
                    <li>Nota fiscal de compra obrigatória.</li>
                </ul>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">3. Produtos com Defeito</h2>
                <p>Em caso de defeito de fabricação, realizamos a troca sem custo ao cliente. Entre em contato via
                   <a href="mailto:sac@geekheroes.com.br">sac@geekheroes.com.br</a> ou
                   <a href="tel:+5513981978470">(13) 98197-8470</a> para iniciar o processo.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">4. Custos de Frete</h2>
                <p>O frete de devolução será custeado pela Geek Heroes em casos de defeito de fabricação ou erro no
                   envio. Nos demais casos, o frete de retorno é de responsabilidade do cliente.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">5. Reembolso</h2>
                <p>Após aprovação da devolução, o reembolso será realizado em até <strong>10 dias úteis</strong> via
                   estorno no cartão de crédito ou depósito bancário/PIX.</p>
            </div>

        </div>

        <div class="returns-contact-box">
            <strong>Dúvidas? Fale conosco:</strong><br>
            ✉ <a href="mailto:sac@geekheroes.com.br">sac@geekheroes.com.br</a>
            &nbsp;|&nbsp;
            📞 <a href="tel:+5513981978470">(13) 98197-8470</a>
        </div>

    </div>

</div>
</main>
<?php require __DIR__ . '/layout/footer.php'; ?>
