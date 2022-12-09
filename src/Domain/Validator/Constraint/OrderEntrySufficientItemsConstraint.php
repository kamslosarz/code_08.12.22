<?php

namespace App\Domain\Validator\Constraint;

use App\Collection\OrderEntryCollection;
use App\Domain\DomainLogicException;
use App\Validator\Constraint\ConstraintException;
use App\Validator\Constraint\ConstraintInterface;
use App\ValueObject\OrderEntry;

final class OrderEntrySufficientItemsConstraint implements ConstraintInterface
{
    public function validate($value): void
    {
        if (!($value instanceof OrderEntryCollection)) {
            throw new DomainLogicException('Invalid order data');
        }

        /** @var OrderEntry $orderEntry */
        foreach ($value as $orderEntry) {
            foreach ($orderEntry->getItems() as $orderEntryItem) {
                if ($orderEntryItem->getQuantity()) {
                    throw new ConstraintException('Not enough`t items in warehouses');
                }
            }
        }
    }
}
