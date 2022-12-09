<?php

use App\Traits\QuantityTrait;
use PHPUnit\Framework\TestCase;

class QuantityTraitTest extends TestCase
{
    public function testShouldGetQuantity()
    {
        $quantityTrait = Mockery::mock(QuantityTrait::class)
            ->makePartial();

        $this->assertEquals(0, $quantityTrait->getQuantity());
    }

    public function testShouldSetQuantity()
    {
        $quantityTrait = Mockery::mock(QuantityTrait::class)
            ->makePartial();

        $quantityTrait->setQuantity(1);

        $this->assertEquals(1, $quantityTrait->getQuantity());
    }

    /**
     * @return void
     * @dataProvider reduceQuantityCases
     */
    public function testShouldReduceQuantity(int $quantity, int $reduce, int $expected)
    {
        $quantityTrait = Mockery::mock(QuantityTrait::class)
            ->makePartial();

        $quantityTrait->setQuantity($quantity);
        $quantityTrait->reduceQuantity($reduce);

        $this->assertEquals($expected, $quantityTrait->getQuantity());
    }

    public function reduceQuantityCases(): array
    {
        return [
            'case reduce' => [
                'quantity' => 10,
                'reduce' => 5,
                'expected' => 5,
            ],
            'case reduce more than value' => [
                'quantity' => 5,
                'reduce' => 10,
                'expected' => 0,
            ],
        ];
    }
}
