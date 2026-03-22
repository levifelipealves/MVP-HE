/* productCrud.js — Admin product CRUD */

(function () {
    'use strict';

    /* ------------------------------------------------------------------ */
    /* DOM references                                                       */
    /* ------------------------------------------------------------------ */
    const tbody          = document.getElementById('products-tbody');
    const btnNew         = document.getElementById('btn-new-product');
    const formSection    = document.getElementById('product-form-section');
    const form           = document.getElementById('product-form');
    const formTitle      = document.getElementById('product-form-title');
    const formError      = document.getElementById('product-form-error');
    const btnSave        = document.getElementById('btn-save-product');
    const btnCancelTop   = document.getElementById('btn-cancel-form');
    const btnCancelBot   = document.getElementById('btn-cancel-form-bottom');
    const logoutForm     = document.getElementById('admin-logout-form');

    const fieldName      = document.getElementById('field-name');
    const fieldSlug      = document.getElementById('field-slug');
    const fieldPrice     = document.getElementById('field-price');
    const fieldPricePix  = document.getElementById('field-price-pix');
    const fieldStock     = document.getElementById('field-stock');
    const fieldDesc      = document.getElementById('field-description');
    const fieldCategory  = document.getElementById('field-category-id');
    const fieldImage     = document.getElementById('field-image');

    /* ------------------------------------------------------------------ */
    /* Utilities                                                            */
    /* ------------------------------------------------------------------ */

    function slugify(str) {
        return str
            .toString()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s]+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    function formatPrice(value) {
        const num = parseFloat(value);
        if (isNaN(num)) return '—';
        return 'R$ ' + num.toFixed(2).replace('.', ',');
    }

    function apiFetch(path, options = {}) {
        return fetch(window.API_URL + path, {
            ...options,
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                ...(options.headers || {}),
            },
        });
    }

    function showFormError(msg) {
        formError.textContent = msg;
        formError.hidden = false;
    }

    function hideFormError() {
        formError.textContent = '';
        formError.hidden = true;
    }

    function setSaveLoading(loading) {
        btnSave.disabled = loading;
        btnSave.textContent = loading ? 'Salvando...' : 'Salvar Produto';
    }

    /* ------------------------------------------------------------------ */
    /* Load products                                                         */
    /* ------------------------------------------------------------------ */

    async function loadProducts() {
        tbody.innerHTML = '<tr><td class="admin-td admin-td-loading" colspan="6">Carregando...</td></tr>';

        try {
            const res = await apiFetch('/admin/products');

            if (res.status === 401) {
                window.location.href = window.BASE_URL + '/admin/login';
                return;
            }

            const data = await res.json();

            if (!res.ok) {
                tbody.innerHTML = '<tr><td class="admin-td admin-td-loading" colspan="6">Erro ao carregar produtos.</td></tr>';
                return;
            }

            renderTable(data.data || []);
        } catch (err) {
            tbody.innerHTML = '<tr><td class="admin-td admin-td-loading" colspan="6">Erro de conexão.</td></tr>';
        }
    }

    function renderTable(products) {
        if (products.length === 0) {
            tbody.innerHTML = '<tr><td class="admin-td admin-td-loading" colspan="6">Nenhum produto cadastrado.</td></tr>';
            return;
        }

        tbody.innerHTML = products.map(function (p) {
            const statusClass = p.is_active == 1 ? 'admin-status-badge-active' : 'admin-status-badge-inactive';
            const statusLabel = p.is_active == 1 ? 'Ativo' : 'Inativo';

            return '<tr>' +
                '<td class="admin-td">' + escHtml(p.name) + '</td>' +
                '<td class="admin-td">' + formatPrice(p.price) + '</td>' +
                '<td class="admin-td">' + formatPrice(p.price_pix) + '</td>' +
                '<td class="admin-td">' + (p.stock ?? 0) + '</td>' +
                '<td class="admin-td"><span class="admin-status-badge ' + statusClass + '">' + statusLabel + '</span></td>' +
                '<td class="admin-td admin-td-actions">' +
                    '<div class="admin-td-actions-group">' +
                        '<button class="admin-btn admin-btn-ghost admin-btn-sm" data-action="edit" data-id="' + p.id + '">Editar</button>' +
                        '<button class="admin-btn admin-btn-danger admin-btn-sm" data-action="delete" data-id="' + p.id + '">Excluir</button>' +
                    '</div>' +
                '</td>' +
            '</tr>';
        }).join('');
    }

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    /* ------------------------------------------------------------------ */
    /* Show / hide form                                                     */
    /* ------------------------------------------------------------------ */

    function showForm(product) {
        hideFormError();
        form.removeAttribute('data-id');

        if (product) {
            formTitle.textContent = 'Editar Produto';
            form.dataset.id       = product.id;
            fieldName.value       = product.name       || '';
            fieldSlug.value       = product.slug       || '';
            fieldPrice.value      = product.price      || '';
            fieldPricePix.value   = product.price_pix  || '';
            fieldStock.value      = product.stock      ?? 0;
            fieldDesc.value       = product.description || '';
            fieldCategory.value   = product.category_id || '';
            fieldImage.value      = product.image      || '';
        } else {
            formTitle.textContent = 'Novo Produto';
            form.reset();
        }

        formSection.hidden = false;
        formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        fieldName.focus();
    }

    function hideForm() {
        formSection.hidden = true;
        form.removeAttribute('data-id');
        form.reset();
        hideFormError();
    }

    /* ------------------------------------------------------------------ */
    /* Save product (create or update)                                      */
    /* ------------------------------------------------------------------ */

    async function saveProduct() {
        hideFormError();

        const name  = fieldName.value.trim();
        const slug  = fieldSlug.value.trim();
        const price = fieldPrice.value.trim();

        if (!name || !slug || price === '') {
            showFormError('Nome, slug e preço são obrigatórios.');
            return;
        }

        const body = {
            name,
            slug,
            price:       parseFloat(price),
            price_pix:   fieldPricePix.value !== '' ? parseFloat(fieldPricePix.value) : null,
            stock:       fieldStock.value !== '' ? parseInt(fieldStock.value, 10) : 0,
            description: fieldDesc.value.trim() || null,
            category_id: fieldCategory.value !== '' ? parseInt(fieldCategory.value, 10) : null,
            image:       fieldImage.value.trim() || null,
        };

        const editId = form.dataset.id;
        const isEdit = Boolean(editId);

        setSaveLoading(true);

        try {
            const res = await apiFetch(
                isEdit ? '/admin/products/' + editId : '/admin/products',
                { method: isEdit ? 'PUT' : 'POST', body: JSON.stringify(body) }
            );

            const data = await res.json();

            if (res.status === 401) {
                window.location.href = window.BASE_URL + '/admin/login';
                return;
            }

            if (!res.ok) {
                showFormError(data.error || 'Erro ao salvar produto.');
                return;
            }

            hideForm();
            loadProducts();
        } catch (err) {
            showFormError('Erro de conexão. Tente novamente.');
        } finally {
            setSaveLoading(false);
        }
    }

    /* ------------------------------------------------------------------ */
    /* Delete product                                                        */
    /* ------------------------------------------------------------------ */

    async function deleteProduct(id) {
        if (!confirm('Deseja desativar este produto?')) return;

        try {
            const res = await apiFetch('/admin/products/' + id, { method: 'DELETE' });

            if (res.status === 401) {
                window.location.href = window.BASE_URL + '/admin/login';
                return;
            }

            if (!res.ok) {
                const data = await res.json();
                alert(data.error || 'Erro ao excluir produto.');
                return;
            }

            loadProducts();
        } catch (err) {
            alert('Erro de conexão.');
        }
    }

    /* ------------------------------------------------------------------ */
    /* Fetch product for editing                                            */
    /* ------------------------------------------------------------------ */

    async function editProduct(id) {
        try {
            const res = await apiFetch('/admin/products');

            if (res.status === 401) {
                window.location.href = window.BASE_URL + '/admin/login';
                return;
            }

            const data = await res.json();
            const product = (data.data || []).find(function (p) { return p.id == id; });

            if (product) {
                showForm(product);
            }
        } catch (err) {
            alert('Erro ao carregar produto.');
        }
    }

    /* ------------------------------------------------------------------ */
    /* Logout                                                               */
    /* ------------------------------------------------------------------ */

    logoutForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        try {
            await apiFetch('/admin/logout', { method: 'POST' });
        } finally {
            window.location.href = window.BASE_URL + '/admin/login';
        }
    });

    /* ------------------------------------------------------------------ */
    /* Event listeners                                                      */
    /* ------------------------------------------------------------------ */

    btnNew.addEventListener('click', function () {
        showForm(null);
    });

    btnCancelTop.addEventListener('click', hideForm);
    btnCancelBot.addEventListener('click', hideForm);

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        saveProduct();
    });

    /* Auto-slug on name input (only when slug field is empty or matches previous auto-slug) */
    let lastAutoSlug = '';
    fieldName.addEventListener('input', function () {
        const auto = slugify(fieldName.value);
        if (fieldSlug.value === '' || fieldSlug.value === lastAutoSlug) {
            fieldSlug.value = auto;
            lastAutoSlug    = auto;
        }
    });

    /* Table click delegation */
    tbody.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;

        const action = btn.dataset.action;
        const id     = btn.dataset.id;

        if (action === 'edit')   editProduct(id);
        if (action === 'delete') deleteProduct(id);
    });

    /* ------------------------------------------------------------------ */
    /* Init                                                                 */
    /* ------------------------------------------------------------------ */

    loadProducts();

})();
