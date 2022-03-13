<?php


namespace App\Service\Interfaces;


use App\Entity\User;

interface SecurityServiceInterface
{
    public function getAllUser():iterable;

    public function getOneUserById(int $id):User;

    public function addUser(string $username, string $password, string $fullName, string $email, int $phoneNumber, string $role,  string $number):void;

    public function updateUser(int $id):void;

    public function getOneUserByName(string $name): User;

    public function removeUser(int $id):void;

    public function checkPassword(string $username, string $password):bool;
}