<?php


namespace App\Model\Interfaces;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface UserModelInterface
{
    public function addUser(Request $request):bool;

    public function loginAction(Request $request, User $user):bool;

    public function updateUser(Request $request):bool;

    public function getAllUserDetails():Response;

    public function oneUserDetails(Request $request):Response;

    public function removeUser(Request $request): Response;

    public function getAllUser():Response;

    public function getOneUser(Request $request):Response;

    public function checkUser(string $username):bool;


}