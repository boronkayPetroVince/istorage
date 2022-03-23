<?php


namespace App\Controller;


use App\Entity\User;
use App\Model\Interfaces\StockModelInterface;
use App\Model\Interfaces\UserModelInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /** @var UserModelInterface */
    private $userModel;

    /** @var SecurityServiceInterface */
    private $security;

    /** @var StockModelInterface */
    private $stockModel;

    /**
     * UserController constructor.
     * @param UserModelInterface $userModel
     * @param SecurityServiceInterface $security
     * @param StockModelInterface $stockModel
     */
    public function __construct(UserModelInterface $userModel, SecurityServiceInterface $security, StockModelInterface $stockModel)
    {
        $this->userModel = $userModel;
        $this->security = $security;
        $this->stockModel = $stockModel;
    }


    /**
     * @param Request $request
     * @return Response
     * @Route(name="main", path="/main")
     */
    public function mainMenu(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
            return $this->render("index.html.twig", [
                "user" => $this->getUser(),
                "inStockCount" => $this->stockModel->stockCountByStatus("Beérkezett"),
                "orderedStockCount" => $this->stockModel->stockCountByStatus("Megrendelve"),
                "wh" => $this->stockModel->warehouseById(),
                "outgoingPrice" => $this->stockModel->monthOutgoing(),
                "incomingPrice" => $this->stockModel->monthIncoming(),
                "stockCount" => $this->stockModel->stockCount(),
                "month" =>$this->stockModel->allIncomingsPerMonths(),
                "stocks" =>$this->stockModel->allArrivedStockPerWeek(),
                "orders" => $this->stockModel->allOrderPerWeek()
            ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="addUser", path="/addUser")
     */
    public function addUser(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isMethod("POST")){
            if($this->userModel->addUser($request) === true){
                return $this->render("user/users.html.twig", [
                    "users" => $this->security->getAllUser(),
                    "user" => $this->getUser(),
                    "resultMessage"=> "Sikeres hozzáadás!", "resultColor" => "success"
                ]);
            }else return $this->render("user/users.html.twig", [
                "users" => $this->security->getAllUser(),
                "user" => $this->getUser(),
                "resultMessage"=> "Sikertelen hozzáadás! Felhasználónév már foglalt, vagy a megadott jelszavak nem egyeznek!",
                "resultColor" => "danger"
            ]);
        }else return $this->render("user/users.html.twig", [
            "users" => $this->security->getAllUser(),
            "user" => $this->getUser(),
            "resultMessage"=> "Rosszul érkeztek be az adatok! A hozzáadás nem sikerült!",
            "resultColor" => "warning"]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="app_login", path="/login")
     */
    public function loginAction(Request $request): Response{
        /** @var User $user */
        $user = $this->getUser();
        if($request->isMethod("POST")){
            if ($this->userModel->loginAction($request,$user) === true) {
                return $this->render("index.html.twig", [
                    "user" => $user,
                    "inStockCount" => $this->stockModel->stockCountByStatus("Beérkezett"),
                    "orderedStockCount" => $this->stockModel->stockCountByStatus("Megrendelve"),
                    "wh" => $this->stockModel->warehouseById(),
                    "outgoingPrice" => $this->stockModel->monthOutgoing(),
                    "incomingPrice" => $this->stockModel->monthIncoming(),
                    "stockCount" => $this->stockModel->stockCount(),
                    "month" => $this->stockModel->allIncomingsPerMonths(),
                    "stocks" => $this->stockModel->allArrivedStockPerWeek(),
                    "orders" => $this->stockModel->allOrderPerWeek()
                ]);
            }else return $this->render("User/login.html.twig", ["resultMessage" => "Hibás felhasználónév, vagy jelszó!"]);
        }else return $this->render("User/login.html.twig", ["resultMessage" => ""]);

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
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isMethod("POST")) {
            if($this->userModel->updateUser($request, $userId) === true){
                return $this->render("user/users.html.twig", [
                    "users" => $this->security->getAllUser(),
                    "user" => $this->getUser(),
                    "resultMessage"=> "Sikeres módosítás!",
                    "resultColor" => "success"
                ]);
            }else return $this->render("user/users.html.twig", [
                "users" => $this->security->getAllUser(),
                "user" => $this->getUser(),
                "resultMessage"=> "Sikertelen adatmódosítás!",
                "resultColor" => "warning"]);
        }else return $this->redirect($this->allUsers());
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="updateLoggedUser", path="/updateLoggedUser")
     */
    public function updateLoggedUser(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        /** @var User $user */
        $user = $this->getUser();
        if($this->userModel->updateLoggedUser($request, $user) === true){
            return $this->render("user/profile.html.twig", [
                "user" =>$this->getUser(),
                "resultMessage"=> "Sikeres adatmódosítás!",
                "resultColor" => "success"
            ]);
        }else {
            return $this->render("user/profile.html.twig", [
                "user" =>$this->getUser(),
                "resultMessage"=> "",
                "resultColor" => ""
            ]);
        }
    }

    /**
     * @return Response
     * @Route(name="users", path="/users")
     */
    public function allUsers():Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return $this->render("user/users.html.twig", [
            "users" => $this->security->getAllUser(),
            "user" => $this->getUser(),
            "resultMessage"=> "",
            "resultColor" => "",
            "show" => 'hide'
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="passChange", path="/passChange")
     */
    public function changePass(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        /** @var User $user */
        $user = $this->getUser();
        if($request->isMethod("POST")){
            if($this->userModel->changePass($request,$user)){
                return $this->render("user/profile.html.twig", [
                    "user" =>$this->getUser(),
                    "resultMessage"=> "Sikeres jelszó módosítás!",
                    "resultColor" => "success"
                ]);
            }else return $this->render("user/profile.html.twig", [
                "user" =>$this->getUser(),
                "resultMessage"=>"Sikertelen jelszó módosítás! Az új jelszók nem egyeznek, vagy tévesen adta meg a jelenlegi jelszót!",
                "resultColor" => "danger"
            ]);
        }
        return $this->render("user/profile.html.twig", [
            "user" => $this->getUser(),
            "resultMessage"=> "",
            "resultColor" => ""
        ]);
    }

    /**
     * @Route(name="generateUserPDF", path="/generateUserPDF")
     */
    public function generatePDF(){
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $html = $this->renderView('user/usersPDF.html.twig', ["users" => $this->security->getAllUser()]);
        $this->userModel->usersPDF($html);
    }

    /**
     * @Route(name="generateUserExcel", path="/generateUserExcel")
     */
    public function generateExcel(){
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $this->userModel->usersExcel();
    }



}