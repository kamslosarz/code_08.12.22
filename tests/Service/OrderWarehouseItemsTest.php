<?php

namespace App\Order;

use App\Collection\OrderEntryCollection;
use App\Collection\WarehouseCollection;
use App\Entity\WarehouseItem;
use App\Repository\WarehouseRepositoryInterface;
use App\Service\OrderWarehouseItems;
use App\Validator\Constraint\ConstraintException;
use App\ValueObject\OrderEntryItem;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderWarehouseItemsTest extends TestCase
{
    /**
     * @param array $warehouseData
     * @param array $orderEntryData
     * @param string|null $expectedExceptionMessage
     * @param array|null $quantityAfterOrder
     * @return void
     * @throws ConstraintException
     * @throws Exception
     * @dataProvider provideData
     */
    public function testShouldOrderWarehouseItems(
        array $warehouseData,
        array $orderEntryData,
        ?string $expectedExceptionMessage,
        ?array $quantityAfterOrder = null
    ): void {
        $repositoryMock = Mockery::mock(WarehouseRepositoryInterface::class)
            ->shouldReceive('all')
            ->andReturn(WarehouseCollection::create($warehouseData))
            ->getMock();

        $orderWarehouseItems = new OrderWarehouseItems($repositoryMock);
        $orderEntryCollection = OrderEntryCollection::create($orderEntryData);

        if ($expectedExceptionMessage) {
            $this->expectExceptionMessage($expectedExceptionMessage);
            $orderWarehouseItems->execute($orderEntryCollection);
        } else {
            $orderWarehouseItems->execute($orderEntryCollection);
            $warehouseAfterOrder = $orderWarehouseItems->getWarehouseCollection();

            for ($i = 0; $i < count($orderEntryData); $i++) {
                $this->assertEquals(
                    0, $orderEntryCollection->getIterator()->offsetGet($i)->getItems()[0]->getQuantity()
                );
                $this->assertEquals(
                    $quantityAfterOrder[$i],
                    $warehouseAfterOrder->getIterator()->offsetGet(0)->getItems()[0]->getQuantity()
                );
            }
        }
    }


    public function provideData(): array
    {
        return [
            'case dead warehouse' => [
                'warehouse' => self::getDeadWarehouseMock(),
                'orderEntry' => [
                    [
                        'customer' => 'Magdalena Iksi??ska',
                        'items' => [
                            new OrderEntryItem(1, 1),
                        ],
                    ],
                ],
                'Not enough`t items in warehouses',
                [],
            ],
            'case small order' => [
                'warehouse' => self::getWarehouseDataMock(),
                'orderEntry' => [
                    [
                        'customer' => 'Magdalena Iksi??ska',
                        'items' => [
                            new OrderEntryItem(1, 1),
                        ],
                    ],
                ],
                null,
                [4, 4, 3],
            ],
            'case all stock order' => [
                'warehouse' => self::getWarehouseDataMock(),
                'orderEntry' => [
                    [
                        'customer' => 'Magdalena Iksi??ska',
                        'items' => [
                            new OrderEntryItem(1, 5),
                        ],
                    ],
                    [
                        'customer' => 'Dawid Kliencki',
                        'items' => [
                            new OrderEntryItem(1, 4),
                        ],
                    ],
                    [
                        'customer' => 'Gra??yna McCafe',
                        'items' => [
                            new OrderEntryItem(1, 3),
                        ],
                    ],

                ],
                null,
                [0, 0, 0],
            ],
            'case to large order' => [
                'warehouse' => self::getWarehouseDataMock(),
                'orderEntry' => [
                    [
                        'customer' => 'Magdalena Iksi??ska',
                        'items' => [
                            new OrderEntryItem(1, 6),
                        ],
                    ],
                    [
                        'customer' => 'Dawid Kliencki',
                        'items' => [
                            new OrderEntryItem(1, 7),
                        ],
                    ],
                    [
                        'customer' => 'Gra??yna McCafe',
                        'items' => [
                            new OrderEntryItem(1, 20),
                        ],
                    ],

                ],
                'Not enough`t items in warehouses',
            ],
        ];
    }


    private static function getWarehouseDataMock(): array
    {
        /**
         * Model danych z pomini??ciem bazy jest uproszczony.
         * w bazie nie ma sensu powiela?? ca??ych produkt??w per magazyn.
         * Ilo???? produkt??w w danbym magazynie lepiej wyrazi?? w tabeli relacyjnej
         */

        return [
            [
                'name' => 'Magazyn G????wny',
                'items' => [
                    new WarehouseItem(1, 'Filtr do kawy', 5),
                ],
                'healthy' => true,
            ],
            [
                'name' => 'Magazyn Katowice',
                'items' => [
                    new WarehouseItem(1, 'Filtr do kawy', 4),
                ],
                'healthy' => true,
            ],
            [
                'name' => 'Magazyn Gda??sk',
                'items' => [
                    new WarehouseItem(1, 'Filtr do kawy', 3),
                ],
                'healthy' => true,
            ],
        ];
    }

    private static function getDeadWarehouseMock(): array
    {
        return [
            [
                'name' => 'Magazyn z kt??rego nie mozna zam??wi??',
                'items' => [
                    new OrderEntryItem(1, 5),
                ],
                'healthy' => false,
            ],
        ];
    }
}
