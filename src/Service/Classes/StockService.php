<?php


namespace App\Service\Classes;


use App\Entity\Stock;
use App\Service\Interfaces\StockServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class StockService extends CrudService implements StockServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Stock::class);
    }
    public function getAllStock():iterable{
        return $this->getRepo()->findAll();
    }
    public function getAllStockByWarehouse(int $warehouse_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("stock")
            ->from(Stock::class, "stock")
            ->where("stock.warehouse_ID =: warehouse_ID")
            ->setParameter("warehouse_ID", $warehouse_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllStockByWarehouse(int $warehouse_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Stock::class, "stock")
            ->where("stock.warehouse_ID =: warehouse_ID")
            ->setParameter("warehouse_ID", $warehouse_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllStockByPhone(int $phone_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("stock")
            ->from(Stock::class, "stock")
            ->where("stock.phoneID = :phone_ID")
            ->setParameter("phone_ID", $phone_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllStockByPhone(int $phone_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Stock::class, "stock")
            ->where("stock.phone_ID =: phone_ID")
            ->setParameter("phone_ID", $phone_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllPhoneByStatus(int $status_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("stock")
            ->from(Stock::class, "stock")
            ->where("stock.statusID = :statusID")
            ->setParameter("statusID", $status_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneStockById(int $id):Stock{
        return $this->getRepo()->find($id);
    }
    public function addStock(Stock $stock):void{
        $this->em->persist($stock);
        $this->em->flush();
    }
    public function updateStock(int $id):void{
        $stock = $this->getOneStockById($id);
        $this->em->persist($stock);
        $this->em->flush();
    }
    public function removeStock(int $id):void{
        $this->em->remove($this->getOneStockById($id));
        $this->em->flush();
    }

    public function getAllStockByStatus(string $status): Stock
    {
        // TODO: Implement getAllStockByStatus() method.
    }


}