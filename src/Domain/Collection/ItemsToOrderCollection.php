<?php

namespace App\Domain\Collection;

use App\Collection\AbstractCollection;
use App\Collection\CollectionException;
use App\Collection\OrderEntryCollection;
use App\ValueObject\OrderEntry;
use App\ValueObject\OrderEntryItem;

final class ItemsToOrderCollection extends AbstractCollection
{
    protected static function getElementClassname(): string
    {
        return OrderEntryItem::class;
    }

    /**
     * @param $element
     * @return void
     * @throws CollectionException
     */
    public function add($element): void
    {
        if (!($element instanceof OrderEntryItem)) {
            throw new CollectionException(sprintf(
                    'Invalid data type, expected %s but got %s', OrderEntryItem::class, get_class($element))
            );
        }

        $this->elements[] = $element;
    }

    /**
     * @throws CollectionException
     */
    public static function createFromOrderEntryCollection(OrderEntryCollection $orderEntryCollection): self
    {
        $itemsToOrderCollection = new self([]);

        /** @var OrderEntry $orderEntry */
        foreach ($orderEntryCollection as $orderEntry) {
            /** @var OrderEntryItem $item */
            foreach ($orderEntry->getItems() as $item) {
                $itemsToOrderCollection->add($item);
            }
        }

        return $itemsToOrderCollection;
    }
}
