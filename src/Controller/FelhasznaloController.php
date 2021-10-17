<?php


namespace App\Controller;


use App\Entity\Felhasznalo;
use App\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route(name="register", path="/register"), methods={"POST"})
     */
    public function registerAction(Request $request):Response{


        $felhNev = $request->request->get("felhasznalo");
        $telNev = $request->request->get("teljNev");
        $telo = $request->request->get("telefonszam");
        $email = $request->request->get("emailad");
        $role = $request->request->get("roles");
        if ($request->request->get("jelszo") === $request->request->get("jelszo2")){
            if ($this->checkFelhasznalo($felhNev) === false){
                $this->security->addFelhasznalo($felhNev,$request->request->get("jelszo2"), $telNev,$telo, $email, $role);
                return new Response("SIKEREEES REGISZT");
            }
            else return $this->render("security/register.html.twig");
        }
        else return new Response("WRONG_APSSSWORD");
    }

    private function checkFelhasznalo(string $felhNev):bool{
         $arr = $this->security->getAllFelhasznalo();
         foreach($arr as $elem){
             if (in_array($felhNev, $elem)) return true;
         }
         return false;
    }

    /**
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @Route(name="app_login", path="/login")
     */
    public function loginAction(Request $request): Response{
        /** Nem működik */
        /** @var Felhasznalo $user */
        $user = $this->getUser();
        if ($user){
            return new Response("Sikeres ");
        }
        return $this->render("security/login.html.twig");


    }

}