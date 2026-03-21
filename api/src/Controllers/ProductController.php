<?php declare(strict_types=1);

class ProductController
{
    public function __construct(private ProductModel $model) {}

    public function list(): never
    {
        $limit  = min((int) ($_GET['limit'] ?? 48), 100);
        $offset = max((int) ($_GET['offset'] ?? 0), 0);

        $products = $this->model->list($limit, $offset);
        json_response(['data' => $products, 'count' => count($products)]);
    }

    public function show(string $slug): never
    {
        $product = $this->model->findBySlug($slug);

        if (!$product) {
            json_error('Produto não encontrado.', 404);
        }

        json_response(['data' => $product]);
    }
}
