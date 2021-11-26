<?php


namespace App\Service\Classes;



use App\Entity\Warehouse;
use App\Service\Interfaces\WarehouseServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class WarehouseService extends CrudService implements WarehouseServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Warehouse::class);
    }
    public function getAllWarehouse():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneWarehouseById(int $id):Warehouse{
        return $this->getRepo()->find($id);
    }

    public function getOneWarehouseByName(string $name): Warehouse
    {
        return $this->getRepo()->findOneBy(["wh_name" => $name]);
    }

    public function addWarehouse(Warehouse $warehouse):void{
        $this->em->persist($warehouse);
        $this->em->flush();
    }
    public function removeWarehouse(int $id):void{
        $this->em->remove($this->getOneWarehouseById($id));
        $this->em->flush();
    }

}