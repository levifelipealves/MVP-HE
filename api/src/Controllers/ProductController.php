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

    public function listAdmin(): never
    {
        AdminMiddleware::check();
        $products = $this->model->listAdmin();
        json_response(['data' => $products, 'count' => count($products)]);
    }

    public function createProduct(): never
    {
        AdminMiddleware::check();
        $body = json_decode(file_get_contents('php://input'), true) ?? [];

        if (empty($body['name']) || empty($body['slug']) || !isset($body['price'])) {
            json_error('Campos obrigatórios: name, slug, price.', 422);
        }

        $id = $this->model->create($body);
        $product = $this->model->findById($id);
        json_response(['data' => $product], 201);
    }

    public function updateProduct(int $id): never
    {
        AdminMiddleware::check();
        $body = json_decode(file_get_contents('php://input'), true) ?? [];

        if (empty($body['name']) || empty($body['slug']) || !isset($body['price'])) {
            json_error('Campos obrigatórios: name, slug, price.', 422);
        }

        $existing = $this->model->findById($id);
        if (!$existing) {
            json_error('Produto não encontrado.', 404);
        }

        $this->model->update($id, $body);
        $product = $this->model->findById($id);
        json_response(['data' => $product]);
    }

    public function deleteProduct(int $id): never
    {
        AdminMiddleware::check();
        $existing = $this->model->findById($id);
        if (!$existing) {
            json_error('Produto não encontrado.', 404);
        }

        $this->model->delete($id);
        json_response(['ok' => true]);
    }
}
