<?php


namespace App\Service;


use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ClientService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Client::class);
    }

    public function getAllClient():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneClientById(int $id):Client{
        return $this->getRepo()->find($id);
    }
    public function addClient(Client $client):void{
        $this->em->persist($client);
        $this->em->flush();
    }
    public function removeClient(int $id):void{
        $this->em->remove($this->getOneClientById($id));
        $this->em->flush();
    }




}