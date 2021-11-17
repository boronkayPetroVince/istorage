<?php


namespace App\Service;


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

    public function getAllPhoneByModel(int $model_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("phone")
            ->from(Phone::class, "phone")
            ->where("phone.model_ID =:model_ID")
            ->setParameter("model_ID", $model_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getAllPhoneByColor(int $color_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("phone")
            ->from(Phone::class, "phone")
            ->where("phone.color_ID =:color_ID")
            ->setParameter("color_ID", $color_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getAllPhoneByBrand(int $brand_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("phone")
            ->from(Phone::class, "phone")
            ->innerJoin("phone.model_ID", "model")
            ->where("model.brand_ID =: brand_ID")
            ->setParameter("brand_ID", $brand_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllPhoneByBrand(int $brand_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Phone::class, "phone")
            ->innerJoin("phone.model_ID", "model")
            ->where("model.brand_ID =: brand_ID")
            ->setParameter("brand_ID", $brand_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllPhoneByModel(int $model_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Phone::class, "phone")
            ->where("phone.model_ID =:model_ID")
            ->setParameter("model_ID", $model_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function removeAllPhoneByColor(int $color_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Phone::class, "phone")
            ->where("phone.color_ID =:color_ID")
            ->setParameter("color_ID", $color_ID);
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
    public function removePhone(int $id):void{
        $this->em->persist($this->getOnePhoneById($id));
        $this->em->flush();
    }



}