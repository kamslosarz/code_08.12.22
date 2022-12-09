<?php

namespace App\Traits;

trait QuantityTrait
{
    private int $quantity = 0;

    /**
     * @param int $quantity
     * @return void
     */
    public function reduceQuantity(int $quantity): void
    {
        if ($quantity > $this->quantity) {
            $this->quantity = 0;
        } else {
            $this->quantity -= $quantity;
        }
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return void
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
