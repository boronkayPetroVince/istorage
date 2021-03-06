<?php


namespace App\Service\Classes;


use App\Entity\Phone;
use App\Service\Interfaces\PhoneServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PhoneService extends CrudService implements PhoneServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Phone::class);
    }

    public function getAllPhone():iterable{
        return $this->getRepo()->findAll();
    }

    public function getAllFilteredPhone(int $brand_ID,int $model_ID, int $color_ID, int $capacity_ID): iterable
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select("phone")
            ->from(Phone::class, "phone")
            ->where("phone.brandID = :brandID")->setParameter("brandID", $brand_ID)
            ->andWhere("phone.modelID = :modelID")->setParameter("modelID", $model_ID)
            ->andWhere("phone.colorID = :colorID")->setParameter("colorID", $color_ID)
            ->andWhere("phone.capacityID = :capacityID")->setParameter("capacityID", $capacity_ID);
        $query = $qb->getQuery();
        return $query->getResult();

    }

    public function getAllPhoneByBrand(int $brand_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("phone")
            ->from(Phone::class, "phone")
            ->where("phone.brandID = :brandID")
            ->setParameter("brandID", $brand_ID)
            ->groupBy("phone.modelID");
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getAllPhoneByModel(int $model_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("phone")
            ->from(Phone::class, "phone")
            ->where("phone.modelID = :model_ID")
            ->setParameter("model_ID", $model_ID)
            ->groupBy("phone.colorID");
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getAllCapacityByModel(int $model_ID, int $color_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("phone")
            ->from(Phone::class, "phone")
            ->where("phone.modelID = :model_ID")->setParameter("model_ID", $model_ID)
            ->andWhere("phone.colorID = :color_ID")->setParameter("color_ID", $color_ID)
            ->groupBy("phone.capacityID");
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getOnePhoneById(int $id):Phone{
        return $this->getRepo()->find($id);
    }
    public function addPhone(Phone $phone):void{
        $this->em->persist($phone);
        $this->em->flush();
    }
}