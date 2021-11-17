<?php


namespace App\Service\Interfaces;


use App\Entity\Contact;

interface ContactServiceInterface
{
    public function getAllContact():iterable;

    public function getAllContactByClient(int $client_ID):iterable;

    public function removeAllContactByClient(int $client_ID):iterable;

    public function getOneContactById(int $id):Contact;

    public function addContact(Contact $contact):void;

    public function removeContact(int $id):void;

}