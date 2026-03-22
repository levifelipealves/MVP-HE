<?php declare(strict_types=1);

class ReviewController
{
    public function __construct(private ReviewModel $reviews) {}

    public function list(int $productId): never
    {
        $items   = $this->reviews->listByProduct($productId);
        $summary = $this->reviews->summary($productId);
        json_response([
            'reviews' => $items,
            'summary' => [
                'total'   => (int) $summary['total'],
                'average' => $summary['average'] ? (float) $summary['average'] : null,
            ],
        ]);
    }

    public function create(int $productId): never
    {
        $body    = json_decode(file_get_contents('php://input'), true) ?? [];
        $name    = trim($body['author_name'] ?? '');
        $rating  = (int) ($body['rating'] ?? 0);
        $comment = trim($body['comment'] ?? '') ?: null;

        if (!$name)                        json_error('Nome é obrigatório.');
        if ($rating < 1 || $rating > 5)   json_error('Nota deve ser de 1 a 5.');

        $this->reviews->create($productId, $name, $rating, $comment);
        json_response(['message' => 'Avaliação enviada.'], 201);
    }
}
