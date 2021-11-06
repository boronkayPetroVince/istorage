<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /** @var SecurityService */
    private $security;

    /**
     * UserController constructor.
     * @param SecurityService $security
     */
    public function __construct(SecurityService $security)
    {
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="register", path="/register")
     */
    public function registerAction(Request $request):Response{
        if ($request->isMethod("POST")){
            $user = $request->request->get("username");
            $fullName = $request->request->get("fullName");
            $phoneNumber = $request->request->get("phoneNumber");
            $email = $request->request->get("emailad");
            $role = $request->request->get("roles");
            if ($request->request->get("password") === $request->request->get("password2")){
                if ($this->checkUser($user) === false){
                    $this->security->addUser($user,$request->request->get("password2"), $fullName, $email, $phoneNumber, $role);
                    //return new JsonResponse(["result"=>true]);
                    return $this->redirectToRoute("register", ["content"=>"Sikeres bejelentkezés"]);
                }
                else return $this->redirectToRoute("register", ["content"=>"HIBA"]);
            }
            //else return $this->render("security/register.html.twig");
            else return $this->render("security/register.html.twig", ["content"=>""]);
        }else{
            return $this->render("security/register.html.twig", ["content"=>""]);
        }
    }

    private function checkUser(string $username):bool{
        /** @var User[] $arr */
         $arr = $this->security->getAllUser();
         foreach($arr as $user){
             if ($user->getUsername() === $username) return true;
         }
         return false;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="app_login", path="/login")
     */
    public function loginAction(Request $request): Response{
        /** @var User $user */
        $user = $this->getUser();
        if ($user){
            //return new Response("Sikeres");
            return new JsonResponse(["result"=>$user]);
        }
        //return $this->render("security/login.html.twig", ["username" => $user]);
        else return new JsonResponse(["result"=>false]);
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
     * @param int $id
     * @return Response
     * @Route(name="update_action", path="/update")
     */
    public function updateAction(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");;
        if ($request->isMethod("POST")){
            if ($this->isGranted("ROLE_ADMIN")){
                $user = $this->security->getOneUserById($request->request->get("users"));
                if ($this->checkUser($request->request->get("username"))===false){
                    $user->setFullName($request->request->get("fullName"));
                    $user->setUsername($request->request->get("username"));
                    $user->setEmail($request->request->get("email"));
                    $user->setPhoneNumber((int)$request->request->get("phoneNumber"));
                    $this->security->updateUser($user->getId());
                    return new JsonResponse(["user" => $user]);
                }
                else return new JsonResponse(["user" => "Létezik a felhasználónév"]);
            }else return new JsonResponse(["user" => "Hozzáférés megtagadva"]);
        }else return $this->render("security/update.html.twig");

    }

    /**
     * @return Response
     * @Route(name="allUser", path="/allUser")
     */
    public function getAllUser():Response{
        $users = $this->security->getAllUser();
        return new JsonResponse($users);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route (name="getOneUser", path="/oneUser")
     */
    public function getOneUser(Request $request):Response{
        $user = $this->security->getOneUserById($request->request->get("username"));
        return new JsonResponse($user);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="check", path="/check")
     */
    public function check(Request $request): Response{
        if ($this->getUser()){
            return new JsonResponse(["result"=>1]);
        }else return new JsonResponse(["result" => 0]);
    }
}