<?php


namespace App\Service\Interfaces;


use App\Entity\Phone;

interface PhoneServiceInterface
{
    public function getAllPhone():iterable;

    public function getAllFilteredPhone(int $brand_ID,int $model_ID, int $color_ID, int $capacity_ID): iterable;

    public function getAllPhoneByBrand(int $brand_ID):iterable;

    public function getAllPhoneByModel(int $model_ID):iterable;

    public function getAllCapacityByModel(int $model_ID, int $color_ID):iterable;

    public function getOnePhoneById(int $id):Phone;

    public function addPhone(Phone $phone):void;

    public function updatePhone(int $id):void;

    public function removePhone(int $id):void;


}