<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Phone
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="phone")
 */
class Phone implements \JsonSerializable
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
     * @ORM\JoinColumn(name="brandID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Brand")
     */
    private $brandID;

    /**
     * @var Model
     * @ORM\JoinColumn(name="modelID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Model")
     */
    private $modelID;

    /**
     * @var Color
     * @ORM\JoinColumn(name="colorID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Color")
     */
    private $colorID;

    /**
     * @var Capacity
     * @ORM\JoinColumn(name="capacityID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Capacity")
     */
    private $capacityID;

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
        return $this->brandID;
    }

    /**
     * @param Brand $brandID
     */
    public function setBrandID(Brand $brandID): void
    {
        $this->brandID = $brandID;
    }

    /**
     * @return Model
     */
    public function getModelID(): Model
    {
        return $this->modelID;
    }

    /**
     * @param Model $modelID
     */
    public function setModelID(Model $modelID): void
    {
        $this->modelID = $modelID;
    }

    /**
     * @return Color
     */
    public function getColorID(): Color
    {
        return $this->colorID;
    }

    /**
     * @param Color $colorID
     */
    public function setColorID(Color $colorID): void
    {
        $this->colorID = $colorID;
    }

    /**
     * @return Capacity
     */
    public function getCapacityID(): Capacity
    {
        return $this->capacityID;
    }

    /**
     * @param Capacity $capacityID
     */
    public function setCapacityID(Capacity $capacityID): void
    {
        $this->capacityID = $capacityID;
    }


    public function jsonSerialize()
    {
        return ["id" => $this->id,"brandID" => $this->brandID, "modelID" =>$this->modelID,
            "colorID"=>$this->colorID ,"capacityID" => $this->capacityID];
    }
}