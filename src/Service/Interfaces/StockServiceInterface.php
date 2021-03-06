<?php


namespace App\Service\Interfaces;


use App\Entity\Stock;
use App\Entity\Warehouse;

interface StockServiceInterface
{
    public function getAllStock():iterable;

    public function getAllStockByStatus(string $statusName):iterable;

    public function getOneStockById(int $id):Stock;

    public function addStock(Stock $stock):void;

    public function updateStock(int $id):void;

    public function stockCount():int;

    public function stockCountByStatus(string $statusName): int;

    public function currentMonthOutgoings():int;

    public function allArrivedStockPerWeek():iterable;

    public function originalWhCapacity(Warehouse $warehouse):int;
}