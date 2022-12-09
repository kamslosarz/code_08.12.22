<?php

namespace App\ValueObject;

class OrderEntry
{
    private string $customer;
    private array $items;

    public function __construct(string $customer, array $items)
    {
        $this->customer = $customer;
        $this->items = $items;
    }

    /**
     * @return string
     */
    public function getCustomer(): string
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     * @return OrderEntry
     */
    public function setCustomer(string $customer): OrderEntry
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function setItems(array $items): OrderEntry
    {
        $this->items = $items;

        return $this;
    }
}
