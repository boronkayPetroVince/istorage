<?php


namespace App\Service\Interfaces;


use App\Entity\Brand;

interface BrandServiceInterface
{
    public function getAllBrand():iterable;

    public function getOneBrandById(int $id):Brand;

    public function getOneBrandByName(string $name):Brand;

    public function addBrand(Brand $brand):void;

    public function updateBrand(int $id):void;

    public function removeBrand(int $id):void;
}