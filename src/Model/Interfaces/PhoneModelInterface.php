<?php


namespace App\Model\Interfaces;


use App\Entity\Brand;
use App\Entity\Capacity;
use App\Entity\Color;
use App\Entity\Model;
use App\Entity\Phone;
use App\Entity\Stock;
use Symfony\Component\HttpFoundation\Request;

interface PhoneModelInterface
{
    public function addPhone(Request $request): bool;

    public function existPhone(Brand $brand, Model $model, Color $color, Capacity $capacity):Phone;

    public function updatePhone(Request $request, int $phoneID): Phone;

    public function getAllBrand():iterable;

    public function allModelByBrand(Request $request): iterable;

    public function allColorByModel(Request $request): iterable;

    public function allCapacityByModell(Request $request): iterable;

    public function filteredPhones(Request $request): iterable;

    public function checkBrand(string $brandName):bool;

    public function checkModel(string $modelName):bool;

    public function checkColor(string $colorName):bool;

    public function checkCapacity(int $capacity):bool;


}