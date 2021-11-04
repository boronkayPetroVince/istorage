<?php


namespace App\Service;


use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TelepulesService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(City::class);
    }
    public function getAllTelepules():iterable{

    }
    public function getAllTelepulesByOrszag(int $orszagID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("telepules")
            ->from(City::class, "telepules")
            ->where("telepules.orszag_ID =: orszagID")
            ->setParameter("orszagID", $orszagID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllTelepulesByOrszag(int $orszagID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(City::class, "telepules")
            ->where("telepules.orszag_ID =: orszagID")
            ->setParameter("orszagID", $orszagID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneTelepulesById(int $id): City{
        return $this->getRepo()->find($id);
    }
    public function addTelepules(City $telepules):void{
        $this->em->persist($telepules);
        $this->em->flush();
    }
    public function removeTelepules(int $id):void{
        $this->em->remove($this->getOneTelepulesById($id));
        $this->em->flush();
    }


}