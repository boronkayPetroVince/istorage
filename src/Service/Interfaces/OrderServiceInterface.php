<?php


namespace App\Service\Interfaces;


use App\Entity\Order;

interface OrderServiceInterface
{
    public function getAllOrder():iterable;

    public function getAllOrderByWarehouse(int $warehouse_ID):iterable;

    public function getOneOrderById(int $id):Order;

    public function addOrder(Order $order):void;

    public function removeOrder(int $id):void;

    public function currentMonthIncomings():int;

    public function allIncomingsPerMonth(string $month):int;

    public function allOrderPerWeek():iterable;

    public function lastSell():iterable;
}