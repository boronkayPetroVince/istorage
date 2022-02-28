<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Client
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="client")
 */
class Client implements \JsonSerializable
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
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $clientName;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false, length=30)
     */
    private $vatNumber;

    /**
     * @var Contact
     * @ORM\JoinColumn(name="contact_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Contact")
     */
    private $contact_ID;

    /**
     * @var Delivery_address
     * @ORM\JoinColumn(name="delivery_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Delivery_address")
     */
    private $delivery_ID;

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
    public function getClientName(): string
    {
        return $this->clientName;
    }

    /**
     * @param string $clientName
     */
    public function setClientName(string $clientName): void
    {
        $this->clientName = $clientName;
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

    /**
     * @return Contact
     */
    public function getContactID(): Contact
    {
        return $this->contact_ID;
    }

    /**
     * @param Contact $contact_ID
     */
    public function setContactID(Contact $contact_ID): void
    {
        $this->contact_ID = $contact_ID;
    }

    /**
     * @return Delivery_address
     */
    public function getDeliveryID(): Delivery_address
    {
        return $this->delivery_ID;
    }

    /**
     * @param Delivery_address $delivery_ID
     */
    public function setDeliveryID(Delivery_address $delivery_ID): void
    {
        $this->delivery_ID = $delivery_ID;
    }

    public function jsonSerialize()
    {
        return ["id"=>$this->id,"clientName" => $this->clientName, "vatNumber" => $this->vatNumber, "contactID" => $this->contact_ID, "deliveryID" => $this->delivery_ID];
    }


}