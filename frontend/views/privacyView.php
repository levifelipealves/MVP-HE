<?php
$title    = 'Políticas de Privacidade | Geek Heroes';
$page_css = 'institutional.css';
require __DIR__ . '/layout/header.php';
?>
<main>
<div class="institutional-page">

    <nav class="institutional-breadcrumb">
        <a href="<?= $base ?>/">Home</a>
        <span>/</span>
        <span>Políticas de Privacidade</span>
    </nav>

    <div class="institutional-card">

        <h1 class="institutional-title">Políticas de Privacidade</h1>
        <div class="institutional-divider"></div>

        <div class="institutional-body">

            <p>A <strong>Geek Heroes</strong> (CNPJ: 53.489.012/0001-98) respeita a sua privacidade e está comprometida
               com a proteção dos seus dados pessoais, em conformidade com a Lei Geral de Proteção de Dados
               (LGPD – Lei nº 13.709/2018).</p>

            <div class="institutional-section">
                <h2 class="institutional-section-title">1. Dados que Coletamos</h2>
                <ul>
                    <li>Nome, e-mail, telefone e endereço (para cadastro e entrega).</li>
                    <li>Dados de pagamento (processados de forma segura por gateways certificados).</li>
                    <li>Histórico de compras e preferências de navegação.</li>
                    <li>Endereço IP e dados de acesso para segurança e análise.</li>
                </ul>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">2. Como Usamos seus Dados</h2>
                <ul>
                    <li>Processamento de pedidos e entregas.</li>
                    <li>Comunicação sobre pedidos, promoções e novidades (com seu consentimento).</li>
                    <li>Melhoria da experiência de navegação e personalização.</li>
                    <li>Cumprimento de obrigações legais e fiscais.</li>
                </ul>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">3. Compartilhamento de Dados</h2>
                <p>Não vendemos seus dados. Compartilhamos apenas com parceiros essenciais: operadoras de pagamento,
                   transportadoras e serviços de marketing autorizados, todos sob acordo de confidencialidade.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">4. Seus Direitos (LGPD)</h2>
                <ul>
                    <li>Acesso aos seus dados pessoais.</li>
                    <li>Correção de dados incompletos ou desatualizados.</li>
                    <li>Exclusão de dados desnecessários.</li>
                    <li>Portabilidade e revogação do consentimento.</li>
                </ul>
                <p>Para exercer seus direitos, entre em contato:
                   <a href="mailto:sac@geekheroes.com.br">sac@geekheroes.com.br</a></p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">5. Segurança</h2>
                <p>Utilizamos criptografia SSL, acesso restrito e boas práticas de segurança para proteger seus dados
                   contra acessos não autorizados.</p>
            </div>

            <div class="institutional-section">
                <h2 class="institutional-section-title">6. Cookies</h2>
                <p>Utilizamos cookies para melhorar sua navegação. Você pode desativá-los nas configurações do seu
                   navegador, mas isso pode afetar algumas funcionalidades do site.</p>
            </div>

            <p class="institutional-footer-note">Última atualização: Janeiro de 2026.</p>

        </div>
    </div>

</div>
</main>
<?php require __DIR__ . '/layout/footer.php'; ?>
