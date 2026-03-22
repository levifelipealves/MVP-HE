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
             FROM products WHERE id IN ($placeholders) AND is_active = 1
             FOR UPDATE"
        );
        $stmt->execute(array_values($ids));
        return array_column($stmt->fetchAll(), null, 'id');
    }

    public function decrementStock(int $id, int $qty): int
    {
        $stmt = $this->db->prepare(
            'UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?'
        );
        $stmt->execute([$qty, $id, $qty]);
        return $stmt->rowCount();
    }

    public function listAdmin(): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.id, p.name, p.slug, p.price, p.price_pix, p.image, p.stock,
                    p.is_active, p.category_id,
                    c.name AS category, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             ORDER BY p.created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.name AS category, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.id = ?
             LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO products (name, slug, price, price_pix, stock, description, category_id, image, is_active)
             VALUES (:name, :slug, :price, :price_pix, :stock, :description, :category_id, :image, 1)'
        );
        $stmt->execute([
            ':name'        => $data['name'],
            ':slug'        => $data['slug'],
            ':price'       => $data['price'],
            ':price_pix'   => $data['price_pix'] ?? null,
            ':stock'       => $data['stock'] ?? 0,
            ':description' => $data['description'] ?? null,
            ':category_id' => $data['category_id'] ?? null,
            ':image'       => $data['image'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE products
             SET name = :name, slug = :slug, price = :price, price_pix = :price_pix,
                 stock = :stock, description = :description, category_id = :category_id,
                 image = :image, is_active = :is_active
             WHERE id = :id'
        );
        $stmt->execute([
            ':name'        => $data['name'],
            ':slug'        => $data['slug'],
            ':price'       => $data['price'],
            ':price_pix'   => $data['price_pix'] ?? null,
            ':stock'       => $data['stock'] ?? 0,
            ':description' => $data['description'] ?? null,
            ':category_id' => $data['category_id'] ?? null,
            ':image'       => $data['image'] ?? null,
            ':is_active'   => isset($data['is_active']) ? (int) $data['is_active'] : 1,
            ':id'          => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE products SET is_active = 0 WHERE id = ?');
        $stmt->execute([$id]);
    }
}
