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

        // Validate customer
        $name    = trim($body['name']    ?? '');
        $email   = trim($body['email']   ?? '');
        $address = trim($body['address'] ?? '');
        $items   = $body['items']        ?? [];

        if (!$name)                             json_error('Nome é obrigatório.');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) json_error('E-mail inválido.');
        if (!$address)                          json_error('Endereço é obrigatório.');
        if (empty($items))                      json_error('Carrinho vazio.');

        // Validate products & stock
        $ids      = array_column($items, 'product_id');
        $products = $this->products->findByIds($ids);
        $subtotal = 0.0;

        foreach ($items as $item) {
            $pid = (int) $item['product_id'];
            $qty = (int) $item['qty'];
            $p   = $products[$pid] ?? null;

            if (!$p)           json_error("Produto #$pid não encontrado.", 422);
            if ($p['stock'] < $qty) json_error("Estoque insuficiente: {$p['name']}.", 422);

            $subtotal += $p['price'] * $qty;
        }

        // Create order
        try {
            db()->beginTransaction();

            $orderId = $this->orders->create([
                'name'     => $name,
                'email'    => $email,
                'phone'    => trim($body['phone']   ?? ''),
                'cpf'      => preg_replace('/\D/', '', $body['cpf'] ?? ''),
                'cep'      => preg_replace('/\D/', '', $body['cep'] ?? ''),
                'address'  => $address,
                'subtotal' => $subtotal,
            ]);

            foreach ($items as $item) {
                $pid = (int) $item['product_id'];
                $qty = (int) $item['qty'];
                $p   = $products[$pid];
                $this->orders->addItem($orderId, [
                    'product_id' => $pid,
                    'name'       => $p['name'],
                    'price'      => $p['price'],
                    'qty'        => $qty,
                ]);
                $this->products->decrementStock($pid, $qty);
            }

            db()->commit();
        } catch (\Throwable $e) {
            db()->rollBack();
            json_error('Erro ao processar pedido.', 500);
        }

        json_response(['order_id' => $orderId, 'total' => $subtotal], 201);
    }
}
