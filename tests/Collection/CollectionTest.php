<?php

namespace Collection;

use App\Collection\CollectionInterface;
use App\Collection\OrderEntryCollection;
use App\ValueObject\OrderEntry;
use App\ValueObject\OrderEntryItem;
use Exception;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testShouldCreateCollection()
    {
        $collection = OrderEntryCollection::create([
            [
                'customer' => 'Magdalena Iksińska',
                'items' => [
                    new OrderEntryItem(1, 1),
                ],
            ],
        ]);

        $this->assertInstanceOf(CollectionInterface::class, $collection);
        $this->assertInstanceOf(OrderEntry::class, $collection->getIterator()->offsetGet(0));
    }
}
