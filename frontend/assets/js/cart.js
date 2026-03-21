// cart.js — gerenciamento de carrinho via localStorage (global)

const Cart = (() => {
    const KEY = 'ghv2_cart';

    function get() {
        try { return JSON.parse(localStorage.getItem(KEY)) || []; }
        catch { return []; }
    }

    function save(items) {
        localStorage.setItem(KEY, JSON.stringify(items));
        updateBadge();
    }

    function add(productId, qty = 1) {
        const items = get();
        const idx   = items.findIndex(i => i.product_id === productId);
        if (idx >= 0) items[idx].qty += qty;
        else items.push({ product_id: productId, qty });
        save(items);
    }

    function update(productId, qty) {
        if (qty <= 0) { remove(productId); return; }
        const items = get();
        const idx   = items.findIndex(i => i.product_id === productId);
        if (idx >= 0) { items[idx].qty = qty; save(items); }
    }

    function remove(productId) {
        save(get().filter(i => i.product_id !== productId));
    }

    function clear() { localStorage.removeItem(KEY); updateBadge(); }

    function count() { return get().reduce((s, i) => s + i.qty, 0); }

    function updateBadge() {
        const badge = document.getElementById('cart-count-badge');
        const total = document.getElementById('cart-total-badge');
        const n     = count();
        if (badge) {
            badge.textContent = n;
            badge.classList.toggle('visible', n > 0);
        }
        if (total) {
            const items = get();
            // total sem preço aqui — só contagem. Preço atualizado por cada página
            if (n === 0) total.textContent = 'R$ 0,00';
        }
    }

    // Init badge on load
    document.addEventListener('DOMContentLoaded', updateBadge);

    return { get, add, update, remove, clear, count };
})();
