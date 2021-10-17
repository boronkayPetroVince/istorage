<?php


namespace App\Service;


use App\Entity\Szallitasi_cim;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class Szallitasi_cimService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Szallitasi_cim::class);
    }
    public function getAllSzallitasiCim():iterable{
        return $this->getRepo()->findAll();
    }
    public function getAllSzallitasiCimByTelepules(int $telepulesID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("szallitasi_cim")
            ->from(Szallitasi_cim::class, "szallitasi_cim")
            ->where("szallitasi_cim.telepules_ID =: telepulesID")
            ->setParameter("telepulesID", $telepulesID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllSzallitasiCimByTelepules(int $telepulesID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Szallitasi_cim::class, "szallitasi_cim")
            ->where("szallitasi_cim.telepules_ID =: telepulesID")
            ->setParameter("telepulesID", $telepulesID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllSzallitasiCimByUgyfel(int $ugyfelID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("szallitasi_cim")
            ->from(Szallitasi_cim::class, "szallitasi_cim")
            ->where("szallitasi_cim.ugyfel_ID =: ugyfelID")
            ->setParameter("ugyfelID", $ugyfelID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllSzallitasiCimByUgyfel(int $ugyfelID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Szallitasi_cim::class, "szallitasi_cim")
            ->where("szallitasi_cim.ugyfel_ID =: ugyfelID")
            ->setParameter("ugyfelID", $ugyfelID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneSzallitasiCimById(int $id):Szallitasi_cim{
        return $this->getRepo()->find($id);
    }
    public function addSzallitasiCim(Szallitasi_cim $szallitasi_cim):void{
        $this->em->persist($szallitasi_cim);
        $this->em->flush();
    }
    public function removeSzallitasiCim(int $id):void{
        $this->em->remove($this->getOneSzallitasiCimById($id));
        $this->em->flush();
    }


}