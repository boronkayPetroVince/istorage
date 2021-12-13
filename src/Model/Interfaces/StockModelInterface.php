<?php


namespace App\Model\Interfaces;


use App\Entity\Stock;
use Symfony\Component\HttpFoundation\Request;

interface StockModelInterface
{
    public function listAllStock(Request $request): bool;

    public function addStock(Request $request): bool;

    public function editStock(Request $request): bool;

    public function removeStock(Request $request): bool;

    public function changeStatusBystockID(Request $request, int $stockId): bool;

    public function allWarehouse():iterable;

    public function allStock():iterable;

    public function allStatus():iterable;

    public function oneStockById(int $id):Stock;


}