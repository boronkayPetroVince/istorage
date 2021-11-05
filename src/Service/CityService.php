<?php


namespace App\Service;


use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CityService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(City::class);
    }
    public function getAllCity():iterable{

    }
    public function getAllCityByCountry(int $country_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("city")
            ->from(City::class, "city")
            ->where("city.country_ID =: country_ID")
            ->setParameter("country_ID", $country_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllCityByCountry(int $country_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(City::class, "city")
            ->where("city.country_ID =: country_ID")
            ->setParameter("country_ID", $country_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneCityById(int $id): City{
        return $this->getRepo()->find($id);
    }
    public function addCity(City $city):void{
        $this->em->persist($city);
        $this->em->flush();
    }
    public function removeCity(int $id):void{
        $this->em->remove($this->getOneCityById($id));
        $this->em->flush();
    }


}