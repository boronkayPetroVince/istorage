<?php


namespace App\Model\Interfaces;


use App\Entity\Status;
use App\Entity\Stock;
use App\Entity\User;
use App\Entity\Warehouse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface StockModelInterface
{
    public function addStock(Request $request, User $user): bool;

    public function sellStock(Request $request, User $user):bool;

    public function edit(Request $request, int $stockId, User $user): bool;

    public function allWarehouse():iterable;

    public function allArrivedStock():iterable;

    public function allOrderedStock():iterable;

    public function allSoldStock():iterable;

    public function allStatus():iterable;

    public function oneStockById(int $id):Stock;

    public function checkCapacity(Warehouse $warehouse, int $amount):bool;

    public function checkStockAmount(Stock $stock, int $amount):bool;

    public function stockCount():int;

    public function warehouseById():Warehouse;

    public function monthOutgoing():int;

    public function monthIncoming():int;

    public function allIncomingsPerMonths(string $month):int;


}