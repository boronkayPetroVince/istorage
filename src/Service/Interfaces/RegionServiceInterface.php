<?php


namespace App\Service\Interfaces;


use App\Entity\Region;

interface RegionServiceInterface
{
    public function getAllRegion():iterable;

    public function getOneRegionByName(string $name):Region;

    public function getAllRegionByCountry(int $country_ID):iterable;

    public function getOneRegionById(int $id):Region;
}