<?php


namespace App\Model\Interfaces;


use App\Entity\Settlement;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ClientModelInterface
{
    public function addClient(Request $request, User $user): bool;

    public function updateClient(Request $request, int $clientId): bool;

    public function getOneSettlement(Request $request):Response;

    public function getAllCountry():Response;

    public function allClients(): iterable;
}