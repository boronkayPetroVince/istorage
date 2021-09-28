<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Orszag
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="orszag")
 */
class Orszag
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $orszag;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getOrszag(): string
    {
        return $this->orszag;
    }

    /**
     * @param string $orszag
     */
    public function setOrszag(string $orszag): void
    {
        $this->orszag = $orszag;
    }


}