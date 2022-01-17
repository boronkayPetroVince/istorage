<?php


namespace App\Model\Interfaces;


use App\Entity\Phone;
use App\Entity\Stock;
use Symfony\Component\HttpFoundation\Request;

interface PhoneModelInterface
{
    public function addPhone(Request $request): Phone;

    public function updatePhone(Request $request): bool;

    public function allPhones(): iterable;

    //public function allOrderedPhone(): iterable;

    //public function allArrivedPhone(): iterable;

    public function allModelByBrand(Request $request): iterable;

    public function allColorByModel(Request $request): iterable;

    public function allCapacityByColor(Request $request): iterable;

    public function filteredPhones(Request $request): iterable;

    public function checkBrand(string $brandName):bool;

    public function checkModel(string $modelName):bool;

    public function checkColor(string $colorName):bool;

    public function checkCapacity(int $capacity):bool;


}