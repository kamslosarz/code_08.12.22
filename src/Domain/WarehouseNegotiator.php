<?php

namespace App\Domain;

use App\Collection\CollectionException;
use App\Collection\OrderEntryCollection;
use App\Collection\WarehouseCollection;
use App\Domain\Collection\ItemsToOrderCollection;
use App\Entity\Warehouse;
use App\Repository\WarehouseRepositoryInterface;
use App\ValueObject\OrderEntryItem;

final class WarehouseNegotiator
{
    private WarehouseRepositoryInterface $warehouseRepository;

    public function __construct(WarehouseRepositoryInterface $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    /**
     * @throws CollectionException
     */
    public function negotiate(
        OrderEntryCollection $orderEntryCollection,
        WarehouseCollection $warehouseCollection
    ): void {
        $itemsToOrderCollection = ItemsToOrderCollection::createFromOrderEntryCollection($orderEntryCollection);

        /** @var Warehouse $warehouse */
        foreach ($this->warehouseRepository->all() as $warehouse) {
            /** @var OrderEntryItem $orderEntryItem */
            if($warehouse->isHealthy()){
                foreach ($itemsToOrderCollection as $orderEntryItem) {
                    if ($orderEntryItem->getQuantity()) {
                        $warehouseCollection->add($warehouse);
                        $itemsInWarehouseCount = $warehouse->getItemsCount($orderEntryItem->getId());
                        $warehouse->reduceQuantity($orderEntryItem->getId(), $orderEntryItem->getQuantity());
                        $orderEntryItem->reduceQuantity($itemsInWarehouseCount);
                    }
                }
            }
        }
    }
}
