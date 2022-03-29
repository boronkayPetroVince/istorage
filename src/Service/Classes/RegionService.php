<?php


namespace App\Service\Classes;


use App\Entity\Region;
use App\Service\Interfaces\RegionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class RegionService extends CrudService implements RegionServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo() : EntityRepository{
 // TODO: Implement getRepo() method.
}
    public function getAllRegion():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneRegionByName(string $name):Region{
        return $this->getRepo()->findOneBy(["region_name" => $name]);
    }
    public function getAllRegionByCountry(int $country_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("region")
            ->from(Region::class, "region")
            ->where("region.country_ID =: country_ID")
            ->setParameter("country_ID", $country_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneRegionById(int $id):Region{
        return $this->getRepo()->find($id);
    }
}