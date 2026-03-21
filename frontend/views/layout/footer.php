</main>
<footer class="site-footer">
    <div class="footer-inner">
        <p>&copy; <?= date('Y') ?> Geek Heroes. Todos os direitos reservados.</p>
    </div>
</footer>
<script src="<?= $base ?>/assets/js/cart.js"></script>
<?php if (!empty($page_js)): ?>
<script src="<?= $base ?>/assets/js/<?= htmlspecialchars($page_js) ?>"></script>
<?php endif; ?>
</body>
</html>
