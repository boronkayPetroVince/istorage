<?php


namespace App\Service\Classes;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class CrudService
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * CrudService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return EntityRepository
     */
    public abstract function getRepo() : EntityRepository;
}