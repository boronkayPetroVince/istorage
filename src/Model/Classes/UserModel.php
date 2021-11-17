<?php


namespace App\Model\Classes;


use App\Entity\User;
use App\Model\Interfaces\UserModelInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserModel implements UserModelInterface
{
    /** @var SecurityServiceInterface */
    private $securityService;

    /**
     * UserModel constructor.
     * @param SecurityServiceInterface $securityService
     */
    public function __construct(SecurityServiceInterface $securityService)
    {
        $this->securityService = $securityService;
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

    public function getAllUserDetails(): Response
    {
        // TODO: Implement getAllUserDetails() method.
    }

    public function oneUserDetails(Request $request): Response
    {
        // TODO: Implement oneUserDetails() method.
    }

    public function removeUser(Request $request): Response
    {
        // TODO: Implement removeUser() method.
    }

    public function getAllUser(): Response
    {
        // TODO: Implement getAllUser() method.
    }

    public function getOneUser(Request $request): Response
    {
        // TODO: Implement getOneUser() method.
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