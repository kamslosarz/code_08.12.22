<?php

namespace App\Collection;

use ArrayIterator;
use IteratorAggregate;

abstract class AbstractCollection implements CollectionInterface, IteratorAggregate
{
    protected array $elements;

    public function __construct($elements)
    {
        $this->elements = $elements;
    }

    abstract protected static function getElementClassname(): string;

    /**
     * @param array $elements
     * @return AbstractCollection
     */
    public static function create(array $elements): self
    {
        $collection = new static([]);

        foreach ($elements as $element) {
            $elementClassname = static::getElementClassname();
            $collection->add(new $elementClassname(...$element));
        }

        return $collection;
    }

    public function add($element): void
    {
        $this->elements[] = $element;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }
}
