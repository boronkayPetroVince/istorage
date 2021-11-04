<?php


namespace App\Service;


use App\Entity\Phone;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class TelefonService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Phone::class);
    }

    public function getAllTelefon():iterable{
        return $this->getRepo()->findAll();
    }

    public function getAllTelefonByModel(int $modelID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("telefon")
            ->from(Phone::class, "telefon")
            ->where("telefon.model_ID =:modelID")
            ->setParameter("modelID", $modelID);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getAllTelefonBySzin(int $szinID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("telefon")
            ->from(Phone::class, "telefon")
            ->where("telefon.szin_ID =:szinID")
            ->setParameter("szinID", $szinID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllTelefonByMarka(int $markaID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("telefon")
            ->from(Phone::class, "telefon")
            ->innerJoin("telefon.model_ID", "model")
            ->where("model.marka_ID =: markaID")
            ->setParameter("markaID", $markaID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllTelefonByMarka(int $markaID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Phone::class, "telefon")
            ->innerJoin("telefon.model_ID", "model")
            ->where("model.marka_ID =: markaID")
            ->setParameter("markaID", $markaID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllTelefonByModel(int $modelID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Phone::class, "telefon")
            ->where("telefon.model_ID =:modelID")
            ->setParameter("modelID", $modelID);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function removeAllTelefonBySzin(int $szinID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Phone::class, "telefon")
            ->where("telefon.szin_ID =:szinID")
            ->setParameter("szinID", $szinID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneTelefonById(int $id):Phone{
        return $this->getRepo()->find($id);
    }
    public function addTelefon(Phone $telefon):void{
        $this->em->persist($telefon);
        $this->em->flush();
    }
    public function removeTelefon(int $id):void{
        $this->em->persist($this->getOneTelefonById($id));
        $this->em->flush();
    }



}