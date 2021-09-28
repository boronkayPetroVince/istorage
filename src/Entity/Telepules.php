<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Telepules
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="telepules")
 */
class Telepules
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Orszag
     * @ORM\JoinColumn(name="orszag_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Orszag")
     */
    private $orszag_ID;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $iranyitoszam;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $telepules;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return Orszag
     */
    public function getOrszagID(): Orszag
    {
        return $this->orszag_ID;
    }

    /**
     * @param Orszag $orszag_ID
     */
    public function setOrszagID(Orszag $orszag_ID): void
    {
        $this->orszag_ID = $orszag_ID;
    }

    /**
     * @return int
     */
    public function getIranyitoszam(): int
    {
        return $this->iranyitoszam;
    }

    /**
     * @param int $iranyitoszam
     */
    public function setIranyitoszam(int $iranyitoszam): void
    {
        $this->iranyitoszam = $iranyitoszam;
    }

    /**
     * @return string
     */
    public function getTelepules(): string
    {
        return $this->telepules;
    }

    /**
     * @param string $telepules
     */
    public function setTelepules(string $telepules): void
    {
        $this->telepules = $telepules;
    }


}