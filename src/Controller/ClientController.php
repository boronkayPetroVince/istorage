<?php


namespace App\Controller;




use App\Entity\Client;
use App\Entity\Country;
use App\Entity\Delivery_address;
use App\Entity\Settlement;
use App\Entity\User;
use App\Model\Interfaces\ClientModelInterface;
use App\Service\Interfaces\ClientServiceInterface;
use App\Service\Interfaces\CountryServiceInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use App\Service\Interfaces\SettlementServiceInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package App\Controller
 * @Route(path="/client")
 */
class ClientController extends AbstractController
{
    /** @var SecurityServiceInterface */
    private $securityService;

    /** @var ClientServiceInterface */
    private $clientService;

    /** @var ClientModelInterface */
    private $clientModel;

    /** @var SettlementServiceInterface */
    private $settlementService;

    /** @var CountryServiceInterface */
    private $countryService;

    /**
     * ClientController constructor.
     * @param SecurityServiceInterface $securityService
     * @param ClientServiceInterface $clientService
     * @param ClientModelInterface $clientModel
     * @param SettlementServiceInterface $settlementService
     * @param CountryServiceInterface $countryService
     */
    public function __construct(SecurityServiceInterface $securityService, ClientServiceInterface $clientService, ClientModelInterface $clientModel, SettlementServiceInterface $settlementService, CountryServiceInterface $countryService)
    {
        $this->securityService = $securityService;
        $this->clientService = $clientService;
        $this->clientModel = $clientModel;
        $this->settlementService = $settlementService;
        $this->countryService = $countryService;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="addClient", path="/addClient")
     */
    public function addClient(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        /** @var User $user */
        $user = $this->getUser();
        if ($request->isMethod("POST")){
            if($this->clientModel->addClient($request, $user)){
                return $this->render("Client/clients.html.twig", [
                    "clients" => $this->clientService->getAllClient(),
                    "user" => $this->getUser(),
                    "resultMessage"=> "Sikeres hozzáadás!",
                    "resultColor" => "success"]);
            }else{
                return $this->render("Client/clients.html.twig", [
                    "clients" => $this->clientService->getAllClient(),
                    "user" => $this->getUser(),
                    "resultMessage"=> "Sikertelen hozzáadás! Az ügyfél neve már létezik, vagy érvénytelen adószámot adott meg!",
                    "resultColor" => "danger"
                ]);
            }
        }else{
            return $this->render("Client/clients.html.twig", [
                "clients" => $this->clientService->getAllClient(),
                "user" => $this->getUser(),
                "resultMessage"=> "",
                "resultColor" => ""
            ]);
        }
    }
    /**
     * @param Request $request
     * @param int $clientId
     * @return Response
     * @Route(name="updateClient", path="/updateClient/{clientId}")
     */
    public function updateClient(Request $request, int $clientId): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isMethod("POST")){
            if($this->clientModel->updateClient($request,$clientId) === true){
                return $this->render("Client/clients.html.twig", [
                    "clients" => $this->clientService->getAllClient(),
                    "user" => $this->getUser(),
                    "resultMessage"=> "Sikeres módosítás!",
                    "resultColor" => "success"
                ]);
            }else{
                return $this->render("Client/clients.html.twig", [
                    "clients" => $this->clientService->getAllClient(),
                    "user" => $this->getUser(),
                    "resultMessage"=> "Sikertelen módosítás! Érvénytelen adószámot adott meg!",
                    "resultColor" => "danger"
                ]);
            }
        }
        return $this->render("Client/clients.html.twig", [
            "clients" => $this->clientService->getAllClient(),
            "user" => $this->getUser(),
            "resultMessage"=> "",
            "resultColor" => ""
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="getOneSettlementForUpdating", path="/getOneSettlementForUpdating")
     */
    public function getOneSettlementForUpdating(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $postalCode = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postalCode"));
        return new JsonResponse($postalCode);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="getOneSettlementForAdding", path="/getOneSettlementForAdding")
     */
    public function getOneSettlementForAdding(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $postalCode = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postCode"));
        return new JsonResponse($postalCode);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allClients", path="/allClients")
     */
    public function allClients(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return $this->render("Client/clients.html.twig", [
            "clients" => $this->clientService->getAllClient(),
            "user" => $this->getUser(),
            "resultMessage"=> "",
            "resultColor" => ""
        ]);
    }
    /**
     * @param Request $request
     * @return Response
     * @Route(name="selectAllClients", path="/selectAllClients")
     */
    public function selectAllClients(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return new JsonResponse($this->clientModel->allClients());
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="oneClientById", path="/oneClientById")
     */
    public function oneClientById(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return new JsonResponse($this->clientModel->getOneClientById($request));
    }

    /**
     * @Route(name="generateClientPDF", path="/generateClientPDF")
     */
    public function generatePDF(){
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $html = $this->renderView('Client/clientsPDF.html.twig', ["clients" => $this->clientService->getAllClient()]);
        $this->clientModel->clientsPDF($html);
    }

    /**
     * @Route(name="generateClientExcel", path="/generateClientExcel")
     */
    public function generateExcel(){
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $this->clientModel->clientsExcel();
    }




}