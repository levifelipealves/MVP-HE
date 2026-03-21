// produto.js — detalhe do produto

document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('product-detail');
    const slug      = container.dataset.slug;
    let qty = 1;

    try {
        const res  = await fetch(`${window.API_URL}/products/${slug}`);
        const json = await res.json();

        if (!res.ok) throw new Error(json.error || 'Produto não encontrado.');

        const p = json.data;

        container.innerHTML = `
            <div class="product-layout">
                <div class="product-image">
                    <img src="${p.image || (window.BASE_URL + '/assets/images/placeholder.jpg')}" alt="${esc(p.name)}">
                </div>
                <div class="product-info">
                    <div class="product-category">${esc(p.category || '')}</div>
                    <h1 class="product-name">${esc(p.name)}</h1>
                    <div class="product-price-block">
                        <span class="product-price">${money(p.price)}</span>
                        ${p.price_pix ? `<span class="product-price-pix">ou ${money(p.price_pix)} no Pix</span>` : ''}
                    </div>
                    <p class="product-description">${esc(p.description || '')}</p>
                    ${p.stock > 0 ? `
                        <div class="product-qty-block">
                            <button class="qty-btn" id="qty-minus">−</button>
                            <span class="qty-value" id="qty-display">1</span>
                            <button class="qty-btn" id="qty-plus">+</button>
                        </div>
                        <button class="btn-primary btn-add-cart" id="btn-add">Adicionar ao Carrinho</button>
                    ` : '<p class="out-of-stock">Produto esgotado</p>'}
                </div>
            </div>
        `;

        if (p.stock > 0) {
            document.getElementById('qty-minus').addEventListener('click', () => {
                if (qty > 1) { qty--; document.getElementById('qty-display').textContent = qty; }
            });
            document.getElementById('qty-plus').addEventListener('click', () => {
                if (qty < p.stock) { qty++; document.getElementById('qty-display').textContent = qty; }
            });
            document.getElementById('btn-add').addEventListener('click', () => {
                Cart.add(p.id, qty);
                alert(`${p.name} adicionado ao carrinho!`);
            });
        }
    } catch (err) {
        container.innerHTML = '<div class="loading">Produto não encontrado.</div>';
        console.error(err);
    }
});

function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function money(v) {
    return 'R$ ' + Number(v).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
