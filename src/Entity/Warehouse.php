<?php

namespace App\Entity;

class Warehouse
{
    private string $name;
    /** @var WarehouseItem[] $items */
    private array $items;
    private bool $healthy;

    public function __construct(string $name, array $items, bool $healthy)
    {
        $this->name = $name;
        $this->items = $items;
        $this->healthy = $healthy;
    }

    public function isHealthy(): bool
    {
        return $this->healthy;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getItemsCount(int $id): int
    {
        /** @var WarehouseItem $item */
        foreach ($this->items as $item) {
            if ($item->getId() === $id) {
                return $item->getQuantity();
            }
        }

        return 0;
    }

    public function reduceQuantity(int $id, int $quantity)
    {
        /** @var WarehouseItem $item */
        foreach ($this->items as $item) {
            if ($item->getId() === $id) {
                $item->reduceQuantity($quantity);
                break;
            }
        }
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
