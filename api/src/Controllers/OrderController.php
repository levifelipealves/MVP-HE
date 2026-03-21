<?php declare(strict_types=1);

class OrderController
{
    public function __construct(private OrderModel $model) {}

    public function show(int $id): never
    {
        $order = $this->model->find($id);

        if (!$order) {
            json_error('Pedido não encontrado.', 404);
        }

        $items = $this->model->items($id);

        json_response(['data' => $order, 'items' => $items]);
    }
}
