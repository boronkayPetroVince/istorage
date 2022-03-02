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
use DragonBe\Vies\Vies;
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
        $vatNumber = $request->request->get("newVatNumber");
        if($request && $this->checkVat($vatNumber)){
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
            if($this->checkClient($request->request->get("newClientName"))){
                $client->setClientName($request->request->get("newClientName"));
            }else return false;
            $client->setVatNumber($vatNumber);
            $client->setDeliveryID($this->deliveryService->getOneAddressById($delivery->getId()));
            $client->setContactID($this->contactService->getOneContactById($contact->getId()));
            $this->clientService->addClient($client);
            return true;
        }
        return false;

    }

    public function updateClient(Request $request, int $clientId): bool
    {
        $client = $this->clientService->getOneClientById($clientId);
        $vatNumber = $request->request->get("vatNumber");
        if($this->checkVat($vatNumber)){
            if($this->checkClient($request->request->get("clientName"))){
                $client->setClientName($request->request->get("clientName"));
            }
            $client->setVatNumber($request->request->get("vatNumber"));
            $this->clientService->updateClient($client->getId());

            $settlement = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postalCode"));

            $address = $this->deliveryService->getOneAddressById($client->getDeliveryID()->getId());
            $address->setaddress($request->request->get("address"));
            $address->setSettlementID($settlement);
            $this->deliveryService->updateAddress($address->getId());

            $contact = $this->contactService->getOneContactById($client->getContactID()->getId());
            $contact->setFullName($request->request->get("contact_FullName"));
            $contact->setPhoneNumber($request->request->get("contact_PhoneNumber"));
            $contact->setEmail($request->request->get("contact_Email"));
            $this->contactService->updateContact($contact->getId());
            return true;
        }
        return false;
    }

    public function getOneSettlement(Request $request): Response
    {
        if($request){
            $postalCode = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postalCode"));
            return new JsonResponse($postalCode);
        }
        return new JsonResponse(null);
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

    public function checkClient(string $clientName): bool
    {
        /** @var Client[] $arr */
        $arr = $this->clientService->getAllClient();
        foreach($arr as $client){
            if (strtolower($client->getClientName()) === strtolower($clientName)) return false;
        }
        return true;
    }

    private function checkVat(string $vatNumber):bool{
        $vies = new Vies();
        $vatResult = $vies->validateVat(
            'HU',
            $vatNumber,
            'HU',
            '56960646'
        );
        return $vatResult->isValid();
    }

}