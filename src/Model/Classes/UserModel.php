<?php


namespace App\Model\Classes;


use App\Entity\User;
use App\Model\Interfaces\UserModelInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
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
            if(str_contains($request->request->get("newPhoneNumber"), "+36")){
                $phoneNumber = $request->request->get("newPhoneNumber");
            }else{
                $phoneNumber = "+36".$request->request->get("newPhoneNumber");
            }
            $role = "ROLE_ADMIN";
            if ($request->request->get("newPassword") === $request->request->get("newPasswordAgain")){
                $this->securityService->addUser($user,$request->request->get("newPasswordAgain"), $fullName, $email, $phoneNumber, $role);
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
            if(str_contains($request->request->get("phoneNumber"), "+36")){
                $user->setPhoneNumber($request->request->get("phoneNumber"));
            }else{
                $user->setPhoneNumber("+36".$request->request->get("phoneNumber"));
            }
            $user->setRoles(["ROLE_ADMIN"]);
            $this->securityService->updateUser($user->getId());
            return true;
        }else return false;
    }

    public function updateLoggedUser(Request $request, User $user): bool{
        if($request->isMethod("POST")){
            $user->setFullName($request->request->get("fullName"));
            if($this->checkUser($request->request->get("username"))){
                $user->setUsername($request->request->get("username"));
            }
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
    public function usersPDF($html){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ob_get_clean();
        $dompdf->stream("raktarosok.pdf", [
            "Attachment" => true
        ]);
    }
    public function usersExcel(){
        /** @var User[] $users */
        $users = $this->securityService->getAllUser();
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