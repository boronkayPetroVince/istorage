<?php


namespace App\Service\Classes;


use App\Entity\Capacity;
use App\Service\Interfaces\CapacityServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CapacityService extends CrudService implements CapacityServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Capacity::class);
    }

    public function getAllCapacity(): iterable
    {
        return $this->getRepo()->findAll();
    }

    public function getOneCapacityById(int $id): Capacity
    {
        return $this->getRepo()->find($id);
    }
    public function getOneCapacityByMemory(int $memory): Capacity{
        return $this->getRepo()->findOneBy(["capacity" => $memory]);
    }

    public function getAllCapacityByColor(int $color_ID): iterable
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select("capacity")
            ->from(Capacity::class, "capacity")
            ->where("capacity.color_ID =: color_ID")
            ->setParameter("color_ID", $color_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function addCapacity(Capacity $capacity): void
    {
        $this->em->persist($capacity);
        $this->em->flush();
    }

    public function updateCapacity(int $id): void
    {
        $capacity = $this->getOneCapacityById($id);
        $this->em->persist($capacity);
        $this->em->flush();
    }


    public function removeCapacity(int $id): void
    {
        $this->em->remove($this->getOneCapacityById($id));
        $this->em->flush();
    }

}