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
        if($this->checkUser($request->request->get("newUsername"))){
            $user = $request->request->get("newUsername");
            $fullName = $request->request->get("newFullname");
            $email = $request->request->get("newEmail");
            $phoneNumber = "+36".$request->request->get("newPhoneNumber");
            $role = $request->request->get("newRole");
            $userNumber = "111";
            if ($request->request->get("newPassword") === $request->request->get("newPasswordAgain")){
                $this->securityService->addUser($user,$request->request->get("newPasswordAgain"), $fullName, $email, $phoneNumber, $role, $userNumber);
            }else return false;
            return true;
        }return false;
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
            if($this->checkUser($request->request->get("username"))){
                $user->setUsername($request->request->get("username"));
            }
            $user->setFullName($request->request->get("fullName"));
            $user->setEmail($request->request->get("email"));
            $user->setPhoneNumber("+36".$request->request->get("phoneNumber"));
            $user->setRoles(["ROLE_ADMIN"]);
            $this->securityService->updateUser($user->getId());
            return true;
        }else return false;
    }

    public function updateLoggedUser(Request $request, User $user): bool{
        if($request->isMethod("POST")){
            $user->setFullName($request->request->get("fullName"));
            $user->setUsername($request->request->get("username"));
            $user->setEmail($request->request->get("email"));
            $user->setPhoneNumber("+36".$request->request->get("phoneNumber"));
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
            if (strtolower($user->getUsername()) === strtolower($username)) return false;
        }
        return true;
    }

}