<?php


namespace App\Service\Interfaces;


use App\Entity\Color;

interface ColorServiceInterface
{
    public function getAllColor():iterable;

    public function getOneColorById(int $id):Color;

    public function addColor(Color $color):void;

    public function removeColor(int $id):void;

}