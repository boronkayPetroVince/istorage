<?php


namespace App\Controller;


use App\Entity\User;
use App\Model\Interfaces\UserModelInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\b;


class UserController extends AbstractController
{
    /** @var UserModelInterface */
    private $userModel;
    /** @var SecurityServiceInterface */
    private $security;

    /**
     * UserController constructor.
     * @param SecurityServiceInterface $security
     */
    public function __construct(SecurityServiceInterface $security, UserModelInterface $userModel)
    {
        $this->security = $security;
        $this->userModel = $userModel;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="register", path="/register")
     */
    public function registerAction(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if($this->isGranted("ROLE_ADMIN")){
            if ($request->isMethod("POST")){
                if($this->userModel->addUser($request) === true){
                    return $this->render("user/register.html.twig", ["content" => "Sikeres regisztráció"]);
                }else return $this->render("user/register.html.twig", ["content"=>"Felhasználónév foglalt!"]);
            }else return $this->render("user/register.html.twig", ["content"=>""]);
        }else return new Response("Hozzáférés megtagadva!");

    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="app_login", path="/login")
     */
    public function loginAction(Request $request): Response{
        /** @var User $user */
        $user = $this->getUser();
        if ($request->isMethod("POST")){
            if ($this->userModel->loginAction($request,$user) == true){
                //return $this->render("user/login.html.twig",["username"=>"Sikeresen bejelentkeztél: ".$user->getUsername()."!"]);
                return $this->render("main.html.twig", ["user" => $this->getUser()]);
            }else return $this->render("user/login.html.twig", ["username" => "Rossz felhasználónév, vagy jelszó!"]);
        }else return $this->render("user/login.html.twig", ["username" => ""]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="app_logout", path="/logout")
     */
    public function logoutAction(Request $request): Response{

    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="update_action", path="/update")
     */
    public function updateAction(Request $request): Response{
        if ($request->isMethod("POST")) {
            if ($this->isGranted("ROLE_ADMIN")) {
                if($this->userModel->updateUser($request) === true){
                    return new Response("Sikeres módosítás!");
                }else return new Response("Sikertelen!");
            }else return new Response("Hozzáférés megtagadva");
        }else return $this->render("user/update.html.twig");

    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allUsersDetails", path="/allUsersDetails")
     */
    public function AllUsersDetails():Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return $this->render("User/allUserDetails.html.twig", ["users" => $this->security->getAllUser()]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="oneUserDetails", path="/oneUserDetails")
     */
    public function oneUserDetails(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isMethod("POST")){
            $user = $this->security->getOneUserById($request->request->get("username"));
            $this->userModel->oneUserDetails($request,$user);
            return new JsonResponse($user);
        }else return $this->render("user/oneUserDetails.html.twig");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="removeUser", path="/removeUser")
     */
    public function removeUser(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isMethod("POST"))
        {
            $user = $this->security->getOneUserById($request->request->get("users"));
            if ($this->userModel->removeUser($request, $user))
            {
                return $this->render("User/remove.html.twig",["result" => "Sikeresen kitörölted a:" . $user->getUsername() . " felhasználót!"]);
            }else return new Response("Sikertelen törlés!");
        }else return $this->render("user/remove.html.twig", ["result" => ""]);
    }

    /**
     * @return Response
     * @Route(name="allUser")
     */
    public function getAllUser():Response{
        $users = $this->security->getAllUser();
        return new JsonResponse($users);
    }
}