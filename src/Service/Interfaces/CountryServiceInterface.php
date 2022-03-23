<?php


namespace App\Service\Interfaces;


use App\Entity\Country;

interface CountryServiceInterface
{
    public function getAllCountry():iterable;

    public function getOneCountryById(int $id):Country;

    public function addCountry(Country $country):void;
}