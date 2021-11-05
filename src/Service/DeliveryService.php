<?php


namespace App\Service;


use App\Entity\Delivery_address;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DeliveryService extends CrudService
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
    public function getAllAddressByCity(int $city_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("delivery")
            ->from(Delivery_address::class, "delivery")
            ->where("delivery.city_ID =: city_ID")
            ->setParameter("city_ID", $city_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllAddressByCity(int $city_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Delivery_address::class, "delivery")
            ->where("delivery.city_ID =: city_ID")
            ->setParameter("city_ID", $city_ID);
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


}