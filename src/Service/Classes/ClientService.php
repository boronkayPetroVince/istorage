<?php


namespace App\Service\Classes;


use App\Entity\Client;
use App\Service\Interfaces\ClientServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ClientService extends CrudService implements ClientServiceInterface
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

    public function getOneClientBySelect(int $id): iterable
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select("client")
            ->from(Client::class, "client")
            ->where("client.id = :id")
            ->setParameter("id",$id);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function addClient(Client $client):void{
        $this->em->persist($client);
        $this->em->flush();
    }

    public function updateClient(int $id):void{
        $client = $this->getOneClientById($id);
        $this->em->persist($client);
        $this->em->flush();
    }




}