<?php


namespace App\Service;


use App\Entity\Rendeles;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class RendelesService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Rendeles::class);
    }
    public function getAllRendeles():iterable{
        return $this->getRepo()->findAll();
    }
    public function getAllRendelesByFelhasznalo(int $felhaszID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("rendeles")
            ->from(Rendeles::class, "rendeles")
            ->where("rendeles.felhasz_ID =: felhaszID")
            ->setParameter("felhaszID", $felhaszID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllRendelesByFelhasznalo(int $felhaszID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Rendeles::class, "rendeles")
            ->where("rendeles.felhasz_ID =: felhaszID")
            ->setParameter("felhaszID", $felhaszID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllRendelesBySzalitasiCim(int $szallitasID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("rendeles")
            ->from(Rendeles::class, "rendeles")
            ->where("rendeles.szallitas_ID =: szallitasID")
            ->setParameter("szallitasID", $szallitasID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllRendelesBySzalitasiCim(int $szallitasID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Rendeles::class, "rendeles")
            ->where("rendeles.szallitas_ID =: szallitasID")
            ->setParameter("szallitasID", $szallitasID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllRendelesByTelefon(int $telefonID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("rendeles")
            ->from(Rendeles::class, "rendeles")
            ->where("rendeles.telefon_ID =: telefonID")
            ->setParameter("telefonID", $telefonID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllRendelesByTelefon(int $telefonID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Rendeles::class, "rendeles")
            ->where("rendeles.telefon_ID =: telefonID")
            ->setParameter("telefonID", $telefonID);
        $query = $qb->getQuery();
        return $query->getResult();

    }
    public function getAllRendelesByRaktar(int $raktarID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("rendeles")
            ->from(Rendeles::class, "rendeles")
            ->where("rendeles.raktar_ID =: raktarIDID")
            ->setParameter("raktarID", $raktarID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllRendelesByRaktar(int $raktarID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Rendeles::class, "rendeles")
            ->where("rendeles.raktar_ID =: raktarIDID")
            ->setParameter("raktarID", $raktarID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneRendelesById(int $id):Rendeles{
        return $this->getRepo()->find($id);
    }
    public function addRendeles(Rendeles $rendeles):void{
        $this->em->persist($rendeles);
        $this->em->flush();
    }
    public function removeRendeles(int $id):void{
        $this->em->remove($this->getOneRendelesById($id));
        $this->em->flush();
    }

}