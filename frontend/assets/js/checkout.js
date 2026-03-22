// checkout.js — formulário de checkout

document.addEventListener('DOMContentLoaded', async () => {
    const items = Cart.get();

    if (items.length === 0) {
        window.location.href = window.BASE_URL + '/cart';
        return;
    }

    // Renderiza resumo do pedido
    const summaryEl = document.getElementById('summary-items');
    const totalEl   = document.getElementById('summary-total');

    let products = {};
    try {
        const res  = await fetch(`${window.API_URL}/products`);
        const json = await res.json();
        (json.data || []).forEach(p => { products[p.id] = p; });
    } catch {
        summaryEl.innerHTML = '<p>Erro ao carregar produtos.</p>';
        return;
    }

    let subtotal = 0;
    let html = '';
    items.forEach(item => {
        const p = products[item.product_id];
        if (!p) return;
        const line = p.price * item.qty;
        subtotal += line;
        html += `<div class="summary-item"><span>${esc(p.name)} × ${item.qty}</span><span>${money(line)}</span></div>`;
    });
    summaryEl.innerHTML = html;
    totalEl.textContent = money(subtotal);

    // Form submit
    const form    = document.getElementById('checkout-form');
    const errorEl = document.getElementById('form-error');
    const submitBtn = document.getElementById('submit-btn');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorEl.hidden = true;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processando...';

        const payload = {
            name:    form.name.value.trim(),
            email:   form.email.value.trim(),
            phone:   form.phone.value.trim(),
            cpf:     form.cpf.value.replace(/\D/g, ''),
            cep:     form.cep.value.replace(/\D/g, ''),
            address: form.address.value.trim(),
            items:   Cart.get(),
        };

        try {
            const res  = await fetch(`${window.API_URL}/checkout`, {
                method:  'POST',
                headers: { 'Content-Type': 'application/json' },
                body:    JSON.stringify(payload),
            });
            const json = await res.json();

            if (!res.ok) {
                errorEl.textContent = json.error || 'Erro ao processar pedido.';
                errorEl.hidden = false;
                submitBtn.disabled = false;
                submitBtn.textContent = 'Confirmar Pedido';
                return;
            }

            Cart.clear();
            window.location.href = `${window.BASE_URL}/order/${json.order_id}`;
        } catch {
            errorEl.textContent = 'Erro de conexão. Tente novamente.';
            errorEl.hidden = false;
            submitBtn.disabled = false;
            submitBtn.textContent = 'Confirmar Pedido';
        }
    });
});

function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function money(v) {
    return 'R$ ' + Number(v).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
