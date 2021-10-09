<?php


namespace App\Entity;


use App\Service\CrudService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class OrszagService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Orszag::class);
    }
    public function getAllOrszag():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneOrszagById(int $id):Orszag{
        return $this->getRepo()->find($id);
    }
    public function addOrszag(Orszag $orszag):void{
        $this->em->persist($orszag);
        $this->em->flush();
    }
    public function removeOrszag(int $id):void{
        $this->em->remove($this->getOneOrszagById($id));
        $this->em->flush();
    }


}