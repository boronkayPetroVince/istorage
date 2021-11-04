<?php


namespace App\Service;


use App\Entity\Color;
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
        return $this->em->getRepository(Color::class);
    }

    public function getAllSzin():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneSzinById(int $id):Color{
        return $this->getRepo()->find($id);
    }
    public function addSzin(Color $szin):void{
        $this->em->persist($szin);
        $this->em->flush();
    }
    public function removeSzin(int $id):void{
        $this->em->remove($this->getOneSzinById($id));
        $this->em->flush();
    }


}