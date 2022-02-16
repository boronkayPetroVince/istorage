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
                return $this->render("Client/addClient.html.twig", ["result" => "Sikeres hozzáadás!"]);
            }
            else{
                return $this->render("Client/addClient.html.twig", ["result" => "Sikertelen!"]);
            }
        }else{
            return $this->render("Client/addClient.html.twig", ["result" => ""]);
        }
    }
    /**
     * @param Request $request
     * @return Response
     * @Route(name="updateClient", path="/updateClient")
     */
    public function updateClient(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isMethod("POST")){
            if($this->clientModel->updateClient($request) == true){
                return $this->render("Client/updateClient.html.twig", ["result" =>"Sikeres frissítés"]);
            }else{
                return $this->render("Client/updateClient.html.twig", ["result" =>"Sikertelen"]);
            }
        }else{
            return $this->render("Client/updateClient.html.twig", ["result" =>""]);
        }
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="getOneSettlement")
     */
    public function getOneSettlement(Request $request):Response{
        //$postalCode = $this->clientModel->getOneSettlement($request);
        $postalCode = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postalCode"));
        return new JsonResponse($postalCode);
    }

    /**
     * @return Response
     * @Route(name="getAllCountry", path="/getAllCountry")
     */
    public function getAllCountry():Response{
        //$country = $this->clientModel->getAllCountry();
        $country = $this->countryService->getAllCountry();
        return new JsonResponse($country);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allClients", path="/allClients")
     */
    public function allClients(Request $request): Response{
        //$clients = $this->clientService->getAllClient();
        $clients = $this->clientModel->allClients();
        return $this->render("Client/clients.html.twig");
    }




}