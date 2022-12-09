<?php

use App\Collection\CollectionException;
use App\Collection\OrderEntryCollection;
use App\Collection\WarehouseCollection;
use App\Domain\WarehouseNegotiator;
use App\Entity\Warehouse;
use App\Repository\WarehouseRepositoryInterface;
use App\ValueObject\OrderEntry;
use App\ValueObject\OrderEntryItem;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Tests\DataProvider\OrderEntryDataProvider;
use Tests\DataProvider\WarehouseDataProvider;

class WarehouseNegotiatorTest extends TestCase
{
    const ORDER_ENTRY_ITEM_ID = 1;

    /**
     * @throws CollectionException
     * @doesNotPerformAssertions
     */
    public function testShouldNegotiateTheBestWarehouses()
    {
        // when
        $warehouseMock = WarehouseDataProvider::getWarehouseMock();

        /** @var WarehouseRepositoryInterface $repositoryMock */
        $repositoryMock = $this->getRepositoryMock(WarehouseDataProvider::getWarehousesCollectionMock([
            $warehouseMock,
            $warehouseMock,
            $warehouseMock,
        ]));

        $orderEntryItemMock = OrderEntryDataProvider::getOrderEntryItemMock()
            ->shouldReceive('getId')
            ->andReturn(self::ORDER_ENTRY_ITEM_ID)
            ->getMock();

        /** @var OrderEntryItem $orderEntryItemMock */
        $orderEntryMock = OrderEntryDataProvider::getOrderEntryMock([$orderEntryItemMock, $orderEntryItemMock]);

        $orderEntryCollectionMock = OrderEntryDataProvider::getCollectionMock($orderEntryMock);
        $warehouseCollectionMock = WarehouseDataProvider::getWarehousesCollectionMock([]);

        // then
        $warehouseNegotiator = new WarehouseNegotiator($repositoryMock);
        $warehouseNegotiator->negotiate($orderEntryCollectionMock, $warehouseCollectionMock);

        // given
        $warehouseCollectionMock->shouldHaveReceived('add')->times(6);
        $warehouseMock->shouldHaveReceived('getItemsCount')->times(6);
        $warehouseMock->shouldHaveReceived('reduceQuantity')->times(6);

        $orderEntryItemMock->shouldHaveReceived('getQuantity')->times(12);
        $orderEntryItemMock->shouldHaveReceived('reduceQuantity')->times(6);
        $orderEntryItemMock->shouldHaveReceived('getId')->times(12);

        $orderEntryMock->shouldHaveReceived('getItems')->times(1);
    }

    private function getRepositoryMock(WarehouseCollection $warehouses): MockInterface
    {
        return Mockery::mock(WarehouseRepositoryInterface::class)
            ->shouldReceive('all')
            ->andReturn($warehouses)
            ->getMock();
    }
}
