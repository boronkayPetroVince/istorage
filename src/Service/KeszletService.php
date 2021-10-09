<?php


namespace App\Service;


use App\Entity\Keszlet;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Utils;

class KeszletService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Keszlet::class);
    }
    public function getAllKeszlet():iterable{
        return $this->getRepo()->findAll();
    }
    public function getAllKeszletByRaktar(int $raktarID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("keszlet")
            ->from(Keszlet::class, "keszlet")
            ->where("keszlet.raktar_ID =: raktarID")
            ->setParameter("raktarID", $raktarID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllKeszletByRaktar(int $raktarID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Keszlet::class, "keszlet")
            ->where("keszlet.raktar_ID =: raktarID")
            ->setParameter("raktarID", $raktarID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllKeszletByTelefon(int $telefonID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("keszlet")
            ->from(Keszlet::class, "keszlet")
            ->where("keszlet.telefon_ID =: telefonID")
            ->setParameter("telefonID", $telefonID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllKeszletByTelefon(int $telefonID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Keszlet::class, "keszlet")
            ->where("keszlet.telefon_ID =: telefonID")
            ->setParameter("telefonID", $telefonID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneKeszletById(int $id):Keszlet{
        return $this->getRepo()->find($id);
    }
    public function addKeszlet(Keszlet $keszlet):void{
        $this->em->persist($keszlet);
        $this->em->flush();
    }
    public function removeKeszlet(int $id):void{
        $this->em->remove($this->getOneKeszletById($id));
        $this->em->flush();
    }


}