<?php


namespace App\Service\Classes;


use App\Entity\Status;
use App\Service\Interfaces\StatusServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class StatusService extends CrudService implements StatusServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }
    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Status::class);
    }

    public function getAllStatus(): iterable
    {
        return $this->getRepo()->findAll();
    }

    public function getOneStatusById(int $id): Status
    {
        return $this->getRepo()->find($id);
    }

}