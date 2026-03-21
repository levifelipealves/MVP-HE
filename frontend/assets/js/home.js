// home.js — lista de produtos

document.addEventListener('DOMContentLoaded', async () => {
    const grid = document.getElementById('products-grid');

    try {
        const res  = await fetch(`${window.API_URL}/products`);
        const json = await res.json();

        if (!res.ok) throw new Error(json.error || 'Erro ao carregar produtos.');

        const products = json.data || [];

        if (products.length === 0) {
            grid.innerHTML = '<div class="empty-state">Nenhum produto disponível.</div>';
            return;
        }

        grid.innerHTML = products.map(p => `
            <a href="${window.BASE_URL}/produto/${p.slug}" class="product-card">
                <img src="${p.image || (window.BASE_URL + '/assets/images/placeholder.jpg')}" alt="${esc(p.name)}" loading="lazy">
                <div class="product-card-body">
                    <div class="product-card-category">${esc(p.category || '')}</div>
                    <div class="product-card-name">${esc(p.name)}</div>
                    <div class="product-card-price">${money(p.price)}</div>
                    ${p.price_pix ? `<div class="product-card-pix">ou ${money(p.price_pix)} no Pix</div>` : ''}
                </div>
            </a>
        `).join('');
    } catch (err) {
        grid.innerHTML = `<div class="empty-state">Erro ao carregar produtos. Tente novamente.</div>`;
        console.error(err);
    }
});

function esc(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function money(v) {
    return 'R$ ' + Number(v).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
