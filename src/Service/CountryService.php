<?php


namespace App\Entity;


use App\Service\CrudService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CountryService extends CrudService
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
    public function removeCountry(int $id):void{
        $this->em->remove($this->getOneCountryById($id));
        $this->em->flush();
    }


}