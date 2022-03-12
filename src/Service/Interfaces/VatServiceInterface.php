<?php


namespace App\Service\Interfaces;


interface VatServiceInterface
{
    public function getAllVat():iterable;

    public function getOneVatById(int $id):iterable;
}