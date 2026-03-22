<?php declare(strict_types=1);

namespace Tests\Unit;

use ReviewController;
use PHPUnit\Framework\TestCase;

class ReviewValidationTest extends TestCase
{
    private function makeController(): ReviewController
    {
        $reviews = $this->createMock(\ReviewModel::class);
        return new ReviewController($reviews);
    }

    public function test_rating_zero_throws(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nota deve ser de 1 a 5.');

        $this->makeController()->createInput(1, [
            'author_name' => 'Ana',
            'rating'      => 0,
        ]);
    }

    public function test_rating_six_throws(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nota deve ser de 1 a 5.');

        $this->makeController()->createInput(1, [
            'author_name' => 'Ana',
            'rating'      => 6,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('validRatings')]
    public function test_valid_rating_does_not_throw_validation(int $rating): void
    {
        // ReviewModel::create() will be called; mock returns void.
        // json_response() (stub) throws an Exception with the success payload —
        // we just verify it is NOT the validation error message.
        $reviews = $this->createMock(\ReviewModel::class);
        $reviews->expects($this->once())->method('create');

        $ctrl = new ReviewController($reviews);

        try {
            $ctrl->createInput(1, ['author_name' => 'Ana', 'rating' => $rating]);
        } catch (\Exception $e) {
            // The stub json_response throws with the JSON success body
            $decoded = json_decode($e->getMessage(), true);
            $this->assertArrayHasKey('message', $decoded,
                "Expected success payload for rating $rating, got: " . $e->getMessage());
        }
    }

    public static function validRatings(): array
    {
        return [[1], [2], [3], [4], [5]];
    }

    public function test_empty_name_throws(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Nome é obrigatório.');

        $this->makeController()->createInput(1, [
            'author_name' => '',
            'rating'      => 4,
        ]);
    }
}
