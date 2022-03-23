<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Warehouse
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="warehouse")
 */
class Warehouse implements \JsonSerializable
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
    private $whname;

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
     * @var string
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $vatNumber;

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
        return $this->whname;
    }

    /**
     * @param string $whName
     */
    public function setWhName(string $whName): void
    {
        $this->whname = $whName;
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

    /**
     * @return string
     */
    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    /**
     * @param string $vatNumber
     */
    public function setVatNumber(string $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "whname" => $this->whname,
            "location" => $this->location,
            "capacity" => $this->capacity,
            "vatNumber" =>$this->vatNumber
        ];
    }
}