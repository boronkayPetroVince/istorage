<?php


namespace App\Service;


use App\Entity\Elerhetoseg;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ElerhetosegService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Elerhetoseg::class);
    }

    public function getAllElerhetoseg():iterable{
        return $this->getRepo()->findAll();
    }
    public function getAllElerhetosegByUgyfel(int $ugyfelID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("elerhetoseg")
            ->from(Elerhetoseg::class, "elerhetoseg")
            ->where("elerhetoseg.ugyfel_ID =: ugyfelID")
            ->setParameter("ugyfelID", $ugyfelID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllElerhetosegByUgyfel(int $ugyfelID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Elerhetoseg::class, "elerhetoseg")
            ->where("elerhetoseg.ugyfel_ID =: ugyfelID")
            ->setParameter("ugyfelID", $ugyfelID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneElerhetosegById(int $id):Elerhetoseg{
        return $this->getRepo()->find($id);
    }
    public function addElerhetoseg(Elerhetoseg $elerhetoseg):void{
        $this->em->persist($elerhetoseg);
        $this->em->flush();
    }
    public function removeElerhetoseg(int $id):void{
        $this->em->remove($this->getOneElerhetosegById($id));
        $this->em->flush();
    }
}