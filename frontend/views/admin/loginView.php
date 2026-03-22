<?php
$title    = 'Admin — Login';
$page_css = 'adminLogin.css';
$page_js  = 'adminLogin.js';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="<?= $base ?>/assets/css/tokens.css">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/<?= $page_css ?>">
    <script>
        window.API_URL  = '<?= API_URL ?>';
        window.BASE_URL = '<?= $base ?>';
    </script>
</head>
<body>

<div class="admin-login-wrapper">
    <div class="admin-login-card">
        <div class="admin-login-header">
            <h1 class="admin-login-title">Painel Admin</h1>
            <p class="admin-login-subtitle">Digite sua senha para continuar</p>
        </div>

        <form id="admin-login-form" class="admin-login-form" novalidate>
            <div class="admin-login-field">
                <label for="admin-password" class="admin-login-label">Senha</label>
                <input
                    type="password"
                    id="admin-password"
                    name="password"
                    class="admin-login-input"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                >
            </div>

            <div id="admin-login-error" class="admin-login-error" role="alert" hidden></div>

            <button type="submit" id="admin-login-btn" class="admin-login-btn">
                Entrar
            </button>
        </form>
    </div>
</div>

<script src="<?= $base ?>/assets/js/<?= $page_js ?>"></script>
</body>
</html>
