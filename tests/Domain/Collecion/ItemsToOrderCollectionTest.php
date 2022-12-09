<?php

use App\Collection\CollectionException;
use App\Collection\OrderEntryCollection;
use App\Domain\Collection\ItemsToOrderCollection;
use App\ValueObject\OrderEntryItem;
use PHPUnit\Framework\TestCase;
use Tests\DataProvider\OrderEntryDataProvider;

class ItemsToOrderCollectionTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testShouldAddOrderItemToList()
    {
        $collection = ItemsToOrderCollection::create([]);

        $this->assertEmpty($collection->getIterator());

        $collection->add(Mockery::mock(OrderEntryItem::class));

        $this->assertNotEmpty($collection->getIterator());
    }

    /**
     * @throws CollectionException
     * @throws Exception
     */
    public function testShouldCreateCollectionFromOrderEntryCollection()
    {
        $orderEntryItemMock = OrderEntryDataProvider::getOrderEntryItemMock();

        $orderEntries = [
            OrderEntryDataProvider::getOrderEntryMock([
                $orderEntryItemMock,
                $orderEntryItemMock,
                $orderEntryItemMock,
            ]),
            OrderEntryDataProvider::getOrderEntryMock([
                $orderEntryItemMock,
                $orderEntryItemMock,
                $orderEntryItemMock,
            ]),
        ];

        $orderEntryCollectionMock = Mockery::mock(OrderEntryCollection::class)
            ->shouldReceive('getIterator')
            ->andReturn(new ArrayIterator($orderEntries))
            ->getMock();

        $collection = ItemsToOrderCollection::createFromOrderEntryCollection($orderEntryCollectionMock);

        $this->assertCount(6, $collection);
        $this->assertEquals([
            $orderEntryItemMock,
            $orderEntryItemMock,
            $orderEntryItemMock,
            $orderEntryItemMock,
            $orderEntryItemMock,
            $orderEntryItemMock,
        ], $collection->getIterator()->getArrayCopy());
    }
}
