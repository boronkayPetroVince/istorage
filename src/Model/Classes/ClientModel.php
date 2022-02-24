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
            $postalCode = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postCode"));
            $delivery = new Delivery_address();
            $delivery->setSettlementID($this->settlementService->getOneSettlementById($postalCode->getId()));
            $delivery->setaddress($request->request->get("newAddress"));
            $this->deliveryService->addAddress($delivery);
            $contact = new Contact();
            $contact->setFullName($request->request->get("newContact_Fullname"));
            $contact->setEmail($request->request->get("newContact_Email"));
            $contact->setPhoneNumber($request->request->get("newContact_Phonenumber"));
            $this->contactService->addContact($contact);
            $client = new Client();
            $client->setClientName($request->request->get("newClientName"));
            $client->setVatNumber($request->request->get("newVatNumber"));
            $client->setDeliveryID($this->deliveryService->getOneAddressById($delivery->getId()));
            $client->setContactID($this->contactService->getOneContactById($contact->getId()));
            $this->clientService->addClient($client);
            return true;
        }
        return false;

    }
    //módosítás
    public function updateClient(Request $request, int $clientId): bool
    {
        $client = $this->clientService->getOneClientById($clientId);
        if($request){
            $client->setClientName($request->request->get("clientName"));
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
        return $this->clientService->getAllClient();
    }

    public function getOneClientById(Request $request): iterable
    {
        return $this->clientService->getOneClientBySelect($request->request->get("clientNameID"));
    }


}