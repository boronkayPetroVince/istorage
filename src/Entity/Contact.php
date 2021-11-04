<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="contact")
 */
class Contact
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Client
     * @ORM\JoinColumn(name="client_ID", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Client")
     */
    private $client_ID;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $fullName;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $phoneNumber;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Client
     */
    public function getClientID(): Client
    {
        return $this->client_ID;
    }

    /**
     * @param Client $client_ID
     */
    public function setClientID(Client $client_ID): void
    {
        $this->client_ID = $client_ID;
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @param string|null $fullName
     */
    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return int
     */
    public function getPhoneNumber(): int
    {
        return $this->phoneNumber;
    }

    /**
     * @param int $phoneNumber
     */
    public function setPhoneNumber(int $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }



}