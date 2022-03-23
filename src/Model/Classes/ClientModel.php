<?php


namespace App\Model\Classes;


use App\Entity\Client;
use App\Entity\Contact;
use App\Entity\Delivery_address;
use App\Entity\User;
use App\Model\Interfaces\ClientModelInterface;
use App\Service\Interfaces\ClientServiceInterface;
use App\Service\Interfaces\ContactServiceInterface;
use App\Service\Interfaces\CountryServiceInterface;
use App\Service\Interfaces\DeliveryServiceInterface;
use App\Service\Interfaces\RegionServiceInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use App\Service\Interfaces\SettlementServiceInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use DragonBe\Vies\Vies;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

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

    /** @var EntityManagerInterface */
    private $em;

    /**
     * ClientModel constructor.
     * @param SecurityServiceInterface $securityService
     * @param ClientServiceInterface $clientService
     * @param ContactServiceInterface $contactService
     * @param DeliveryServiceInterface $deliveryService
     * @param CountryServiceInterface $countryService
     * @param RegionServiceInterface $regionService
     * @param SettlementServiceInterface $settlementService
     * @param EntityManagerInterface $em
     */
    public function __construct(SecurityServiceInterface $securityService, ClientServiceInterface $clientService, ContactServiceInterface $contactService, DeliveryServiceInterface $deliveryService, CountryServiceInterface $countryService, RegionServiceInterface $regionService, SettlementServiceInterface $settlementService, EntityManagerInterface $em)
    {
        $this->securityService = $securityService;
        $this->clientService = $clientService;
        $this->contactService = $contactService;
        $this->deliveryService = $deliveryService;
        $this->countryService = $countryService;
        $this->regionService = $regionService;
        $this->settlementService = $settlementService;
        $this->em = $em;
    }


    public function addClient(Request $request, User $user): bool
    {
        $vatNumber = $request->request->get("newVatNumber");
        if($request && $this->checkVat($vatNumber)){
            $client = new Client();
            if($this->checkClient($request->request->get("newClientName"))){
                $client->setClientName($request->request->get("newClientName"));
            }else return false;
            $postalCode = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postCode"));

            $delivery = new Delivery_address();
            $delivery->setSettlementID($this->settlementService->getOneSettlementById($postalCode->getId()));
            $delivery->setaddress($request->request->get("newAddress"));
            $this->deliveryService->addAddress($delivery);

            $contact = new Contact();
            $contact->setFullName($request->request->get("newContact_Fullname"));
            $contact->setEmail($request->request->get("newContact_Email"));
            $contact->setPhoneNumber("+36".$request->request->get("newContact_Phonenumber"));
            $this->contactService->addContact($contact);

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
            $contact->setPhoneNumber("+36".$request->request->get("contact_PhoneNumber"));
            $contact->setEmail($request->request->get("contact_Email"));
            $this->contactService->updateContact($contact->getId());
            return true;
        }
        return false;
    }

    public function getOneSettlement(Request $request): Response
    {
        $postalCode = $this->settlementService->getOneSettlementByPostalcode($request->request->get("postalCode"));
        return new JsonResponse($postalCode);
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

    public function clientsPDF(string $html)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ob_get_clean();
        $dompdf->stream("ugyfelek.pdf", [
            "Attachment" => true
        ]);
    }

    public function clientsExcel()
    {
        /** @var Client[] $clients */
        $clients = $this->clientService->getAllClient();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Ügyfél neve');
        $sheet->setCellValue('C1', 'Adószám');
        $sheet->setCellValue('D1', 'Kapcsolattartó név');
        $sheet->setCellValue('E1', 'Kapcsolattartó telefon');
        $sheet->setCellValue('F1', 'Kapcsolattartó email');
        $sheet->setCellValue('G1', 'Cím');
        $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($clients as $client){
            $sheet->setCellValue('A'.$counter, $client->getId());
            $sheet->setCellValue('B'.$counter, $client->getClientName());
            $sheet->setCellValue('C'.$counter, $client->getVatNumber());
            $sheet->setCellValue('D'.$counter, $client->getContactID()->getFullName());
            $sheet->setCellValue('E'.$counter, $client->getContactID()->getPhoneNumber());
            $sheet->setCellValue('F'.$counter, $client->getContactID()->getEmail());
            $sheet->setCellValue('G'.$counter, $client->getDeliveryID()->getSettlementID()->getPostalCode(). " ".
                $client->getDeliveryID()->getSettlementID()->getSettlementName()." ".$client->getDeliveryID()->getAddress());
            $counter++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = "ugyfelek";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        $writer->save('php://output');
        die();
    }


    private function checkVat(string $vatNumber):bool{
        //Internet ellenőrzés
        $isConnected = $this->em->getConnection()->isConnected();
        if($isConnected === true){
            $vies = new Vies();
            $vatResult = $vies->validateVat(
                'HU',
                $vatNumber,
                'HU',
                '56960646'
            );
            return $vatResult->isValid();
        }
        return true;
    }

}