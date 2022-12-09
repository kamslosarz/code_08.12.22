<?php

namespace App\Repository;

use App\Collection\WarehouseCollection;

interface WarehouseRepositoryInterface
{
    public function all(): WarehouseCollection;
}
