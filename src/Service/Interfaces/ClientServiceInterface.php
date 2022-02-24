<?php


namespace App\Service\Interfaces;


use App\Entity\Client;

interface ClientServiceInterface
{
    public function getAllClient():iterable;

    public function getOneClientById(int $id):Client;

    public function getOneClientBySelect(int $id):iterable;

    public function addClient(Client $client):void;

    public function updateClient(int $id):void;


}