<?php


namespace App\Service\Interfaces;


use App\Entity\Contact;

interface ContactServiceInterface
{
    public function getAllContact():iterable;

    public function getOneContactById(int $id):Contact;

    public function addContact(Contact $contact):void;

    public function updateContact(int $id):void;

}