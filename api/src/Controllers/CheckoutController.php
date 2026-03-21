<?php declare(strict_types=1);

class CheckoutController
{
    public function __construct(
        private ProductModel $products,
        private OrderModel   $orders
    ) {}

    public function process(): never
    {
        $body = json_decode(file_get_contents('php://input'), true) ?? [];

        $name    = trim($body['name']    ?? '');
        $email   = trim($body['email']   ?? '');
        $address = trim($body['address'] ?? '');
        $rawItems = $body['items']       ?? [];

        if (!$name)                                          json_error('Nome é obrigatório.');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))      json_error('E-mail inválido.');
        if (!$address)                                       json_error('Endereço é obrigatório.');
        if (empty($rawItems) || !is_array($rawItems))        json_error('Carrinho vazio.');

        // Normaliza e filtra itens válidos
        $items = [];
        foreach ($rawItems as $item) {
            $pid = (int) ($item['product_id'] ?? 0);
            $qty = (int) ($item['qty']        ?? 0);
            if ($pid > 0 && $qty > 0) {
                $items[] = ['product_id' => $pid, 'qty' => $qty];
            }
        }

        if (empty($items)) json_error('Nenhum item válido no carrinho.');

        try {
            db()->beginTransaction();

            // Lock das linhas — SELECT FOR UPDATE dentro da transação
            $ids      = array_column($items, 'product_id');
            $products = $this->products->findByIds($ids);
            $subtotal = 0.0;

            foreach ($items as $item) {
                $pid = $item['product_id'];
                $qty = $item['qty'];
                $p   = $products[$pid] ?? null;

                if (!$p)                 json_error("Produto #$pid não encontrado.", 422);
                if ($p['stock'] < $qty)  json_error("Estoque insuficiente: {$p['name']}.", 422);

                $subtotal += (float) $p['price'] * $qty;
            }

            $orderId = $this->orders->create([
                'name'     => $name,
                'email'    => $email,
                'phone'    => trim($body['phone'] ?? ''),
                'cpf'      => preg_replace('/\D/', '', $body['cpf'] ?? ''),
                'cep'      => preg_replace('/\D/', '', $body['cep'] ?? ''),
                'address'  => $address,
                'subtotal' => $subtotal,
            ]);

            foreach ($items as $item) {
                $pid      = $item['product_id'];
                $qty      = $item['qty'];
                $p        = $products[$pid];

                $this->orders->addItem($orderId, [
                    'product_id' => $pid,
                    'name'       => $p['name'],
                    'price'      => $p['price'],
                    'qty'        => $qty,
                ]);

                // Decremento atômico — falha se estoque mudou entre o lock e agora
                $affected = $this->products->decrementStock($pid, $qty);
                if ($affected === 0) {
                    db()->rollBack();
                    json_error("Estoque esgotado: {$p['name']}.", 409);
                }
            }

            db()->commit();
        } catch (\Throwable $e) {
            db()->rollBack();
            json_error('Erro ao processar pedido.', 500);
        }

        json_response(['order_id' => $orderId, 'total' => $subtotal], 201);
    }
}
