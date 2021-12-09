<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Capacity
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="capacity")
 */
class Capacity implements \JsonSerializable
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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

    public function jsonSerialize()
    {
        return ["id"=>$this->id, "capacity"=>$this->capacity];
    }


}