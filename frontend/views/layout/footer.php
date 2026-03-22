<?php $cfg = require dirname(__DIR__, 2) . '/config.php'; ?>
<?php
$wppLink   = $cfg['store_whatsapp'] ? 'https://wa.me/' . preg_replace('/\D/', '', $cfg['store_whatsapp']) : '#';
$instaLink = $cfg['store_instagram'] ?: '#';
?>
</main>

<footer class="main-footer">
    <div class="footer-bg-wrap">
        <div class="footer-bg-img">
            <img src="<?= $base ?>/assets/images/background-footer.png" alt="">
        </div>

        <div class="footer-container">
            <div class="footer-logo-wrap">
                <img src="<?= $base ?>/assets/images/logo-maior.png" alt="<?= htmlspecialchars($cfg['store_name']) ?>" class="footer-logo-img">
            </div>

            <div class="footer-white-box">
                <div class="footer-grid">

                    <div>
                        <h3 class="footer-section-title">Institucional</h3>
                        <ul class="footer-list">
                            <li><a href="<?= $base ?>/about">Quem Somos</a></li>
                            <li><a href="<?= $base ?>/returns">Políticas de Trocas</a></li>
                            <li><a href="<?= $base ?>/privacy">Privacidade</a></li>
                            <li><a href="<?= $base ?>/terms">Termos de Uso</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="footer-section-title">Atendimento</h3>
                        <div class="footer-contact-group">
                            <?php if ($cfg['store_phone']): ?>
                            <div class="footer-contact-link">
                                <a href="<?= htmlspecialchars($wppLink) ?>" target="_blank" rel="noopener" class="footer-wpp-link">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#25D366">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.117 1.528 5.845L.057 23.571a.75.75 0 0 0 .92.92l5.726-1.471A11.943 11.943 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.7-.503-5.254-1.385l-.376-.217-3.898 1.001 1.001-3.898-.217-.376A9.956 9.956 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                                    </svg>
                                    <?= htmlspecialchars($cfg['store_phone']) ?>
                                </a>
                            </div>
                            <?php endif; ?>
                            <?php if ($cfg['store_email']): ?>
                            <div class="footer-contact-link">
                                <a href="mailto:<?= htmlspecialchars($cfg['store_email']) ?>">✉ <?= htmlspecialchars($cfg['store_email']) ?></a>
                            </div>
                            <?php endif; ?>
                            <p class="footer-time-text">Segunda à Sexta: 09h às 18h</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="footer-section-title">Pagamento</h3>
                        <div class="footer-payment-badge-wrap">
                            <img src="<?= $base ?>/assets/images/ssl.png" alt="SSL Seguro" class="footer-payment-badge-img">
                            <p class="footer-payment-secure-text">COMPRA 100% SEGURA</p>
                        </div>
                        <p class="footer-payment-methods">Visa, MasterCard, Pix, Boleto</p>
                    </div>

                    <div>
                        <h3 class="footer-section-title">Redes Sociais</h3>
                        <div class="footer-social-list">
                            <a href="<?= htmlspecialchars($instaLink) ?>" target="_blank" rel="noopener" aria-label="Instagram" class="footer-social-btn footer-insta-btn">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="white">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <p class="footer-bottom-text">
                2026 © <?= htmlspecialchars($cfg['store_name']) ?> — <?= htmlspecialchars($cfg['store_address']) ?> — CNPJ: <?= htmlspecialchars($cfg['store_cnpj']) ?>
            </p>
        </div>
    </div>
</footer>

<script src="<?= $base ?>/assets/js/cart.js"></script>
<?php if (!empty($page_js)): ?>
<script src="<?= $base ?>/assets/js/<?= htmlspecialchars($page_js) ?>"></script>
<?php endif; ?>
</body>
</html>
