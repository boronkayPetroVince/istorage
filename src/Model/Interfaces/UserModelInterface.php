<?php


namespace App\Model\Interfaces;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface UserModelInterface
{
    public function addUser(Request $request):bool;

    public function loginAction(Request $request, User $user):bool;

    public function updateUser(Request $request,int $userId):bool;

    public function changePass(Request $request, User $user):bool;

    public function AllUserDetails():Response;

    public function oneUserDetails(Request $request, User $user):User;

    public function removeUser(Request $request): bool;

    public function getAllUser():Response;

    public function checkUser(string $username):bool;


}