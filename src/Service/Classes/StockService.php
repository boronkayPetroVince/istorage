<?php


namespace App\Service\Classes;


use App\Entity\Phone;
use App\Entity\Stock;
use App\Service\Interfaces\StockServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

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
            ->where("stock.warehouse_ID = :warehouse_ID")
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

    public function getAllBrandByStatus(int $status_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("stock")
            ->from(Stock::class, "stock")
            ->where("stock.statusID = :statusID")
            ->setParameter("statusID", $status_ID)
            ->innerJoin("stock.phoneID", "phone", Join::WITH, $qb->expr()->eq('phone.id', 'stock.phoneID'))
            ->groupBy("phone.brandID");
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllModelByStatusAndBrand(int $status_ID, int $brand_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("stock")
            ->from(Stock::class, "stock")
            ->where("stock.statusID = :statusID")
            ->setParameter("statusID", $status_ID)
            ->innerJoin("stock.phoneID", "phone", Join::WITH, $qb->expr()->eq('phone.id', 'stock.phoneID'))
            ->andWhere("phone.brandID = :brand_ID")
            ->setParameter("brand_ID", $brand_ID)
            ->groupBy("phone.modelID");
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getAllColorByStatusAndModel(int $status_ID, int $model_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("stock")
            ->from(Stock::class, "stock")
            ->where("stock.statusID = :statusID")
            ->setParameter("statusID", $status_ID)
            ->innerJoin("stock.phoneID", "phone", Join::WITH, $qb->expr()->eq('phone.id', 'stock.phoneID'))
            ->andWhere("phone.modelID = :modelID")
            ->setParameter("modelID", $model_ID)
            ->groupBy("phone.colorID");
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getAllCapacityByStatusAndColor(int $status_ID, int $color_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("stock")
            ->from(Stock::class, "stock")
            ->where("stock.statusID = :statusID")
            ->setParameter("statusID", $status_ID)
            ->innerJoin("stock.phoneID", "phone", Join::WITH, $qb->expr()->eq('phone.id', 'stock.phoneID'))
            ->andWhere("phone.colorID = :colorID")
            ->setParameter("colorID", $color_ID)
            ->groupBy("phone.capacityID");
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