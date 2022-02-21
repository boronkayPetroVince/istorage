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
        $user = $request->request->get("newUsername");
        $fullName = $request->request->get("newFullname");
        $email = $request->request->get("newEmail");
        $phoneNumber = $request->request->get("newPhoneNumber");
        $role = $request->request->get("newRole");
        if ($request->request->get("newPassword") === $request->request->get("newPasswordAgain")){
            $this->securityService->addUser($user,$request->request->get("newPasswordAgain"), $fullName, $email, $phoneNumber, $role);
            return true;
        }else return false;
    }

    public function loginAction(Request $request, User $user): bool
    {
        if($user){
            return true;
        }else return false;
    }

    public function updateUser(Request $request, int $userId): bool
    {
        $user = $this->securityService->getOneUserById($userId);
        if ($request){
            $user->setFullName($request->request->get("fullName"));
            $user->setUsername($request->request->get("username"));
            $user->setEmail($request->request->get("email"));
            $user->setPhoneNumber((int)$request->request->get("phoneNumber"));
            $user->setRoles([$request->request->get("role")]);
            $this->securityService->updateUser($user->getId());
            return true;
        }else return false;
    }

    public function updateLoggedUser(Request $request, User $user): bool{
        if($request->isMethod("POST")){
            $user->setFullName($request->request->get("fullName"));
            $user->setUsername($request->request->get("username"));
            $user->setEmail($request->request->get("email"));
            $user->setPhoneNumber((int)$request->request->get("phoneNumber"));
            $this->securityService->updateUser($user->getId());
            return true;
        }
        return false;
    }

    public function changePass(Request $request, User $user): bool
    {
        if($request->isMethod("POST")){
            $password = $request->request->get("oldPass");
            if($this->securityService->checkPassword($user->getUsername(),$password) === true){
                if ($request->request->get("newPass1") === $request->request->get("newPass2")){
                    $user->setPassword($this->encoder->encodePassword($user, $request->request->get("newPass1")));
                    $this->securityService->updateUser($user->getId());
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
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