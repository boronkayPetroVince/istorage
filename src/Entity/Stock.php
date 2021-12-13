<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Stock
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="stock")
 */
class Stock implements \JsonSerializable
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Warehouse
     * @ORM\JoinColumn(name="warehouseID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Warehouse")
     */
    private $warehouseID;

    /**
     * @var Phone
     * @ORM\JoinColumn(name="phoneID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Phone")
     */
    private $phoneID;

    /**
     * @var Status
     * @ORM\JoinColumn(name="statusID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Status")
     */
    private $statusID;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $purchasePrice;



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Warehouse
     */
    public function getWarehouseID(): Warehouse
    {
        return $this->warehouseID;
    }

    /**
     * @param Warehouse $warehouseID
     */
    public function setWarehouseID(Warehouse $warehouseID): void
    {
        $this->warehouseID = $warehouseID;
    }

    /**
     * @return Phone
     */
    public function getPhoneID(): Phone
    {
        return $this->phoneID;
    }

    /**
     * @param Phone $phoneID
     */
    public function setPhoneID(Phone $phoneID): void
    {
        $this->phoneID = $phoneID;
    }

    /**
     * @return Status
     */
    public function getStatusID(): Status
    {
        return $this->statusID;
    }

    /**
     * @param Status $statusID
     */
    public function setStatusID(Status $statusID): void
    {
        $this->statusID = $statusID;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getPurchasePrice(): int
    {
        return $this->purchasePrice;
    }

    /**
     * @param int $purchasePrice
     */
    public function setPurchasePrice(int $purchasePrice): void
    {
        $this->purchasePrice = $purchasePrice;
    }

    public function jsonSerialize()
    {
        return ["id" => $this->id, "amount" => $this->amount, "purchasePrice" => $this->purchasePrice,"statusID" => $this->statusID,
            "warehouseID" => $this->warehouseID, "phoneID" => $this->phoneID];
    }


}