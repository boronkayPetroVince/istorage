<?php


namespace App\Service\Interfaces;


use App\Entity\Phone;

interface PhoneServiceInterface
{
    public function getAllPhone():iterable;

    public function getAllPhoneByModel(int $model_ID):iterable;

    public function getAllPhoneByColor(int $color_ID):iterable;

    public function getAllPhoneByBrand(int $brand_ID):iterable;

    public function removeAllPhoneByBrand(int $brand_ID):iterable;

    public function removeAllPhoneByModel(int $model_ID):iterable;

    public function removeAllPhoneByColor(int $color_ID):iterable;

    public function getOnePhoneById(int $id):Phone;

    public function removePhone(int $id):void;


}