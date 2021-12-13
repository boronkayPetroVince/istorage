<?php


namespace App\Service\Interfaces;


use App\Entity\Warehouse;

interface WarehouseServiceInterface
{
    public function getAllWarehouse():iterable;

    public function getOneWarehouseById(int $id):Warehouse;

    public function getOneWarehouseByName(string $name):Warehouse;

    public function addWarehouse(Warehouse $warehouse):void;

    public function updateWarehouse(int $id):void;

    public function removeWarehouse(int $id):void;
}