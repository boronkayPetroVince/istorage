<?php


namespace App\Service;


use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ModelService extends CrudService
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
    public function getAllModelByMarka(int $markaID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("model")
            ->from(Model::class, "model")
            ->where("model.marka_ID =:markaID")
            ->setParameter("markaID", $markaID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function removeAllModelByMarka(int $markaID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->delete()
            ->from(Model::class, "model")
            ->where("model.marka_ID =:markaID")
            ->setParameter("markaID", $markaID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneModelById(int $id):Model{
        return $this->getRepo()->find($id);
    }
    public function addModel(Model $model):void{
        $this->em->persist($model);
        $this->em->flush();
    }
    public function removeModel(int $id):void{
        $this->em->remove($this->getOneModelById($id));
        $this->em->flush();
    }


}