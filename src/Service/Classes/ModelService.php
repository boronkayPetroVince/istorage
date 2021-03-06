<?php


namespace App\Service\Classes;


use App\Entity\Model;
use App\Service\Interfaces\ModelServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ModelService extends CrudService implements ModelServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Model::class);
    }

    public function getAllModel():iterable{
        return $this->getRepo()->findAll();
    }
    public function getAllModelByBrand(int $brand_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("model")
            ->from(Model::class, "model")
            ->where("model.brand_ID =:brand_ID")
            ->setParameter("brand_ID", $brand_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getOneModelById(int $id):Model{
        return $this->getRepo()->find($id);
    }

    public function getOneModelByName(string $name): Model
    {
        return $this->getRepo()->findOneBy(["modelName" =>$name]);
    }

    public function addModel(Model $model):void{
        $this->em->persist($model);
        $this->em->flush();
    }
}