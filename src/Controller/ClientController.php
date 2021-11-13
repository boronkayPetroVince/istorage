<?php


namespace App\Controller;




use App\Entity\Client;
use App\Entity\Country;
use App\Entity\Delivery_address;
use App\Service\CountryService;
use App\Service\ClientService;
use App\Service\ContactService;
use App\Service\DeliveryService;
use App\Service\SecurityService;
use App\Service\SettlementService;
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
    /** @var ContactService */
    private $contactService;

    /** @var DeliveryService */
    private $deliveryService;

    /** @var ClientService */
    private $clientService;

    /** @var SecurityService */
    private $securityService;

    /** @var CountryService */
    private $countryService;

    /** @var SettlementService */
    private $settlementService;

    /**
     * ClientController constructor.
     * @param ContactService $contactService
     * @param DeliveryService $deliveryService
     * @param ClientService $clientService
     * @param SecurityService $securityService
     * @param CountryService $countryService
     * @param SettlementService $settlementService
     */
    public function __construct(ContactService $contactService, DeliveryService $deliveryService, ClientService $clientService, SecurityService $securityService, CountryService $countryService, SettlementService $settlementService)
    {
        $this->contactService = $contactService;
        $this->deliveryService = $deliveryService;
        $this->clientService = $clientService;
        $this->securityService = $securityService;
        $this->countryService = $countryService;
        $this->settlementService = $settlementService;
    }


    /**
     * @param Request $request
     * @return Response
     * @Route(name="addClient", path="/addClient")
     */
    public function addClient(Request $request): Response{
        /*$this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isMethod("POST")){
            $client = new Client();
            $client->setClientName($request->request->get("client_name"));
            $client->setVatNumber($request->request->get("vatNumber"));
            $this->clientService->addClient($client);

            $country = new Country();
            $country->setCountryName($request->request->get("country"));
            $this->countryService->addCountry($country);

            $city = new City();
            $city->setCityName($request->request->get("city"));
            $city->setPostalCode($request->request->get("postalCode"));
            $city->setCountryID($this->countryService->getOneCountryById($country->getId()));
            $this->cityService->addCity($city);

            $delivery = new Delivery_address();
            $delivery->setClientID($this->clientService->getOneClientById($client->getId()));
            //$delivery->setCityID($this->cityService->getOneCityById($city->getId()));
            $delivery->setaddress($request->request->get("address"));
            $this->deliveryService->addAddress($delivery);
            return $this->render("Client/addClient.html.twig", ["result" => "Sikeres hozzáadás!"]);
        }else{
            return $this->render("Client/addClient.html.twig", ["result" => "Sikertelen"]);
        }*/
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="updateClient", path="/updateClient")
     */
    public function updateClient(Request $request): Response{
        /*$this->denyAccessUnlessGranted("ROLE_ADMIN");
        if ($request->isMethod("POST")){
            $client = $this->clientService->getOneClientById($request->request->get("clients"));
            $client->setClientName($request->request->get("client_name"));
            $client->setVatNumber($request->request->get("vatNumber"));
            $this->clientService->updateClient($client->getId());

            $city = $this->cityService->getCityByClient($request->request->get($client->getId()));
            $city->setCityName($request->request->get("city"));
            $city->setPostalCode($request->request->get("postalCode"));
            $this->cityService->updateCity($city->getId());

            $address = $this->deliveryService->getOneAddressById($request->request->get("address"));
            $address->setaddress($request->request->get("address"));
            $this->deliveryService->updateAddress($address->getId());

        }else{
            return $this->render("Client/updateClient.html.twig", ["result" =>"Sikertelen"]);
        }*/
    }






    /**
     * @param Request $request
     * @return Response
     * @Route(name="allClients", path="/allClients")
     */
    public function allClients(Request $request): Response{
        $clients = $this->clientService->getAllClient();
        return new JsonResponse($clients);
    }




}