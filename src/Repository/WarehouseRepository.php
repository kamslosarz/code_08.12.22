<?php

namespace App\Repository;

use App\Collection\WarehouseCollection;

final class WarehouseRepository implements WarehouseRepositoryInterface
{
    public function all(): WarehouseCollection
    {
        return WarehouseCollection::create([]);
    }
}
