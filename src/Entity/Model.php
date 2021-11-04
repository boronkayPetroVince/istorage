<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Model
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="model")
 */
class Model
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Brand
     * @ORM\JoinColumn(name="brand_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Brand")
     */
    private $brand_ID;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $modelName;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Brand
     */
    public function getBrandID(): Brand
    {
        return $this->brand_ID;
    }

    /**
     * @param Brand $brand_ID
     */
    public function setBrandID(Brand $brand_ID): void
    {
        $this->brand_ID = $brand_ID;
    }

    /**
     * @return string
     */
    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * @param string $modelName
     */
    public function setModelName(string $modelName): void
    {
        $this->modelName = $modelName;
    }




}