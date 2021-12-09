<?php


namespace App\Service\Classes;


use App\Entity\Color;
use App\Service\Interfaces\ColorServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ColorService extends CrudService implements ColorServiceInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(Color::class);
    }

    public function getAllColor():iterable{
        return $this->getRepo()->findAll();
    }
    public function getAllColorByModel(int $model_ID):iterable{
        $qb = $this->em->createQueryBuilder();
        $qb->select("color")
            ->from(Color::class,"color")
            ->where("color.model_ID =: model_ID")
            ->setParameter("model_ID", $model_ID);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    public function getOneColorById(int $id):Color{
        return $this->getRepo()->find($id);
    }

    public function getOneColorByName(string $name): Color
    {
        return $this->getRepo()->findOneBy(["phoneColor" => $name]);
    }

    public function addColor(Color $color):void{
        $this->em->persist($color);
        $this->em->flush();
    }

    public function updateColor(int $id): void
    {
        $color = $this->getOneColorById($id);
        $this->em->persist($color);
        $this->em->flush();
    }

    public function removeColor(int $id):void{
        $this->em->remove($this->getOneColorById($id));
        $this->em->flush();
    }


}