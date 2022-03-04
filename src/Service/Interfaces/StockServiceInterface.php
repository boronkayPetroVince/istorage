<?php


namespace App\Service\Interfaces;


use App\Entity\Stock;

interface StockServiceInterface
{
    public function getAllStock():iterable;

    public function getAllStockByStatus(string $statusName):iterable;

    public function getOneStockById(int $id):Stock;

    public function addStock(Stock $stock):void;

    public function updateStock(int $id):void;

    public function removeStock(int $id):void;

    public function stockCount(string $statusName):int;

    public function currentMonthOutgoings():int;
}