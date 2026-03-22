// produto.js — detalhe do produto

(function () {
    const API  = window.API_URL;
    const BASE = window.BASE_URL;
    let productId = null;
    let reviewRating = 0;

    function money(v) {
        return 'R$ ' + Number(v).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function stars(n, total = 5) {
        return '★'.repeat(n) + '☆'.repeat(total - n);
    }

    // ── Produto ──────────────────────────────────────────────────────────
    async function loadProduct() {
        const container = document.querySelector('.produto-container');
        if (!container) return;
        const slug = container.dataset.slug;

        const res  = await fetch(`${API}/products/${slug}`);
        const json = await res.json();
        if (!res.ok) return;

        const p   = json.data;
        productId = p.id;

        // Breadcrumb
        const catEl = document.getElementById('breadcrumb-cat-name');
        if (catEl && p.category) catEl.textContent = p.category;
        const prodEl = document.getElementById('breadcrumb-product-name');
        if (prodEl) prodEl.textContent = p.name;

        // Título
        const nameEl = document.getElementById('p-name');
        if (nameEl) nameEl.textContent = p.name;

        // Imagem
        const img = document.getElementById('main-img');
        if (img) {
            img.src = p.image || (BASE + '/assets/images/placeholder.jpg');
            img.alt = p.name;
        }

        // Preços
        const pixEl   = document.getElementById('p-price-pix');
        const cardEl  = document.getElementById('p-price');
        const pixBadge = document.getElementById('p-pix-label');
        if (p.price_pix) {
            if (pixEl)   pixEl.textContent  = money(p.price_pix);
            if (pixBadge) pixBadge.classList.add('visible');
        }
        if (cardEl) cardEl.textContent = money(p.price);

        // Descrição curta
        const descEl = document.getElementById('p-desc');
        if (descEl) descEl.textContent = p.description ? p.description.substring(0, 200) : '';

        // Descrição completa na aba
        const fullDescEl = document.getElementById('p-full-desc');
        if (fullDescEl) fullDescEl.innerHTML = p.description || '<p>Sem descrição disponível.</p>';

        // Estoque
        const stockEl = document.getElementById('p-stock');
        if (stockEl) {
            stockEl.textContent = p.stock > 0 ? `${p.stock} em estoque` : 'Esgotado';
            stockEl.style.color = p.stock > 0 ? '#16a34a' : '#dc2626';
        }

        // Botão comprar
        const btnAdd = document.getElementById('btn-add-cart');
        if (btnAdd && p.stock === 0) {
            btnAdd.disabled = true;
            btnAdd.textContent = 'ESGOTADO';
        }

        // Reviews
        loadReviews(p.id);
    }

    // ── Quantidade ───────────────────────────────────────────────────────
    function initQty() {
        const input   = document.getElementById('qty-input');
        const btnMais = document.getElementById('btn-qty-plus');
        const btnMenos = document.getElementById('btn-qty-minus');
        if (!input) return;

        btnMais?.addEventListener('click', () => {
            input.value = Math.min(99, (parseInt(input.value) || 1) + 1);
        });
        btnMenos?.addEventListener('click', () => {
            input.value = Math.max(1, (parseInt(input.value) || 1) - 1);
        });
    }

    // ── Adicionar ao carrinho ─────────────────────────────────────────────
    function initAddToCart() {
        const btn = document.getElementById('btn-add-cart');
        if (!btn) return;
        btn.addEventListener('click', () => {
            const qty = parseInt(document.getElementById('qty-input')?.value) || 1;
            Cart.add(productId, qty);
            const orig = btn.textContent;
            btn.textContent = '✓ ADICIONADO!';
            btn.style.background = '#16a34a';
            setTimeout(() => {
                btn.textContent = orig;
                btn.style.background = '';
            }, 1500);
        });
    }

    // ── Frete ────────────────────────────────────────────────────────────
    function initFrete() {
        const btn    = document.getElementById('btn-calcular-frete');
        const input  = document.getElementById('cep-input');
        const result = document.getElementById('frete-result');
        if (!btn) return;

        // Máscara CEP
        input?.addEventListener('input', () => {
            let v = input.value.replace(/\D/g, '').substring(0, 8);
            if (v.length > 5) v = v.substring(0, 5) + '-' + v.substring(5);
            input.value = v;
        });

        btn.addEventListener('click', async () => {
            const cep = input?.value.replace(/\D/g, '');
            if (!cep || cep.length < 8) {
                result.textContent = 'Informe um CEP válido.';
                return;
            }
            result.textContent = 'Consultando...';
            try {
                const res  = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await res.json();
                if (data.erro) { result.textContent = 'CEP não encontrado.'; return; }
                result.innerHTML = `📍 ${data.localidade} — ${data.uf}<br><strong>Entrega estimada: 5 a 10 dias úteis</strong>`;
            } catch {
                result.textContent = 'Falha na consulta. Tente novamente.';
            }
        });
    }

    // ── Abas ─────────────────────────────────────────────────────────────
    function initTabs() {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('tab-btn-active'));
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('tab-panel-hidden'));
                btn.classList.add('tab-btn-active');
                document.getElementById(btn.dataset.target)?.classList.remove('tab-panel-hidden');
            });
        });
    }

    // ── Reviews ───────────────────────────────────────────────────────────
    async function loadReviews(id) {
        const res  = await fetch(`${API}/reviews/${id}`);
        const json = await res.json();
        if (!res.ok) return;

        const { reviews, summary } = json;

        // Badge na aba
        const badge = document.getElementById('review-count-badge');
        if (badge && summary.total > 0) badge.textContent = summary.total;

        // Rating inline (topo)
        if (summary.total > 0) {
            const avg = Math.round(summary.average);
            document.getElementById('rating-stars').textContent = stars(avg);
            document.getElementById('rating-avg').textContent   = summary.average.toFixed(1);
            document.getElementById('rating-count').textContent = `(${summary.total} avaliações)`;

            // Resumo na aba
            document.getElementById('reviews-avg').textContent      = summary.average.toFixed(1);
            document.getElementById('reviews-avg-stars').textContent = stars(avg);
            document.getElementById('reviews-total').textContent     = `${summary.total} avaliações`;
        }

        // Lista
        const list = document.getElementById('reviews-list');
        if (!list) return;
        if (!reviews.length) {
            list.innerHTML = '<p class="review-empty">Nenhuma avaliação ainda. Seja o primeiro!</p>';
            return;
        }
        list.innerHTML = reviews.map(r => `
            <div class="review-item">
                <div class="review-header">
                    <span class="review-author">${r.author_name}</span>
                    <span class="review-date">${new Date(r.created_at).toLocaleDateString('pt-BR')}</span>
                </div>
                <div class="review-stars">${stars(r.rating)}</div>
                ${r.comment ? `<p class="review-text">${r.comment}</p>` : ''}
            </div>
        `).join('');
    }

    // ── Estrelas interativas ──────────────────────────────────────────────
    function initStarPicker() {
        document.querySelectorAll('.star-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                reviewRating = parseInt(btn.dataset.star);
                document.querySelectorAll('.star-btn').forEach(b => {
                    b.classList.toggle('selected', parseInt(b.dataset.star) <= reviewRating);
                });
            });
        });
    }

    // ── Enviar avaliação ──────────────────────────────────────────────────
    function initReviewForm() {
        const btn = document.getElementById('btn-submit-review');
        if (!btn) return;
        btn.addEventListener('click', async () => {
            const msg     = document.getElementById('review-msg');
            const name    = document.getElementById('review-name')?.value.trim();
            const comment = document.getElementById('review-comment')?.value.trim();

            if (!reviewRating) {
                msg.textContent = '⚠️ Selecione uma nota.';
                msg.className   = 'review-msg review-msg-err';
                return;
            }
            if (!name) {
                msg.textContent = '⚠️ Informe seu nome.';
                msg.className   = 'review-msg review-msg-err';
                return;
            }

            btn.disabled = true;
            try {
                const res = await fetch(`${API}/reviews/${productId}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ author_name: name, rating: reviewRating, comment }),
                });
                const json = await res.json();
                if (res.ok) {
                    msg.textContent = '✅ Avaliação enviada com sucesso!';
                    msg.className   = 'review-msg review-msg-ok';
                    document.getElementById('review-name').value    = '';
                    document.getElementById('review-comment').value = '';
                    reviewRating = 0;
                    document.querySelectorAll('.star-btn').forEach(b => b.classList.remove('selected'));
                    loadReviews(productId);
                } else {
                    msg.textContent = json.error || 'Erro ao enviar.';
                    msg.className   = 'review-msg review-msg-err';
                }
            } catch {
                msg.textContent = 'Falha na conexão.';
                msg.className   = 'review-msg review-msg-err';
            } finally {
                btn.disabled = false;
            }
        });
    }

    // ── Init ──────────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        loadProduct();
        initQty();
        initAddToCart();
        initFrete();
        initTabs();
        initStarPicker();
        initReviewForm();
    });
})();
