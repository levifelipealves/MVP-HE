# CLAUDE.md — Diretrizes do Projeto Geek Heroes (MVP-HE)

Estas regras se aplicam a **toda** implementação neste projeto, sem exceção.
Claude deve seguir este documento em cada conversa, sem precisar ser lembrado.

---

## 1. Nomenclatura — English Only

- Arquivos PHP: `PascalCase` → `ProductModel.php`, `CheckoutController.php`
- Views: sufixo `View` → `productView.php`, `cartView.php`
- CSS/JS: `camelCase` → `productCrud.js`, `institutional.css`
- Rotas URL: inglês → `/product/{slug}`, `/cart`, `/order/{id}`
- Variáveis e funções PHP: `camelCase`
- Classes PHP: `PascalCase`
- Classes CSS: `kebab-case` semântico → `.product-card`, `.banner-item`

---

## 2. Proibições Absolutas (Dívida Técnica Zero)

### CSS
- **PROIBIDO** `style="..."` inline no HTML
- **PROIBIDO** classes utilitárias Tailwind no HTML (`text-gray-800`, `font-bold`, `p-4`, etc.)
- **OBRIGATÓRIO** CSS semântico em arquivo `.css` separado por página

### PHP
- **PROIBIDO** `@` para suprimir erros
- **PROIBIDO** `catch` vazio — todo catch crítico deve logar
- **PROIBIDO** PDO/queries em arquivos de View
- **PROIBIDO** superglobais (`$_GET`, `$_POST`, `$_SERVER`) em Views
- **PROIBIDO** cálculos financeiros no JavaScript (preço Pix, descontos, parcelas)

### Arquitetura
- **PROIBIDO** lógica de negócio em Views
- **PROIBIDO** redirecionamentos HTTP em arquivos de View
- **PROIBIDO** código morto (funções não usadas, imports desnecessários)

---

## 3. Ordem de Implementação (Fail-Proof Sequencing)

Toda nova funcionalidade segue esta ordem obrigatória:

```
Migration (SQL) → Model → Controller → View → Route (index.php)
```

Nunca registrar uma rota antes de a View existir.
Nunca criar Controller antes de o Model existir.
Nunca escrever Model sem a tabela já criada no banco.

---

## 4. Estrutura de Arquivos

```
A/
├── api/
│   ├── index.php               # Router da API
│   └── src/
│       ├── bootstrap.php       # db(), json_response(), json_error(), handlers
│       ├── helpers.php         # slugify() e funções puras
│       ├── Models/             # ProductModel, OrderModel, ReviewModel
│       └── Controllers/        # ProductController, CheckoutController...
├── frontend/
│   ├── index.php               # Router do frontend
│   ├── config.php              # Dados da loja (sem PDO)
│   ├── views/
│   │   ├── layout/             # header.php, footer.php
│   │   ├── admin/              # productCrudView.php
│   │   └── *View.php           # homeView, productView, cartView...
│   └── assets/
│       ├── css/                # Um .css por página + tokens.css + base.css
│       ├── js/                 # Um .js por página + cart.js (global)
│       └── images/
├── migrations/                 # SQL versionado
├── tests/                      # PHPUnit — um arquivo por domínio
└── .github/workflows/ci.yml    # CI automático no push
```

---

## 5. API — Contrato de Resposta

- Sempre retornar JSON via `json_response()` ou `json_error()`
- Preço Pix calculado **no backend** (`price_pix` já vem pronto)
- Erros críticos (checkout, pagamento) devem gravar log estruturado em `storage/`
- Nunca expor stack trace ao cliente

---

## 6. Frontend — Regras JS

- Nenhum cálculo de preço, desconto ou parcela no JS
- `cart.js` é o módulo global do localStorage — não duplicar lógica de carrinho
- Cada página tem seu próprio arquivo JS (`product.js`, `cartView.js`, etc.)
- Sanitizar saída com `esc()` antes de inserir no DOM via `innerHTML`

---

## 7. Logs e Erros

- `storage/api_erro.log` — erros da API (JSON estruturado via `_writeLog()`)
- `storage/pedidos_erro.log` — erros de checkout
- `set_error_handler` ignora `/vendor/`
- `register_shutdown_function` captura erros fatais

---

## 8. Testes

- Framework: PHPUnit 11
- Localização: `tests/Unit/`
- Nomear por domínio: `CheckoutValidationTest`, `ProductSlugTest`, `ReviewValidationTest`
- Extrair `processInput()` e métodos similares para permitir teste sem `php://input`
- CI roda automaticamente no push via GitHub Actions

---

## 9. Git

- Commits em inglês, formato: `type: descrição curta`
- Types: `feat`, `fix`, `refactor`, `test`, `docs`, `chore`
- Nunca commitar `vendor/`, `.env`, `storage/*.log`
- Push dispara CI — verificar Actions após push

---

## 10. O que este projeto NÃO tem (por decisão)

- Nenhum framework PHP (sem Laravel, Slim, Symfony)
- Nenhum sistema de autenticação (uso local XAMPP)
- Nenhum ORM (PDO direto com prepared statements)
- Nenhum bundler JS (sem Vite, Webpack)
- Nenhum pré-processador CSS (sem SASS)
