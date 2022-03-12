<?php


namespace App\Service\Classes;


use App\Entity\Vat;
use App\Service\Interfaces\VatServiceInterface;
use Doctrine\ORM\EntityRepository;

class VatService extends CrudService implements VatServiceInterface
{
    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Vat::class);
    }

    public function getAllVat(): iterable
    {
        return $this->getRepo()->findAll();
    }

    public function getOneVatById(int $id): iterable
    {
        return $this->getRepo()->find($id);
    }

}