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
     * @var string
     * @ORM\Column(type="string", length=30, nullable=false)
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
        return ["id" => $this->id, "amount" => $this->amount, "purchasePrice" => $this->purchasePrice,"status" => $this->status,
            "warehouseID" => $this->warehouseID, "phoneID" => $this->phoneID];
    }


}