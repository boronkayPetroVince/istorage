<?php


namespace App\Service\Classes;


use App\Entity\User;
use App\Service\Interfaces\SecurityServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityService extends CrudService implements SecurityServiceInterface
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct($em);
        $this->encoder = $encoder;
    }

    public function getRepo(): EntityRepository
    {
        return $this->em->getRepository(User::class);
    }

    public function getAllUser():iterable{
        return $this->getRepo()->findAll();
    }
    public function getOneUserById(int $id):User{
        return $this->getRepo()->find($id);
    }
    public function addUser(string $username, string $password, string $fullName, string $email, string $phoneNumber, string $role):void{
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $user->setFullName($fullName);
        $user->setEmail($email);
        $user->setPhoneNumber($phoneNumber);
        $user->setRoles([$role]);
        $this->em->persist($user);
        $this->em->flush();
    }
    public function updateUser(int $id):void{
        $user = $this->getOneUserById($id);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function checkPassword(string $username, string $password):bool{
        $user = $this->em->getRepository(User::class)->findOneBy(["username"=>$username]);
        if (!$user) return false;
        return $this->encoder->isPasswordValid($user, $password);
    }


}