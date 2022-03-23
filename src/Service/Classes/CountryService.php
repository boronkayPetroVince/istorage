<?php


namespace App\Service\Classes;


use App\Entity\Country;
use App\Service\Interfaces\CountryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CountryService extends CrudService implements CountryServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Country::class);
    }
    public function getAllCountry():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneCountryById(int $id):Country{
        return $this->getRepo()->find($id);
    }
    public function addCountry(Country $country):void{
        $this->em->persist($country);
        $this->em->flush();
    }
}