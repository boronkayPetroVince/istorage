<?php


namespace App\Service\Classes;

use App\Entity\Settlement;
use App\Service\Interfaces\SettlementServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class SettlementService extends CrudService implements SettlementServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Settlement::class);
    }
    public function getAllSettlement():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneSettlementByPostalcode(int $postalcode): Settlement{
        return $this->getRepo()->findOneBy(["postalCode" =>$postalcode]);
    }
    public function getAllSettlementByRegion(int $region_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("settlement")
            ->from(Settlement::class, "settlement")
            ->where("settlement.region_ID =: region_ID")
            ->setParameter("region_ID", $region_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneSettlementById(int $id): Settlement{
        return $this->getRepo()->find($id);
    }
}