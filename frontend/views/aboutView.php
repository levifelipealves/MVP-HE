<?php
$title    = 'Quem Somos | Geek Heroes';
$page_css = 'institutional.css';
require __DIR__ . '/layout/header.php';
?>
<main>
<div class="institutional-page">

    <nav class="institutional-breadcrumb">
        <a href="<?= $base ?>/">Home</a>
        <span>/</span>
        <span>Quem Somos</span>
    </nav>

    <div class="institutional-card">

        <h1 class="institutional-title">Quem Somos</h1>
        <div class="institutional-divider"></div>

        <div class="institutional-body">
            <p>A <strong>Geek Heroes</strong> é uma loja especializada em colecionáveis, action figures, funko pops e
               itens da cultura pop, localizada no coração de Peruíbe – SP.</p>
            <p>Nascemos da paixão por personagens icônicos, séries, filmes e jogos que marcaram gerações. Nossa missão
               é trazer para os fãs as melhores peças colecionáveis com atendimento personalizado, preços justos e a
               curadoria que só quem realmente ama esse universo consegue oferecer.</p>
            <p>Trabalhamos com marcas renomadas como <strong>Hasbro, Funko, Hot Toys, Bandai, McFarlane Toys</strong> e
               muitas outras, garantindo autenticidade e qualidade em cada produto.</p>
            <p>Venha nos visitar na <strong>Praça Ambrósio Baldim, Loja 08 – Centro, Peruíbe – SP</strong>, ou navegue
               pelo nosso catálogo online. Seja bem-vindo ao mundo dos heróis!</p>
        </div>

        <div class="about-values-grid">
            <div class="about-values-card">
                <div class="about-values-icon">🎯</div>
                <h3 class="about-values-title">Missão</h3>
                <p class="about-values-text">Conectar fãs às melhores peças colecionáveis com paixão e qualidade.</p>
            </div>
            <div class="about-values-card">
                <div class="about-values-icon">🏆</div>
                <h3 class="about-values-title">Visão</h3>
                <p class="about-values-text">Ser referência em colecionáveis no litoral paulista e no e-commerce nacional.</p>
            </div>
            <div class="about-values-card">
                <div class="about-values-icon">💚</div>
                <h3 class="about-values-title">Valores</h3>
                <p class="about-values-text">Autenticidade, atendimento humanizado e amor pela cultura geek.</p>
            </div>
        </div>

    </div>

</div>
</main>
<?php require __DIR__ . '/layout/footer.php'; ?>
