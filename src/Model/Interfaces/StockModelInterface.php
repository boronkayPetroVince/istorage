<?php


namespace App\Model\Interfaces;


use App\Entity\Status;
use App\Entity\Stock;
use Symfony\Component\HttpFoundation\Request;

interface StockModelInterface
{
    public function addStock(Request $request): bool;

    public function filteredStock(Request $request):iterable;

    public function edit(Request $request, int $stockId): bool;

    public function allWarehouse():iterable;

    public function allStock():iterable;

    public function allStatus():iterable;

    public function oneStockById(int $id):Stock;


}