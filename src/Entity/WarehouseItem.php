<?php

namespace App\Entity;

use App\Traits\QuantityTrait;

class WarehouseItem
{
    use QuantityTrait;

    private int $id;
    private string $name;

    public function __construct(int $id, string $name, int $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
