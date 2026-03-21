<?php declare(strict_types=1);

class OrderModel
{
    public function __construct(private PDO $db) {}

    public function create(array $data): int
    {
        $this->db->prepare(
            'INSERT INTO orders
             (customer_name, customer_email, customer_phone, customer_cpf,
              customer_cep, customer_address, subtotal, total, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        )->execute([
            $data['name'], $data['email'],
            $data['phone'] ?? '', $data['cpf'] ?? '',
            $data['cep']   ?? '', $data['address'],
            $data['subtotal'], $data['subtotal'], 'pending',
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function addItem(int $orderId, array $item): void
    {
        $this->db->prepare(
            'INSERT INTO order_items (order_id, product_id, product_name, unit_price, quantity)
             VALUES (?, ?, ?, ?, ?)'
        )->execute([$orderId, $item['product_id'], $item['name'], $item['price'], $item['qty']]);
    }

    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function items(int $orderId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM order_items WHERE order_id = ?');
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
}
