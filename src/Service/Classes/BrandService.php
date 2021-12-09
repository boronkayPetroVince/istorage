<?php


namespace App\Service\Classes;


use App\Entity\Brand;
use App\Service\Interfaces\BrandServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class BrandService extends CrudService implements BrandServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }
    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Brand::class);
    }

    public function getAllBrand():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneBrandById(int $id):Brand{
        return $this->getRepo()->find($id);
    }

    public function getOneBrandByName(string $name): Brand
    {
        return $this->getRepo()->findOneBy(["brandName" => $name]);
    }

    public function addBrand(Brand $brand):void{
        $this->em->persist($brand);
        $this->em->flush();
    }

    public function updateBrand(int $id): void
    {
        $brand = $this->getOneBrandById($id);
        $this->em->persist($brand);
        $this->em->flush();
    }


    public function removeBrand(int $id):void{
        $this->em->remove($this->getOneBrandById($id));
        $this->em->flush();
    }

}