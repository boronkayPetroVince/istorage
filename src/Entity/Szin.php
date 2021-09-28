<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Szin
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="szin")
 */
class Szin
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
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $szin;

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
    public function getSzin(): string
    {
        return $this->szin;
    }

    /**
     * @param string $szin
     */
    public function setSzin(string $szin): void
    {
        $this->szin = $szin;
    }


}