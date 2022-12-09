<?php

namespace App\Collection;

interface CollectionInterface
{
    public static function create(array $elements): self;
}
