<?php


namespace App\Service;


use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UgyfelService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Client::class);
    }

    public function getAllUgyfel():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneUgyfelById(int $id):Client{
        return $this->getRepo()->find($id);
    }
    public function addUgyfel(Client $ugyfel):void{
        $this->em->persist($ugyfel);
        $this->em->flush();
    }
    public function removeUgyfel(int $id):void{
        $this->em->remove($this->getOneUgyfelById($id));
        $this->em->flush();
    }




}