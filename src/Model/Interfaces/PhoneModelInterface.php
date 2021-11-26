<?php


namespace App\Model\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface PhoneModelInterface
{
    public function addPhone(Request $request): bool;

    public function updatePhone(Request $request): bool;

    public function removePhone(Request $request): bool;
}