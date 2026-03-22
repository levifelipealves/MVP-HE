/* adminLogin.js — Admin login form handler */

(function () {
    'use strict';

    const form     = document.getElementById('admin-login-form');
    const input    = document.getElementById('admin-password');
    const errorBox = document.getElementById('admin-login-error');
    const btn      = document.getElementById('admin-login-btn');

    function showError(msg) {
        errorBox.textContent = msg;
        errorBox.hidden = false;
    }

    function hideError() {
        errorBox.textContent = '';
        errorBox.hidden = true;
    }

    function setLoading(loading) {
        btn.disabled = loading;
        btn.textContent = loading ? 'Entrando...' : 'Entrar';
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        hideError();

        const password = input.value.trim();
        if (!password) {
            showError('Digite a senha.');
            input.focus();
            return;
        }

        setLoading(true);

        try {
            const res = await fetch(window.API_URL + '/admin/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'include',
                body: JSON.stringify({ password }),
            });

            const data = await res.json();

            if (res.ok && data.ok) {
                window.location.href = window.BASE_URL + '/admin/products';
            } else {
                showError(data.error || 'Senha incorreta.');
                input.focus();
            }
        } catch (err) {
            showError('Erro de conexão. Tente novamente.');
        } finally {
            setLoading(false);
        }
    });
})();
