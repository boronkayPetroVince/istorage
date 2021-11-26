<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Warehouse
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="warehouse")
 */
class Warehouse
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
    private $wh_name;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $location;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $capacity;

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
    public function getWhName(): string
    {
        return $this->wh_name;
    }

    /**
     * @param string $wh_name
     */
    public function setWhName(string $wh_name): void
    {
        $this->wh_name = $wh_name;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return int
     */
    public function getCapacity(): int
    {
        return $this->capacity;
    }

    /**
     * @param int $capacity
     */
    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }




}