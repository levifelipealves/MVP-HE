<?php declare(strict_types=1);

class ProductModel
{
    public function __construct(private PDO $db) {}

    public function list(int $limit = 48, int $offset = 0): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.id, p.name, p.slug, p.price, p.price_pix, p.image, p.stock,
                    c.name AS category, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1 AND p.stock > 0
             ORDER BY p.created_at DESC
             LIMIT :limit OFFSET :offset'
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.slug = ? AND p.is_active = 1
             LIMIT 1'
        );
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function findByIds(array $ids): array
    {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare(
            "SELECT id, name, slug, price, price_pix, image, stock
             FROM products WHERE id IN ($placeholders) AND is_active = 1"
        );
        $stmt->execute(array_values($ids));
        return array_column($stmt->fetchAll(), null, 'id');
    }

    public function decrementStock(int $id, int $qty): void
    {
        $this->db->prepare(
            'UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?'
        )->execute([$qty, $id, $qty]);
    }
}
