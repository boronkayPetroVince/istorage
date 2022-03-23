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

    public function getOneAddressById(int $id):Delivery_address{
        return $this->getRepo()->find($id);
    }
    public function addAddress(Delivery_address $address):void{
        $this->em->persist($address);
        $this->em->flush();
    }

    public function updateAddress(int $id):void{
        $address = $this->getOneAddressById($id);
        $this->em->persist($address);
        $this->em->flush();
    }
}