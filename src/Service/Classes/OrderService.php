<?php


namespace App\Service\Classes;


use App\Entity\Order;
use App\Service\Interfaces\OrderServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class OrderService extends CrudService implements OrderServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Order::class);
    }
    public function getAllOrder():iterable{
        return $this->getRepo()->findAll();
    }

    public function getAllOrderByWarehouse(int $warehouse_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("order")
            ->from(Order::class, "order")
            ->where("order.warehouse_ID =: warehouse_ID")
            ->setParameter("warehouse_ID", $warehouse_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneOrderById(int $id):Order{
        return $this->getRepo()->find($id);
    }
    public function addOrder(Order $order):void{
        $this->em->persist($order);
        $this->em->flush();
    }
    public function removeOrder(int $id):void{
        $this->em->remove($this->getOneOrderById($id));
        $this->em->flush();
    }
    public function currentMonthIncomings():int{
        /** @var Order[] $list */
        $list = $this->getAllOrder();
        $date = new \DateTime('now');
        $sum = 0;
        foreach($list as $data){
            if($data->getDate()->format('m') == $date->format('m')){
                $sum += $data->getPrice() * $data->getAmount();
            }
        }
        return $sum;
    }
    public function allIncomingsPerMonth(string $month):int{
        /** @var Order[] $list */
        $list = $this->getAllOrder();
        $sum = 0;
        foreach($list as $data){
            if($data->getDate()->format("F") == $month){
                $sum += $data->getPrice() * $data->getAmount();
            }
        }
        return $sum;
    }

    public function allOrderPerWeek():iterable{
        /** @var Order[] $orders */
        $orders = $this->getAllOrder();
        /** @var Order[] $tempList */
        $tempList = [];
        $date = new \DateTime();
        foreach($orders as $order){
            if($order->getDate()->format("W") == $date->format("W")){
                array_push($tempList,$order);
            }
        }
        return $tempList;
    }

    public function lastSell():iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("ordered")
            ->from(Order::class, "ordered")
            ->where("ordered.id = :id")
            ->setParameter("id", "1");
        $query = $qb->getQuery();
        return $query->getResult();
    }

}