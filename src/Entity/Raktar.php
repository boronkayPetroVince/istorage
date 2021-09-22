<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Raktar
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="raktar")
 */
class Raktar
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
    private $helyszin;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kapacitas;

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
    public function getHelyszin(): string
    {
        return $this->helyszin;
    }

    /**
     * @param string $helyszin
     */
    public function setHelyszin(string $helyszin): void
    {
        $this->helyszin = $helyszin;
    }

    /**
     * @return int
     */
    public function getKapacitas(): int
    {
        return $this->kapacitas;
    }

    /**
     * @param int $kapacitas
     */
    public function setKapacitas(int $kapacitas): void
    {
        $this->kapacitas = $kapacitas;
    }


}