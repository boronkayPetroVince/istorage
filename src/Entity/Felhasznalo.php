<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Class Felhasznalo
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="felhasznalo")
 * @method string getUserIdentifier()
 */
class Felhasznalo implements UserInterface, JsonSerializable
{

    public function jsonSerialize()
    {
        return ["id" => $this->id,"username" => $this->username,"telNev" =>$this->telNev, "telSzam" => $this->telefonszam, "email" => $this->email , "role"=>$this->roles[0]];
    }

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $username = "";

    /**
     * @var string
     * @ORM\Column(type="string", length=1024, nullable=false)
     */
    private $password = "";

    /**
     * @var string
     * @ORM\Column(type="string", length=1000, nullable=false)
     */
    private $telNev = "";

    /**
     * @var string
     * @ORM\Column(type="string", length=40, nullable=false)
     */
    private $email = "";

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $telefonszam = 0;

    /**
     * @var string[]
     * @ORM\Column(type="json")
     */
    private $roles = array();

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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getTelNev(): string
    {
        return $this->telNev;
    }

    /**
     * @param string $telNev
     */
    public function setTelNev(string $telNev): void
    {
        $this->telNev = $telNev;
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

    /**
     * @return int
     */
    public function getTelefonszam(): int
    {
        return $this->telefonszam;
    }

    /**
     * @param int $telefonszam
     */
    public function setTelefonszam(int $telefonszam): void
    {
        $this->telefonszam = $telefonszam;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}