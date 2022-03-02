<?php


namespace App\Model\Interfaces;


use App\Entity\Status;
use App\Entity\Stock;
use App\Entity\User;
use App\Entity\Warehouse;
use Symfony\Component\HttpFoundation\Request;

interface StockModelInterface
{
    public function addStock(Request $request, User $user): bool;

    public function sellStock(Request $request, User $user):bool;

    public function filteredStock(Request $request):iterable;

    public function edit(Request $request, int $stockId): bool;

    public function allWarehouse():iterable;

    public function allArrivedStock():iterable;

    public function allOrderedStock():iterable;

    public function allStatus():iterable;

    public function oneStockById(int $id):Stock;

    public function checkCapacity(Warehouse $warehouse, int $amount):bool;


}