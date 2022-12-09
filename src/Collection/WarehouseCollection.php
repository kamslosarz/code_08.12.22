<?php

namespace App\Collection;

use App\Entity\Warehouse;

/** @method static create(array $array): WarehouseCollection */

class WarehouseCollection extends AbstractCollection
{
    protected static function getElementClassname(): string
    {
        return Warehouse::class;
    }
}
