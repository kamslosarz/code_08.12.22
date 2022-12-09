<?php

namespace App\ValueObject;

use App\Traits\QuantityTrait;

class OrderEntryItem
{
    use QuantityTrait;

    private int $id;

    public function __construct(int $id, int $quantity)
    {
        $this->id = $id;
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}
