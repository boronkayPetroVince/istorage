<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Marka
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="marka")
 */
class Marka
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
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $marka;

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
    public function getMarka(): string
    {
        return $this->marka;
    }

    /**
     * @param string $marka
     */
    public function setMarka(string $marka): void
    {
        $this->marka = $marka;
    }


}