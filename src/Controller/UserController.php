<?php


namespace App\Controller;


use App\Entity\User;
use App\Model\Interfaces\UserModelInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
     * @Route(name="addUser", path="/addUser")
     */
    public function addUser(Request $request):Response{
        if($this->isGranted("ROLE_ADMIN")){
            if ($request->isMethod("POST")){
                if($this->userModel->addUser($request) === true){
                    return $this->render("user/users.html.twig", ["users" => $this->security->getAllUser(),"user" => $this->getUser(),
                        "result.message"=> "Sikeres módosítás!", "color" => "alert-success"]);
                }else return $this->render("user/users.html.twig", ["users" => $this->security->getAllUser(), "user" => $this->getUser(),
                    "resultMessage"=> "Sikertelen módosítás!", "resultColor" => "alert-warning"]);
            }else return $this->render("user/users.html.twig", ["users" => $this->security->getAllUser(), "user" => $this->getUser(),
                "resultMessage"=> "Rosszul érkeztek be az adatok!", "resultColor" => "alert-danger"]);
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
                return $this->render("index.html.twig", ["user" => $this->getUser()]);
            }else return $this->render("user/login.html.twig", ["username" => "Rossz felhasználónév, vagy jelszó!", "user" => $this->getUser()]);
        }else return $this->render("user/login.html.twig", ["username" => "", "user" => $this->getUser()]);
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
     * @param int $userId
     * @return Response
     * @Route(name="updateUser", path="/updateUser/{userId}")
     */
    public function updateUser(Request $request, int $userId): Response{
        if ($request->isMethod("POST")) {
            if ($this->isGranted("ROLE_ADMIN")) {
                if($this->userModel->updateUser($request, $userId) === true){
                    //Egy másik oldallal tér vissza, HA sikertelen! Amin csak egy alert szerepel!
                    return $this->render("user/users.html.twig", ["users" => $this->security->getAllUser(),"user" => $this->getUser(),
                        "resultMessage"=> "Sikeres módosítás!", "resultColor" => "alert-success"]);
                }else return $this->render("user/updateFailed.html.twig", ["user" => $this->security->getOneUserById($userId),
                    "resultMessage"=> "Sikertelen adatmódosítás!", "resultColor" => "alert-danger"]);
            }else return new Response("Hozzáférés megtagadva");
        }else return $this->redirect($this->allUsers());
    }

    /**
     * @return Response
     * @Route(name="users", path="/users")
     */
    public function allUsers():Response{
        return $this->render("user/users.html.twig", ["users" => $this->security->getAllUser(),"user" => $this->getUser(),
            "resultMessage"=> "kurvinyóóó", "resultColor" => "alert-success"]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="passChange", path="/passChange")
     */
    public function changePass(Request $request): Response{
        if($request->isMethod("POST")){
            if($this->isGranted("ROLE_ADMIN")){
                $user = $this->getUser();
                if($this->userModel->changePass($request, $user) === true){
                    return new Response("SIKERES modosítás");
                }else return new Response("sikertelen modosítás");
            }else return new Response("HOZZÁFÉRÉS MEGTAGADVA");
        }
        return $this->render("User/UserPassChange.html.twig", ["user" => $this->getUser()]);
    }



}