// confirmado.js — resumo do pedido confirmado

document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('order-summary');
    const orderId   = parseInt(container.dataset.orderId);

    if (!orderId) {
        container.innerHTML = '<div class="loading">Pedido não encontrado.</div>';
        return;
    }

    try {
        const res  = await fetch(`${window.API_URL}/orders/${orderId}`);
        const json = await res.json();

        if (!res.ok) throw new Error(json.error || 'Pedido não encontrado.');

        const order = json.data;
        const items = json.items || [];

        const itemsHtml = items.map(i => `
            <div class="order-item">
                <span>${esc(i.product_name)} × ${i.quantity}</span>
                <span>${money(i.unit_price * i.quantity)}</span>
            </div>
        `).join('');

        container.innerHTML = `
            <div class="order-confirmed">
                <div class="confirmed-icon">✅</div>
                <h1 class="confirmed-title">Pedido Confirmado!</h1>
                <p class="confirmed-sub">Pedido #${order.id} — ${esc(order.customer_email)}</p>
                <div class="order-info">
                    <h3>Itens do Pedido</h3>
                    ${itemsHtml}
                    <div class="order-total">
                        <span>Total</span>
                        <span>${money(order.total)}</span>
                    </div>
                </div>
                <a href="/" class="btn-primary btn-back">Continuar Comprando</a>
            </div>
        `;
    } catch (err) {
        container.innerHTML = '<div class="loading">Erro ao carregar pedido.</div>';
        console.error(err);
    }
});

function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function money(v) {
    return 'R$ ' + Number(v).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
