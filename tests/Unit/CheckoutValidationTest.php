<?php declare(strict_types=1);

namespace Tests\Unit;

use CheckoutController;
use PHPUnit\Framework\TestCase;

/**
 * Tests the input-validation logic inside CheckoutController::process().
 *
 * Because process() reads php://input and calls json_error() (which throws),
 * we drive it by overriding the input stream and inspecting the thrown message.
 * ProductModel and OrderModel are mocked so no DB is touched.
 */
class CheckoutValidationTest extends TestCase
{
    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    /** Build a CheckoutController with mocked dependencies. */
    private function makeController(): CheckoutController
    {
        $products = $this->createMock(\ProductModel::class);
        $orders   = $this->createMock(\OrderModel::class);
        return new CheckoutController($products, $orders);
    }

    /**
     * Trick process() into reading $payload from php://input by writing to a
     * temp stream and replacing the global input wrapper.
     *
     * PHPUnit runs in CLI so php://input is empty by default; we use a
     * stream-wrapper trick with a data URI instead.
     */
    private function runWithInput(array $payload): string
    {
        // Encode the payload
        $json = json_encode($payload);

        // Write to a temp file and override php://input via stream
        $tmp = tmpfile();
        fwrite($tmp, $json);
        rewind($tmp);

        // We cannot swap php://input easily, so we use a different approach:
        // subclass + override the input-reading step via a test double.
        // Instead, parse the body directly through a thin wrapper test class.
        return $json;
    }

    // -----------------------------------------------------------------------
    // Tests — we call a thin testable subclass that accepts injected input
    // -----------------------------------------------------------------------

    public function test_empty_cart_throws(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Carrinho vazio.');

        $ctrl = $this->makeController();
        $ctrl->processInput([
            'name'    => 'João Silva',
            'email'   => 'joao@example.com',
            'address' => 'Rua A, 1',
            'items'   => [],
        ]);
    }

    public function test_invalid_product_id_is_filtered_out(): void
    {
        // All items have product_id <= 0 → after filtering cart is empty
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nenhum item válido no carrinho.');

        $ctrl = $this->makeController();
        $ctrl->processInput([
            'name'    => 'João Silva',
            'email'   => 'joao@example.com',
            'address' => 'Rua A, 1',
            'items'   => [
                ['product_id' => 0,  'qty' => 2],
                ['product_id' => -1, 'qty' => 1],
            ],
        ]);
    }

    public function test_invalid_qty_is_filtered_out(): void
    {
        // Items have qty <= 0 → after filtering cart is empty
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nenhum item válido no carrinho.');

        $ctrl = $this->makeController();
        $ctrl->processInput([
            'name'    => 'João Silva',
            'email'   => 'joao@example.com',
            'address' => 'Rua A, 1',
            'items'   => [
                ['product_id' => 1, 'qty' => 0],
                ['product_id' => 2, 'qty' => -3],
            ],
        ]);
    }

    public function test_invalid_email_throws(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('E-mail inválido.');

        $ctrl = $this->makeController();
        $ctrl->processInput([
            'name'    => 'João Silva',
            'email'   => 'not-an-email',
            'address' => 'Rua A, 1',
            'items'   => [['product_id' => 1, 'qty' => 1]],
        ]);
    }

    public function test_empty_name_throws(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nome é obrigatório.');

        $ctrl = $this->makeController();
        $ctrl->processInput([
            'name'    => '   ',
            'email'   => 'joao@example.com',
            'address' => 'Rua A, 1',
            'items'   => [['product_id' => 1, 'qty' => 1]],
        ]);
    }
}
