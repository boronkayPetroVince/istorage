<?php


namespace App\Model\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface StockModelInterface
{
    public function listAllStock(Request $request): bool;

    public function addStock(Request $request): bool;

    public function editStock(Request $request): bool;

    public function removeStock(Request $request): bool;

    public function changeStatus(Request $request): bool;


}