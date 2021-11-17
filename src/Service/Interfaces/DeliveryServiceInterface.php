<?php


namespace App\Service\Interfaces;


use App\Entity\Delivery_address;

interface DeliveryServiceInterface
{
    public function getAllDelivery():iterable;

    public function getAllAddressBySettlement(int $settlement_ID):iterable;

    public function removeAllAddressBySettlement(int $settlement_ID):iterable;

    public function getAllAddressByClient(int $client_ID):iterable;

    public function removeAllAddressByClient(int $client_ID):iterable;

    public function getOneAddressById(int $id):Delivery_address;

    public function addAddress(Delivery_address $address):void;

    public function removeAddress(int $id):void;

    public function updateAddress(int $id):void;
}