<?php


namespace App\Service;


use App\Entity\Marka;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class MarkaService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }
    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Marka::class);
    }

    public function getAllMarka():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneMarkaById(int $id):Marka{
        return $this->getRepo()->find($id);
    }
    public function addMarka(Marka $marka):void{
        $this->em->persist($marka);
        $this->em->flush();
    }
    public function removeMarka(int $id):void{
        $this->em->remove($this->getOneMarkaById($id));
        $this->em->flush();
    }

}