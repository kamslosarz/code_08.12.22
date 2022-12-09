<?php

namespace App\Collection;

use App\ValueObject\OrderEntry;

/** @method static create(array $array): OrderEntryCollection */

class OrderEntryCollection extends AbstractCollection
{
    protected static function getElementClassname(): string
    {
        return OrderEntry::class;
    }
}
