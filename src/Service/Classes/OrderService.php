<?php


namespace App\Service\Classes;


use App\Entity\Order;
use App\Service\Interfaces\OrderServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

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
    public function getAllOrderByUser(int $user_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("order")
            ->from(Order::class, "order")
            ->where("order.user_ID =: user_ID")
            ->setParameter("user_ID", $user_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllOrderByUser(int $user_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Order::class, "order")
            ->where("order.felhasz_ID =: user_ID")
            ->setParameter("user_ID", $user_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllOrderByDeliveryAddress(int $delivery_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("order")
            ->from(Order::class, "order")
            ->where("order.deliveryAddress_ID =: delivery_ID")
            ->setParameter("delivery_ID", $delivery_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllOrderByDeliveryAddress(int $delivery_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Order::class, "order")
            ->where("order.deliveryAddress_ID =: delivery_ID")
            ->setParameter("delivery_ID", $delivery_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllOrderByPhone(int $phone_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("order")
            ->from(Order::class, "order")
            ->where("order.phone_ID =: phone_ID")
            ->setParameter("phone_ID", $phone_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllOrderByPhone(int $phone_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Order::class, "order")
            ->where("order.phone_ID =: phone_ID")
            ->setParameter("phone_ID", $phone_ID);
        $query = $qb->getQuery();
        return $query->getResult();

    }
    public function getAllOrderByWarehouser(int $warehouse_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("order")
            ->from(Order::class, "order")
            ->where("order.warehouse_ID =: warehouse_ID")
            ->setParameter("warehouse_ID", $warehouse_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllOrderByWarehouse(int $raktarID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Order::class, "rendeles")
            ->where("rendeles.raktar_ID =: raktarID")
            ->setParameter("raktarID", $raktarID);
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

}