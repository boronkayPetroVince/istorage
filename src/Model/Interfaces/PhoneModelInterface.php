<?php


namespace App\Model\Interfaces;


use App\Entity\Phone;
use Symfony\Component\HttpFoundation\Request;

interface PhoneModelInterface
{
    public function addPhone(Request $request): Phone;

    public function updatePhone(Request $request): bool;

    public function allPhones(): iterable;

    public function allBrands(): iterable;

    public function allModelByBrand(int $brand_ID): iterable;

    public function allColorByModel(Request $request, int $model_ID): iterable;

    public function allCapacityByColor(Request $request, int $color_ID): iterable;

    public function checkBrand(string $brandName):bool;

    public function checkModel(string $modelName):bool;

    public function checkColor(string $colorName):bool;

    public function checkCapacity(int $capacity):bool;


}