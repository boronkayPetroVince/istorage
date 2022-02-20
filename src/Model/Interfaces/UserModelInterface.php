<?php


namespace App\Model\Interfaces;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface UserModelInterface
{
    public function addUser(Request $request):bool;

    public function loginAction(Request $request, User $user):bool;

    public function updateUser(Request $request,int $userId):bool;

    public function updateLoggedUser(Request $request, User $user): bool;

    public function changePass(Request $request, User $user):bool;

    public function checkUser(string $username):bool;


}