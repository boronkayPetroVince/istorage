<?php


namespace App\Service\Interfaces;


use App\Entity\Status;

interface StatusServiceInterface
{
    public function getAllStatus():iterable;

    public function getOneStatusById(int $id):Status;

}