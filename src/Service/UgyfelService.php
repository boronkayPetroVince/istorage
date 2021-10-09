<?php


namespace App\Service;


use App\Entity\Ugyfel;
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
        return $this->em->getRepository(Ugyfel::class);
    }

    public function getAllUgyfel():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneUgyfelById(int $id):Ugyfel{
        return $this->getRepo()->find($id);
    }
    public function addUgyfel(Ugyfel $ugyfel):void{
        $this->em->persist($ugyfel);
        $this->em->flush();
    }
    public function removeUgyfel(int $id):void{
        $this->em->remove($this->getOneUgyfelById($id));
        $this->em->flush();
    }




}