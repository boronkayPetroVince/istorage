<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Color
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="color")
 */
class Color
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
    private $phoneColor;

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
    public function getPhoneColor(): string
    {
        return $this->phoneColor;
    }

    /**
     * @param string $phoneColor
     */
    public function setPhoneColor(string $phoneColor): void
    {
        $this->phoneColor = $phoneColor;
    }






}