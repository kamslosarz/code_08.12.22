<?php

namespace Tests\DataProvider;

use App\Collection\OrderEntryCollection;
use App\ValueObject\OrderEntry;
use App\ValueObject\OrderEntryItem;
use ArrayIterator;
use Mockery;
use Mockery\MockInterface;

class OrderEntryDataProvider
{
    /**
     * @param array $orderEntryItems
     * @return MockInterface|OrderEntry
     */
    public static function getOrderEntryMock(array $orderEntryItems): Mockery\MockInterface
    {
        return Mockery::mock(OrderEntry::class)
            ->shouldReceive('getItems')
            ->andReturn($orderEntryItems)
            ->getMock();
    }

    /**
     * @param OrderEntry $orderEntry
     * @return Mockery\MockInterface|OrderEntryCollection
     */
    public static function getCollectionMock(OrderEntry $orderEntry): Mockery\MockInterface
    {
        return Mockery::mock(OrderEntryCollection::class)
            ->shouldReceive('getIterator')
            ->andReturn(new ArrayIterator([$orderEntry]))
            ->getMock();
    }

    /**
     * @return Mockery\MockInterface|OrderEntryItem
     */
    public static function getOrderEntryItemMock(): Mockery\MockInterface
    {
        return Mockery::mock(OrderEntryItem::class)
            ->shouldReceive('getQuantity')
            ->andReturn(100)
            ->getMock()
            ->shouldReceive('reduceQuantity')
            ->getMock();
    }
}
