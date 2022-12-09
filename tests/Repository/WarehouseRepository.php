<?php

use App\Repository\WarehouseRepository;
use PHPUnit\Framework\TestCase;

class WarehouseRepositoryTest extends TestCase
{
    public function testShouldGetAllElementsFromRepository()
    {
        $repository = new WarehouseRepository();

        /*
         * Empty data due skip data source communication
         */
        self::assertEquals([], $repository->all());
    }
}
