<?php

namespace App\Service;

use App\Collection\CollectionInterface;
use App\Collection\OrderEntryCollection;
use App\Collection\WarehouseCollection;
use App\Domain\DomainLogicException;
use App\Domain\WarehouseNegotiator;
use App\Repository\WarehouseRepositoryInterface;
use App\Validator\Constraint\ConstraintException;
use App\Validator\Validator;
use App\Domain\Validator\Constraint\OrderEntrySufficientItemsConstraint;

final class OrderWarehouseItems
{
    private WarehouseRepositoryInterface $warehouseRepository;
    private WarehouseCollection $warehouseCollection;

    public function __construct(WarehouseRepositoryInterface $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    /**
     * @param CollectionInterface $orderEntryCollection
     * @throws ConstraintException
     */
    public function execute(CollectionInterface $orderEntryCollection): void
    {
        if (!($orderEntryCollection instanceof OrderEntryCollection)) {
            throw new DomainLogicException('Invalid order data');
        }

        $this->warehouseCollection = WarehouseCollection::create([]);
        (new WarehouseNegotiator($this->warehouseRepository))->negotiate(
            $orderEntryCollection,
            $this->warehouseCollection
        );

        $orderValidator = new Validator();
        $orderValidator->addConstraint(new OrderEntrySufficientItemsConstraint());
        $orderValidator->validate($orderEntryCollection);
    }

    /**
     * @return WarehouseCollection
     */
    public function getWarehouseCollection(): WarehouseCollection
    {
        return $this->warehouseCollection;
    }
}
