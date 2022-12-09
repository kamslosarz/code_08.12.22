<?php

use App\Entity\Warehouse;
use App\Entity\WarehouseItem;
use PHPUnit\Framework\TestCase;

class WarehouseTest extends TestCase
{
    public function testShouldGetItemsCount()
    {
        $warehouse = new Warehouse('test', [
            new WarehouseItem(100, 'test', 100),
        ], true);

        $this->assertEquals(100, $warehouse->getItemsCount(100));
    }

    public function testShouldReduceQuantity()
    {
        $warehouse = new Warehouse('test', [
            new WarehouseItem(100, 'test', 100),
        ], true);

        $warehouse->reduceQuantity(100, 99);
        $this->assertEquals(1, $warehouse->getItemsCount(100));
    }
}
