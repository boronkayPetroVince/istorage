<?php


namespace App\Service\Classes;


use App\Entity\User;
use App\Service\Interfaces\SecurityServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityService implements SecurityServiceInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /**
     * SecurityService constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }
    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(User::class);
    }

    public function getAllUser():iterable{
        return $this->getRepo()->findAll();;
    }
    public function getOneUserById(int $id):User{
        return $this->getRepo()->find($id);
    }
    public function addUser(string $username, string $password, string $fullName, string $email, int $phoneNumber, string $role, string $number):void{
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $user->setFullName($fullName);
        $user->setEmail($email);
        $user->setPhoneNumber($phoneNumber);
        $user->setRoles([$role]);
        $user->setUserNumber($number);
        $this->em->persist($user);
        $this->em->flush();
    }
    public function updateUser(int $id):void{
        $user = $this->getOneUserById($id);
        $this->em->persist($user);
        $this->em->flush();
    }
    public function getOneUserByName(string $name): User //iittttt ezt kell a frissitéshez
    {
        return $this->getRepo()->findOneBy(["username" => $name]);
    }
    public function removeUser(int $id):void{
        $this->em->remove($this->getOneUserById($id));
        $this->em->flush();
    }
    public function checkPassword(string $username, string $password):bool{
        $user = $this->em->getRepository(User::class)->findOneBy(["username"=>$username]);
        if (!$user) return false;
        return $this->encoder->isPasswordValid($user, $password);
    }


}