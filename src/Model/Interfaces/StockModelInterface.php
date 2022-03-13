<?php


namespace App\Model\Interfaces;


use App\Entity\Order;
use App\Entity\Status;
use App\Entity\Stock;
use App\Entity\User;
use App\Entity\Warehouse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface StockModelInterface
{
    public function addStock(Request $request, User $user): bool;

    public function sellStock(Request $request, User $user):iterable;

    public function lastSoldStockData(Order $order, array $list):Response;

    public function edit(Request $request, int $stockId, User $user): bool;

    public function allWarehouse():iterable;

    public function allArrivedStock():iterable;

    public function allOrderedStock():iterable;

    public function allSoldStock():iterable;

    public function allStatus():iterable;

    public function oneStockById(int $id):Stock;

    public function checkCapacity(Warehouse $warehouse, int $amount):bool;

    public function addSoldStockAmountToWarehouse(Warehouse $warehouse,int $amount):void;

    public function checkStockAmount(Stock $stock, int $amount):bool;

    public function stockCount():int;

    public function warehouseById():Warehouse;

    public function monthOutgoing():int;

    public function monthIncoming():int;

    public function allIncomingsPerMonths():iterable;

    public function allOrderPerWeek():iterable;

    public function allArrivedStockPerWeek():iterable;

    public function lastSell():iterable;

    public function billPDF(Request $request);

    public function OrderedPDF(string $html);

    public function OrderedExcel();

    public function ArrivedPDF(string $html);

    public function ArrivedExcel();
}