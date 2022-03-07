<?php


namespace App\Service\Classes;


use App\Entity\Phone;
use App\Entity\Stock;
use App\Entity\Warehouse;
use App\Service\Interfaces\StockServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use function Symfony\Component\String\b;

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

    public function getAllStockByStatus(string $statusName):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("stock")
            ->from(Stock::class, "stock")
            ->innerJoin("stock.statusID", "status", Join::WITH, $qb->expr()->eq('status.id', 'stock.statusID'))
            ->where("status.status = :statusName")
            ->setParameter("statusName", $statusName);
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

    public function stockCount(string $statusName): int
    {
        /** @var Stock[] $list */
        $list = $this->getAllStock();
        $sum = 0;
        foreach($list as $data){
            if($data->getStatusID()->getStatus() == $statusName){
                $sum += $data->getAmount();
            }
        }
        return $sum;
    }

    public function currentMonthOutgoings():int{
        /** @var Stock[] $list */
        $list = $this->getAllStock();
        $month = new \DateTime('now');
        $sum = 0;
        foreach($list as $data){
            if($data->getDate()->format('m') == $month->format('m')){
                if($data->getStatusID()->getStatus() != "Eladva"){
                    $sum += $data->getPurchasePrice();
                }
            }
        }
        return $sum;
    }
    public function currentMonthIncomings():int{
        /** @var Stock[] $list */
        $list = $this->getAllStock();
        $month = new \DateTime('now');
        $sum = 0;
        foreach($list as $data){
            if($data->getDate()->format('m') == $month->format('m')){
                if($data->getStatusID()->getStatus() == "Eladva"){
                    $sum += $data->getPurchasePrice();
                }
            }
        }
        return $sum;
    }

    public function originalWhCapacity(Warehouse $warehouse):int{
        /** @var Stock[] $list */
        $list = $this->getAllStock();
        $sum = 0;
        foreach($list as $data){
            $sum += $data->getAmount();
        }
        $sum += $warehouse->getCapacity();
        return $sum;
    }


}