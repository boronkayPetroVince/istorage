<?php


namespace App\Service\Classes;


use App\Entity\Delivery_address;
use App\Service\Interfaces\DeliveryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DeliveryService extends CrudService implements DeliveryServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Delivery_address::class);
    }
    public function getAllDelivery():iterable{
        return $this->getRepo()->findAll();
    }
    public function getAllAddressBySettlement(int $settlement_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("delivery")
            ->from(Delivery_address::class, "delivery")
            ->where("delivery.settlement_ID =: settlement_ID")
            ->setParameter("settlement_ID", $settlement_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllAddressBySettlement(int $settlement_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Delivery_address::class, "delivery")
            ->where("delivery.settlement_ID =: settlement_ID")
            ->setParameter("settlement_ID", $settlement_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllAddressByClient(int $client_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("delivery")
            ->from(Delivery_address::class, "delivery")
            ->where("delivery.client_ID =: client_ID")
            ->setParameter("client_ID", $client_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllAddressByClient(int $client_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Delivery_address::class, "delivery")
            ->where("delivery.client_ID =: client_ID")
            ->setParameter("client_ID", $client_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneAddressById(int $id):Delivery_address{
        return $this->getRepo()->find($id);
    }
    public function addAddress(Delivery_address $address):void{
        $this->em->persist($address);
        $this->em->flush();
    }
    public function removeAddress(int $id):void{
        $this->em->remove($this->getOneAddressById($id));
        $this->em->flush();
    }
    public function updateAddress(int $id):void{
        $address = $this->getOneAddressById($id);
        $this->em->persist($address);
        $this->em->flush();
    }



}