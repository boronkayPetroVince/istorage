<?php


namespace App\Model\Classes;


use App\Entity\Client;
use App\Entity\Contact;
use App\Entity\Delivery_address;
use App\Entity\Settlement;
use App\Entity\User;
use App\Model\Interfaces\ClientModelInterface;
use App\Service\Interfaces\ClientServiceInterface;
use App\Service\Interfaces\ContactServiceInterface;
use App\Service\Interfaces\CountryServiceInterface;
use App\Service\Interfaces\DeliveryServiceInterface;
use App\Service\Interfaces\RegionServiceInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use App\Service\Interfaces\SettlementServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientModel implements ClientModelInterface
{
    /** @var SecurityServiceInterface */
    private $securityService;

    /** @var ClientServiceInterface */
    private $clientService;

    /** @var ContactServiceInterface */
    private $contactService;

    /** @var DeliveryServiceInterface */
    private $deliveryService;

    /** @var CountryServiceInterface */
    private $countryService;

    /** @var RegionServiceInterface */
    private $regionService;

    /** @var SettlementServiceInterface */
    private $settlementService;

    /**
     * ClientModel constructor.
     * @param SecurityServiceInterface $securityService
     * @param ClientServiceInterface $clientService
     * @param ContactServiceInterface $contactService
     * @param DeliveryServiceInterface $deliveryService
     * @param CountryServiceInterface $countryService
     * @param SettlementServiceInterface $settlementService
     * @param RegionServiceInterface $regionService
     */
    public function __construct(SecurityServiceInterface $securityService, ClientServiceInterface $clientService, ContactServiceInterface $contactService, DeliveryServiceInterface $deliveryService, CountryServiceInterface $countryService,RegionServiceInterface $regionService, SettlementServiceInterface $settlementService)
    {
        $this->securityService = $securityService;
        $this->clientService = $clientService;
        $this->contactService = $contactService;
        $this->deliveryService = $deliveryService;
        $this->countryService = $countryService;
        $this->regionService = $regionService;
        $this->settlementService = $settlementService;
    }

    public function addClient(Request $request, User $user): bool
    {
        if($request){
            $client = new Client();
            $client->setClientName($request->request->get("client_name"));
            $client->setVatNumber($request->request->get("vatNumber"));
            $this->clientService->addClient($client);
            //$country = $this->countryService->getOneCountryById($request->request->get("country"));
            //$region = $this->regionService->getOneRegionByName($request->request->get("region_name"));
            $postalCode = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postalCode"));
            $delivery = new Delivery_address();
            $delivery->setClientID($this->clientService->getOneClientById($client->getId()));
            $delivery->setSettlementID($this->settlementService->getOneSettlementById($postalCode->getId()));
            $delivery->setaddress($request->request->get("address"));
            $this->deliveryService->addAddress($delivery);

            $contact = new Contact();
            $contact->setFullName($request->request->get("contact_fullName"));
            $contact->setEmail($request->request->get("contact_Email"));
            $contact->setPhoneNumber($request->request->get("contact_PhoneNumber"));
            $contact->setClientID($this->clientService->getOneClientById($client->getId()));
            $this->contactService->addContact($contact);

            return true;
        }else{
            return false;
        }

    }

    public function updateClient(Request $request): bool
    {
        if($request){
            $client = $this->clientService->getOneClientById($request->request->get("clients"));
            $client->setClientName($request->request->get("client_name"));
            $client->setVatNumber($request->request->get("vatNumber"));
            $this->clientService->updateClient($client->getId());

            $settlement = $this->settlementService->getOneSettlementByPostalcode("postalCode");

            $address = $this->deliveryService->getOneAddressById($request->request->get("address"));
            $address->setaddress($request->request->get("address"));
            $address->setSettlementID($settlement);
            $this->deliveryService->updateAddress($address->getId());
            return true;
        }else{
            return false;
        }

    }

    public function getOneSettlement(Request $request): Response
    {
        if($request){
            $postalCode = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postalCode"));
            return new JsonResponse($postalCode);
        }else{
            return new JsonResponse(null);
        }

    }

    public function getAllCountry(): Response
    {
        $country = $this->countryService->getAllCountry();
        return new JsonResponse($country);
    }

    public function allClients(): iterable
    {
        $clients = $this->clientService->getAllClient();
        return $clients;
    }


}