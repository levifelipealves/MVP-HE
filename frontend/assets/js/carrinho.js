// carrinho.js — visualização e edição do carrinho

document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('cart-container');
    const items     = Cart.get();

    if (items.length === 0) {
        container.innerHTML = `<div class="cart-empty">Seu carrinho está vazio. <a href="${window.BASE_URL}/">Ver produtos</a></div>`;
        return;
    }

    // Busca dados dos produtos na API
    const ids = items.map(i => i.product_id);
    let products = {};
    try {
        const res  = await fetch(`${window.API_URL}/products`);
        const json = await res.json();
        (json.data || []).forEach(p => { products[p.id] = p; });
    } catch {
        container.innerHTML = '<div class="loading">Erro ao carregar carrinho.</div>';
        return;
    }

    function render() {
        const cartItems = Cart.get();
        let subtotal = 0;
        let itemsHtml = '';

        cartItems.forEach(item => {
            const p = products[item.product_id];
            if (!p) return;
            const line = p.price * item.qty;
            subtotal += line;
            itemsHtml += `
                <div class="cart-item" data-id="${p.id}">
                    <img src="${p.image || (window.BASE_URL + '/assets/images/placeholder.jpg')}" alt="${esc(p.name)}">
                    <div class="cart-item-info">
                        <div class="cart-item-name">${esc(p.name)}</div>
                        <div class="cart-item-price">${money(p.price)} cada</div>
                    </div>
                    <div class="cart-item-qty">
                        <button class="qty-btn" data-action="dec" data-id="${p.id}">−</button>
                        <span class="qty-val">${item.qty}</span>
                        <button class="qty-btn" data-action="inc" data-id="${p.id}">+</button>
                    </div>
                    <button class="cart-item-remove" data-action="remove" data-id="${p.id}">✕</button>
                </div>
            `;
        });

        container.innerHTML = `
            <div class="cart-layout">
                <div class="cart-items">${itemsHtml}</div>
                <aside class="cart-summary">
                    <h2>Resumo</h2>
                    <div class="summary-row"><span>Subtotal</span><span>${money(subtotal)}</span></div>
                    <div class="summary-row summary-total"><span>Total</span><strong>${money(subtotal)}</strong></div>
                    <a href="${window.BASE_URL}/checkout" class="btn-primary btn-checkout">Finalizar Pedido</a>
                </aside>
            </div>
        `;

        container.querySelectorAll('[data-action]').forEach(btn => {
            btn.addEventListener('click', () => {
                const id  = parseInt(btn.dataset.id);
                const act = btn.dataset.action;
                const cur = Cart.get().find(i => i.product_id === id);
                if (act === 'inc')    Cart.update(id, (cur?.qty || 0) + 1);
                if (act === 'dec')    Cart.update(id, (cur?.qty || 1) - 1);
                if (act === 'remove') Cart.remove(id);
                if (Cart.get().length === 0) {
                    container.innerHTML = `<div class="cart-empty">Carrinho vazio. <a href="${window.BASE_URL}/">Ver produtos</a></div>`;
                } else { render(); }
            });
        });
    }

    render();
});

function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function money(v) {
    return 'R$ ' + Number(v).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
