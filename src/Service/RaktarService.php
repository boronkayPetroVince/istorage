<?php


namespace App\Service;



use App\Entity\Raktar;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class RaktarService extends CrudService
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Raktar::class);
    }
    public function getAllRaktar():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneRaktarById(int $id):Marka{
        return $this->getRepo()->find($id);
    }
    public function addRaktar(Raktar $raktar):void{
        $this->em->persist($raktar);
        $this->em->flush();
    }
    public function removeRaktar(int $id):void{
        $this->em->remove($this->getOneRaktarById($id));
        $this->em->flush();
    }

}