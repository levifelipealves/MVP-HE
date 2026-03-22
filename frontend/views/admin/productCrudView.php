<?php
$title    = 'Admin — Produtos';
$page_css = 'productCrud.css';
$page_js  = 'productCrud.js';
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

<div class="admin-layout">

    <header class="admin-topbar">
        <div class="admin-topbar-inner">
            <h1 class="admin-topbar-title">Painel Admin — Produtos</h1>
            <form id="admin-logout-form" class="admin-logout-form" method="post">
                <button type="submit" class="admin-logout-btn">Sair</button>
            </form>
        </div>
    </header>

    <main class="admin-main">

        <section class="admin-products-section">
            <div class="admin-section-toolbar">
                <h2 class="admin-section-title">Lista de Produtos</h2>
                <button id="btn-new-product" class="admin-btn admin-btn-primary">+ Novo Produto</button>
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-products-table" id="products-table">
                    <thead>
                        <tr>
                            <th class="admin-th">Nome</th>
                            <th class="admin-th">Preço</th>
                            <th class="admin-th">Preço PIX</th>
                            <th class="admin-th">Estoque</th>
                            <th class="admin-th">Status</th>
                            <th class="admin-th admin-th-actions">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="products-tbody">
                        <tr>
                            <td class="admin-td admin-td-loading" colspan="6">Carregando...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="product-form-section" class="admin-form-section" hidden>
            <div class="admin-form-card">
                <div class="admin-form-card-header">
                    <h2 id="product-form-title" class="admin-form-title">Novo Produto</h2>
                    <button id="btn-cancel-form" class="admin-btn admin-btn-ghost">Cancelar</button>
                </div>

                <form id="product-form" class="admin-product-form" novalidate>

                    <div class="admin-form-row">
                        <div class="admin-form-field">
                            <label for="field-name" class="admin-form-label">Nome <span class="admin-form-required">*</span></label>
                            <input type="text" id="field-name" name="name" class="admin-form-input" required>
                        </div>
                        <div class="admin-form-field">
                            <label for="field-slug" class="admin-form-label">Slug <span class="admin-form-required">*</span></label>
                            <input type="text" id="field-slug" name="slug" class="admin-form-input" required>
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-form-field">
                            <label for="field-price" class="admin-form-label">Preço <span class="admin-form-required">*</span></label>
                            <input type="number" id="field-price" name="price" class="admin-form-input" step="0.01" min="0" required>
                        </div>
                        <div class="admin-form-field">
                            <label for="field-price-pix" class="admin-form-label">Preço PIX</label>
                            <input type="number" id="field-price-pix" name="price_pix" class="admin-form-input" step="0.01" min="0">
                        </div>
                        <div class="admin-form-field">
                            <label for="field-stock" class="admin-form-label">Estoque</label>
                            <input type="number" id="field-stock" name="stock" class="admin-form-input" min="0" value="0">
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-form-field admin-form-field-full">
                            <label for="field-description" class="admin-form-label">Descrição</label>
                            <textarea id="field-description" name="description" class="admin-form-textarea" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-form-field">
                            <label for="field-category-id" class="admin-form-label">ID da Categoria</label>
                            <input type="number" id="field-category-id" name="category_id" class="admin-form-input" min="1">
                        </div>
                        <div class="admin-form-field">
                            <label for="field-image" class="admin-form-label">URL da Imagem</label>
                            <input type="text" id="field-image" name="image" class="admin-form-input">
                        </div>
                    </div>

                    <div id="product-form-error" class="admin-form-error" role="alert" hidden></div>

                    <div class="admin-form-actions">
                        <button type="button" id="btn-cancel-form-bottom" class="admin-btn admin-btn-ghost">Cancelar</button>
                        <button type="submit" id="btn-save-product" class="admin-btn admin-btn-primary">Salvar Produto</button>
                    </div>

                </form>
            </div>
        </section>

    </main>
</div>

<script src="<?= $base ?>/assets/js/<?= $page_js ?>"></script>
</body>
</html>
