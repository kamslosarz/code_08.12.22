<?php

namespace App\Domain\Validator\Constraint;

use App\Domain\DomainLogicException;
use App\Validator\Constraint\ConstraintException;
use App\ValueObject\OrderEntryItem;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\DataProvider\OrderEntryDataProvider;

class OrderEntrySufficientItemsConstraintTest extends TestCase
{
    /**
     * @return void
     * @throws ConstraintException
     * @doesNotPerformAssertions
     */
    public function testShouldExecuteConstraintSuccess()
    {
        $constraint = new OrderEntrySufficientItemsConstraint();

        $orderEntryItem = Mockery::mock(OrderEntryItem::class)
            ->shouldReceive('getQuantity')
            ->andReturn(0)
            ->getMock();

        $orderEntry = OrderEntryDataProvider::getOrderEntryMock([$orderEntryItem]);
        $orderEntryCollection = OrderEntryDataProvider::getCollectionMock($orderEntry);

        $constraint->validate($orderEntryCollection);

        $orderEntryCollection->shouldHaveReceived('getIterator')->once();
        $orderEntry->shouldHaveReceived('getItems')->once();
        $orderEntryItem->shouldHaveReceived('getQuantity')->once();
    }

    /**
     * @return void
     * @dataProvider failureCases
     * @throws ConstraintException
     */
    public function testShouldExecuteConstraintFailed($value, string $exception, string $exceptionMessage)
    {
        $constraint = new OrderEntrySufficientItemsConstraint();

        $this->expectException($exception);
        $this->expectExceptionMessage($exceptionMessage);

        $constraint->validate($value);
    }

    public function failureCases(): array
    {
        return [
            [
                null,
                DomainLogicException::class,
                'Invalid order data',
            ],
            [
                OrderEntryDataProvider::getCollectionMock(
                    OrderEntryDataProvider::getOrderEntryMock([
                        Mockery::mock(OrderEntryItem::class)
                            ->shouldReceive('getQuantity')
                            ->andReturn(1)
                            ->getMock(),
                    ])
                ),
                ConstraintException::class,
                'Not enough`t items in warehouses',
            ],
        ];
    }


}
