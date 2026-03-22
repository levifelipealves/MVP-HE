<?php declare(strict_types=1);

class ReviewModel
{
    public function __construct(private PDO $db) {}

    public function listByProduct(int $productId): array
    {
        $stmt = $this->db->prepare(
            'SELECT author_name, rating, comment, created_at
             FROM reviews
             WHERE product_id = ? AND approved = 1
             ORDER BY created_at DESC
             LIMIT 50'
        );
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function summary(int $productId): array
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) AS total, ROUND(AVG(rating), 1) AS average
             FROM reviews WHERE product_id = ? AND approved = 1'
        );
        $stmt->execute([$productId]);
        return $stmt->fetch();
    }

    public function create(int $productId, string $name, int $rating, ?string $comment): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO reviews (product_id, author_name, rating, comment)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$productId, $name, $rating, $comment]);
        return (int) $this->db->lastInsertId();
    }
}
