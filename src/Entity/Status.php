<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Status
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="status")
 */
class Status implements \JsonSerializable
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
    private $status;

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
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function jsonSerialize()
    {
        return ["id" => $this->id, "status" => $this->status];
    }
}