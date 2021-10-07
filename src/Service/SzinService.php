<?php


namespace App\Service;


use App\Entity\Szin;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class SzinService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Szin::class);
    }

    public function getAllSzin():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneSzinById(int $id):Szin{
        return $this->getRepo()->find($id);
    }
    public function addSzin(Szin $szin):void{
        $this->em->persist($szin);
        $this->em->flush();
    }
    public function removeSzin(int $id):void{
        $this->em->remove($this->getOneSzinById($id));
        $this->em->flush();
    }


}