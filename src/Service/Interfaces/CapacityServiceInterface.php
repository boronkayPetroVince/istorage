<?php


namespace App\Service\Interfaces;


use App\Entity\Capacity;

interface CapacityServiceInterface
{
    public function getAllCapacity():iterable;

    public function getOneCapacityById(int $id):Capacity;

    public function getOneCapacityByMemory(int $memory): Capacity;

    public function addCapacity(Capacity $capacity):void;

    public function updateCapacity(int $id):void;

    public function removeCapacity(int $id):void;
}