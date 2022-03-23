<?php


namespace App\Service\Interfaces;


use App\Entity\Model;

interface ModelServiceInterface
{
    public function getAllModel():iterable;

    public function getAllModelByBrand(int $brand_ID):iterable;

    public function getOneModelById(int $id):Model;

    public function getOneModelByName(string $name):Model;

    public function addModel(Model $model):void;




}