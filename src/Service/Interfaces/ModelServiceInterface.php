<?php


namespace App\Service\Interfaces;


use App\Entity\Model;

interface ModelServiceInterface
{
    public function getAllModel():iterable;

    public function getAllModelByBrand(int $brand_ID):iterable;

    public function removeAllModelByBrand(int $brand_ID):iterable;

    public function getOneModelById(int $id):Model;

    public function addModel(Model $model):void;

    public function removeModel(int $id):void;
}