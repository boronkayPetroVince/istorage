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
            return new Response("INVALID ACCESS");
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
            return new JsonResponse(["result"=>$user]);
        }
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
        $user = $this->security->getOneFelhasznaloById($request->request->get("felhNev"));
        /** @var Felhasznalo $currUser */
        $currUser = $this->getUser();
        //$users = $this->security->getAllFelhasznalo();
        if ($this->checkFelhasznalo($request->request->get("felhNev"))===false){
            $user->setTelNev($request->request->get("telNev"));
            $user->setUsername($request->request->get("tesztFelh"));
            $user->setEmail($request->request->get("email"));
            $user->setTelefonszam((int)$request->request->get("telSzam"));
            $this->security->updateFelhasznalo($user->getId());
            return new JsonResponse(["nev" => $user]);
        }
        else return new JsonResponse(["nev" => "Létezik a felhasználónév"]);
    }

    /**
     * @return Response
     * @Route(name="allFelhasz", path="/allFelhasz")
     */
    public function getAllFelhasznalo():Response{
        $users = $this->security->getAllFelhasznalo();
        return new JsonResponse($this->getUser());
    }

    /**
     * @param Request $request
     * @return Response
     * @Route (path="/oneUser", name="getOneUser")
     */
    public function getOneUser(Request $request):Response{
        $user = $this->security->getOneFelhasznaloById($request->request->get("felhNev"));
        return new JsonResponse($user);
    }
}