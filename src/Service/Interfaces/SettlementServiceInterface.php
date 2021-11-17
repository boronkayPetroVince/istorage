<?php


namespace App\Service\Interfaces;


use App\Entity\Settlement;

interface SettlementServiceInterface
{
    public function getAllSettlement():iterable;

    public function getOneSettlementByPostalcode(int $postalcode): Settlement;

    public function getAllSettlementByRegion(int $region_ID):iterable;

    public function getOneSettlementById(int $id): Settlement;
}