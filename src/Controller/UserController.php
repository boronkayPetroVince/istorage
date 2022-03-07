<?php


namespace App\Controller;


use App\Entity\User;
use App\Model\Classes\StockModel;
use App\Model\Interfaces\StockModelInterface;
use App\Model\Interfaces\UserModelInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



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
        /** @var User $user */
        $user = $this->getUser();
        if($user != null){
            return $this->render("index.html.twig", [
                "user" => $user,
                "inStock" => $this->stockModel->stockCount(),
                "wh" => $this->stockModel->warehouseById(),
                "outgoingPrice" => $this->stockModel->monthOutgoing(),
                "incomingPrice" => $this->stockModel->monthIncoming(),
                "arrivedCount" => $this->stockModel->stockCount()
            ]);
        }
        return $this->redirectToRoute('app_login');

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
                        "resultMessage"=> "Sikeres hozzáadás!", "resultColor" => "success"]);
                }else return $this->render("user/users.html.twig", ["users" => $this->security->getAllUser(), "user" => $this->getUser(),
                    "resultMessage"=> "Sikertelen hozzáadás! Felhasználónév már foglalt, vagy a megadott jelszavak nem egyeznek!", "resultColor" => "danger"]);
            }else return $this->render("user/users.html.twig", ["users" => $this->security->getAllUser(), "user" => $this->getUser(),
                "resultMessage"=> "Rosszul érkeztek be az adatok!", "resultColor" => "warning"]);
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
                return $this->render("index.html.twig", ["user" => $this->getUser(), "inStock" => $this->stockModel->stockCount(),"inStock" => $this->stockModel->stockCount(),
                    "wh" => $this->stockModel->warehouseById(),
                    "outgoingPrice" => $this->stockModel->monthOutgoing()]);
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
                    return $this->render("user/users.html.twig", ["users" => $this->security->getAllUser(),"user" => $this->getUser(),
                        "resultMessage"=> "Sikeres módosítás!", "resultColor" => "success"]);
                }else return $this->render("user/updateFailed.html.twig", ["user" => $this->security->getOneUserById($userId),
                    "resultMessage"=> "Sikertelen adatmódosítás!", "resultColor" => "red"]);
            }else return new Response("Hozzáférés megtagadva");
        }else return $this->redirect($this->allUsers());
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="updateLoggedUser", path="/updateLoggedUser")
     */
    public function updateLoggedUser(Request $request): Response{
        /** @var User $user */
        $user = $this->getUser();
        if($request->isMethod("POST")){
            if($this->userModel->updateLoggedUser($request, $user) === true){
                return $this->render("user/profile.html.twig", ["user" =>$this->getUser(),"resultMessage"=> "Sikeres adatmódosítás!", "resultColor" => "success"]);
            }else {
                return $this->render("user/profile.html.twig", ["user" =>$this->getUser(),"resultMessage"=> "Sikertelen adatmódosítás!", "resultColor" => "danger"]);
            }
        }
        return $this->render("user/profile.html.twig", ["user" => $this->getUser(),
            "resultMessage"=> "", "resultColor" => ""]);

    }

    /**
     * @return Response
     * @Route(name="users", path="/users")
     */
    public function allUsers():Response{
        return $this->render("user/users.html.twig", ["users" => $this->security->getAllUser(),"user" => $this->getUser(),
            "resultMessage"=> "", "resultColor" => "", "show" => 'hide']);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="passChange", path="/passChange")
     */
    public function changePass(Request $request): Response{
        /** @var User $user */
        $user = $this->getUser();
        if($request->isMethod("POST")){
            if($this->userModel->changePass($request,$user)){
                return $this->render("user/profile.html.twig", ["user" =>$this->getUser(),"resultMessage"=> "Sikeres jelszó módosítás!", "resultColor" => "success"]);
            }else return $this->render("user/profile.html.twig", ["user" =>$this->getUser(),"resultMessage"=> "Sikertelen jelszó módosítás! A jelszók nem egyeznek, vagy rossz jelenlegi ", "resultColor" => "danger"]);
        }
        return $this->render("user/profile.html.twig", ["user" => $this->getUser(),
            "resultMessage"=> "", "resultColor" => ""]);
    }

    /**
     * @Route(name="generateUserPDF", path="/generateUserPDF")
     */
    public function generatePDF(){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('user/usersPDF.html.twig', ["users" => $this->security->getAllUser()]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ob_get_clean();
        $dompdf->stream("raktarosok.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route(name="generateUserExcel", path="/generateUserExcel")
     */
    public function generateExcel(){
        /** @var User[] $users */
        $users = $this->security->getAllUser();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Felhasználónév');
        $sheet->setCellValue('C1', 'Teljes név');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Telefonszám');
        $sheet->setCellValue('F1', 'Jogosultság');
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($users as $user){
            $sheet->setCellValue('A'.$counter, $user->getId());
            $sheet->setCellValue('B'.$counter, $user->getUsername());
            $sheet->setCellValue('C'.$counter, $user->getFullName());
            $sheet->setCellValue('D'.$counter, $user->getEmail());
            $sheet->setCellValue('E'.$counter, $user->getPhoneNumber());
            $sheet->setCellValue('F'.$counter, $user->getRoles()[0]);
            $counter++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = "raktarosok";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        $writer->save('php://output');
        die();
    }



}