<?php


namespace App\Service\Interfaces;


use App\Entity\Delivery_address;

interface DeliveryServiceInterface
{
    public function getAllDelivery():iterable;

    public function getOneAddressById(int $id):Delivery_address;

    public function addAddress(Delivery_address $address):void;

    public function updateAddress(int $id):void;
}