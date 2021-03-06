<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Brand
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="brand")
 */
class Brand implements \JsonSerializable
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
    private $brandName;

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
    public function getBrandName(): string
    {
        return $this->brandName;
    }

    /**
     * @param string $brandName
     */
    public function setBrandName(string $brandName): void
    {
        $this->brandName = $brandName;
    }

    public function jsonSerialize()
    {
        return ["id" => $this->id, "brandName" => $this->brandName];
    }






}