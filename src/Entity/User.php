<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Class User
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @method string getUserIdentifier()
 */
class User implements UserInterface, JsonSerializable
{
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
    private $fullName = "";

    /**
     * @var string
     * @ORM\Column(type="string", length=40, nullable=false)
     */
    private $email = "";

    /**
     * @var string
     * @ORM\Column(type="string", length=30 ,nullable=false)
     */
    private $phoneNumber = "";

    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $userNumber;

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
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
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
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getUserNumber(): string
    {
        return $this->userNumber;
    }

    /**
     * @param string $userNumber
     */
    public function setUserNumber(string $userNumber): void
    {
        $this->userNumber = $userNumber;
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

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "fullName" =>$this->fullName,
            "phoneNumber" => $this->phoneNumber,
            "email" => $this->email ,
            "userNumver" => $this->userNumber,
            "role"=>$this->roles[0]];
    }
}