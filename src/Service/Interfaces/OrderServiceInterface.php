<?php


namespace App\Service\Interfaces;


use App\Entity\Order;

interface OrderServiceInterface
{
    public function getAllOrder():iterable;

    public function getAllOrderByUser(int $user_ID):iterable;

    public function removeAllOrderByUser(int $user_ID):iterable;

    public function getAllOrderByDeliveryAddress(int $delivery_ID):iterable;

    public function removeAllOrderByDeliveryAddress(int $delivery_ID):iterable;

    public function getAllOrderByPhone(int $phone_ID):iterable;

    public function removeAllOrderByPhone(int $phone_ID):iterable;

    public function getAllOrderByWarehouser(int $warehouse_ID):iterable;

    public function removeAllOrderByWarehouse(int $raktarID):iterable;

    public function getOneOrderById(int $id):Order;

    public function addOrder(Order $order):void;

    public function removeOrder(int $id):void;

    public function currentMonthIncomings():int;

    public function allIncomingsPerMonth(string $month):int;
}