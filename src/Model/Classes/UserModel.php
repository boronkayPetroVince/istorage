<?php


namespace App\Model\Classes;


use App\Entity\User;
use App\Model\Interfaces\UserModelInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserModel implements UserModelInterface
{
    /** @var SecurityServiceInterface */
    private $securityService;

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /**
     * UserModel constructor.
     * @param SecurityServiceInterface $securityService
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(SecurityServiceInterface $securityService, UserPasswordEncoderInterface $encoder)
    {
        $this->securityService = $securityService;
        $this->encoder = $encoder;
    }


    public function addUser(Request $request): bool
    {
        $user = $request->request->get("username");
        $fullName = $request->request->get("fullName");
        $phoneNumber = $request->request->get("phoneNumber");
        $email = $request->request->get("emailad");
        $role = $request->request->get("roles");
        if ($request->request->get("password") === $request->request->get("password2")){
           if ($this->checkUser($user) === false){
                $this->securityService->addUser($user,$request->request->get("password2"), $fullName, $email, $phoneNumber, $role);
                //return new JsonResponse(["result"=>true]);
                return true;
           }else return false;
        }else return false;
    }

    public function loginAction(Request $request, User $user): bool
    {
        if($user){
            return true;
        }else return false;
    }

    public function updateUser(Request $request): bool
    {
        $user = $this->securityService->getOneUserById($request->request->get("users"));
        if ($this->checkUser($request->request->get("username")) === false){
            $user->setFullName($request->request->get("fullName"));
            $user->setUsername($request->request->get("username"));
            $user->setEmail($request->request->get("email"));
            $user->setPhoneNumber((int)$request->request->get("phoneNumber"));
            $this->securityService->updateUser($user->getId());
            return true;
        }else return false;
    }

    public function changePass(Request $request, User $user): bool
    {
        if($request){
            $password = $request->request->get("old");
            if($this->securityService->checkPassword($user->getUsername(),$password) === true){
                $user->setPassword($this->encoder->encodePassword($user,$request->request->get("new")));
                $this->securityService->updateUser($user->getId());
                return true;
            }
            return false;
        }
        return false;
    }


    public function AllUserDetails(): Response
    {
        // TODO: Implement getAllUserDetails() method.
    }

    public function oneUserDetails(Request $request, User $user): User
    {
        //if($user){
            $user->getFullName($request->request->get("fullName"));
            $user->getEmail($request->request->get("email"));
            $user->getPhoneNumber($request->request->get("phoneNumber"));
            return $user;
        //}else return $user=null;

    }

    public function removeUser(Request $request): bool
    {
        if($request){
            $user = $this->securityService->getOneUserById($request->request->get("users"));
            $this->securityService->removeUser($user->getId());
            return true;
        }else return false;
    }

    public function getAllUser(): Response
    {
        // TODO: Implement getAllUser() method.
    }

    public function checkUser(string $username): bool
    {
        /** @var User[] $arr */
        $arr = $this->securityService->getAllUser();
        foreach($arr as $user){
            if ($user->getUsername() === $username) return true;
        }
        return false;
    }

}