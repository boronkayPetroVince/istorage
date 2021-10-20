<?php


namespace App\Controller;


use App\Entity\Felhasznalo;
use App\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FelhasznaloController extends AbstractController
{
    /** @var SecurityService */
    private $security;

    /**
     * FelhasznaloController constructor.
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
            $felhNev = $request->request->get("username");
            $telNev = $request->request->get("teljNev");
            $telo = $request->request->get("telefonszam");
            $email = $request->request->get("emailad");
            $role = $request->request->get("roles");
            if ($request->request->get("password") === $request->request->get("password2")){
                if ($this->checkFelhasznalo($felhNev) === false){
                    $this->security->addFelhasznalo($felhNev,$request->request->get("password2"), $telNev, $email, $telo, $role);
                    //return new JsonResponse(["result"=>true]);
                    return new Response("SIKEREEES REGISZT");
                }
                else return new Response("Sikertelen feldolgozás");
            }
            else return new Response("WRONG_APSSSWORD");
        }else{
            return $this->render('security/register.html.twig');
        }
    }

    private function checkFelhasznalo(string $felhNev):bool{
        /** @var Felhasznalo[] $arr */
         $arr = $this->security->getAllFelhasznalo();
         foreach($arr as $elem){
             if ($elem->getUsername() === $felhNev) return true;
         }
         return false;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="app_login", path="/login")
     */
    public function loginAction(Request $request): Response{
        /** Nem működik */
        /** @var Felhasznalo $user */
        $user = $this->getUser();
        if ($user){
            return new Response("Sikeres");
        }
        else return $this->render("security/login.html.twig");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="app_logout", path="/logout")
     */
    public function logoutAction(Request $request): Response{

    }
}