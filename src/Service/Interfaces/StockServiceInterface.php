<?php


namespace App\Service\Interfaces;


use App\Entity\Stock;

interface StockServiceInterface
{
    public function getAllStock():iterable;

    public function getAllStockByWarehouse(int $warehouse_ID):iterable;

    public function getAllStockByStatus(string $status):Stock;

    public function removeAllStockByWarehouse(int $warehouse_ID):iterable;

    public function getAllStockByPhone(int $phone_ID):iterable;

    public function getAllBrandByStatus(int $status_ID):iterable;

    public function getAllModelByStatusAndBrand(int $status_ID, int $brand_ID):iterable;

    public function getAllColorByStatusAndModel(int $status_ID, int $model_ID):iterable;



    public function getOneStockById(int $id):Stock;

    public function addStock(Stock $stock):void;

    public function updateStock(int $id):void;

    public function removeStock(int $id):void;
}