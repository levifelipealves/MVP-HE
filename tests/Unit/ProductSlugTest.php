<?php declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProductSlugTest extends TestCase
{
    public function test_regular_product_name(): void
    {
        $this->assertSame('funko-pop-batman', slugify('Funko Pop Batman'));
    }

    public function test_name_with_numbers_and_punctuation(): void
    {
        $this->assertSame('action-figure-30cm', slugify('Action Figure 30cm!'));
    }

    public function test_name_with_accents_and_special_chars(): void
    {
        $result = slugify('Ação & Aventura');
        // After TRANSLIT, accented chars become ASCII equivalents;
        // non-alphanumeric/space/hyphen chars are stripped.
        // "Ação" → "Acao", "&" stripped, "Aventura" stays → "acao-aventura"
        $this->assertSame('acao-aventura', $result);
    }

    public function test_empty_string_returns_empty(): void
    {
        $this->assertSame('', slugify(''));
    }
}
