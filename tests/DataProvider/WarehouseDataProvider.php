<?php

namespace Tests\DataProvider;

use App\Collection\WarehouseCollection;
use App\Entity\Warehouse;
use Mockery;
use Mockery\MockInterface;

class WarehouseDataProvider
{
    /**
     * @return MockInterface|Warehouse
     */
    public static function getWarehouseMock(bool $isHealthy = true): MockInterface
    {
        return Mockery::mock(Warehouse::class)
            ->shouldReceive('getItemsCount')
            ->getMock()
            ->shouldReceive('reduceQuantity')
            ->getMock()
            ->shouldReceive('isHealthy')
            ->andReturn($isHealthy)
            ->getMock();
    }

    /**
     * @return MockInterface|WarehouseCollection
     */
    public static function getWarehousesCollectionMock(array $warehouses): MockInterface
    {
        return Mockery::mock(WarehouseCollection::class)
            ->shouldReceive('getIterator')
            ->andReturn(new \ArrayIterator($warehouses))
            ->getMock()
            ->shouldReceive('add')
            ->getMock();
    }
}
