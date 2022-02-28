<?php


namespace App\Model\Classes;


use App\Entity\Phone;
use App\Entity\Status;
use App\Entity\Stock;
use App\Entity\User;
use App\Entity\Warehouse;
use App\Model\Interfaces\PhoneModelInterface;
use App\Model\Interfaces\StockModelInterface;
use App\Service\Interfaces\BrandServiceInterface;
use App\Service\Interfaces\CapacityServiceInterface;
use App\Service\Interfaces\ClientServiceInterface;
use App\Service\Interfaces\ColorServiceInterface;
use App\Service\Interfaces\ModelServiceInterface;
use App\Service\Interfaces\PhoneServiceInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use App\Service\Interfaces\StatusServiceInterface;
use App\Service\Interfaces\StockServiceInterface;
use App\Service\Interfaces\WarehouseServiceInterface;
use Symfony\Component\HttpFoundation\Request;

class StockModel implements StockModelInterface
{
    /** @var PhoneModelInterface */
    private $phoneModel;

    /** @var WarehouseServiceInterface */
    private $warehouseService;

    /** @var StockServiceInterface */
    private $stockService;

    /** @var StatusServiceInterface */
    private $statusService;

    /** @var SecurityServiceInterface */
    private $securityService;

    /** @var CapacityServiceInterface */
    private $capacityService;

    /** @var ColorServiceInterface */
    private $colorService;

    /** @var ModelServiceInterface */
    private $modelService;

    /** @var BrandServiceInterface */
    private $brandService;

    /** @var PhoneServiceInterface */
    private $phoneService;

    /** @var ClientServiceInterface */
    private $clientService;

    /**
     * StockModel constructor.
     * @param PhoneModelInterface $phoneModel
     * @param WarehouseServiceInterface $warehouseService
     * @param StockServiceInterface $stockService
     * @param StatusServiceInterface $statusService
     * @param SecurityServiceInterface $securityService
     * @param CapacityServiceInterface $capacityService
     * @param ColorServiceInterface $colorService
     * @param ModelServiceInterface $modelService
     * @param BrandServiceInterface $brandService
     * @param PhoneServiceInterface $phoneService
     * @param ClientServiceInterface $clientService
     */
    public function __construct(PhoneModelInterface $phoneModel, WarehouseServiceInterface $warehouseService, StockServiceInterface $stockService, StatusServiceInterface $statusService, SecurityServiceInterface $securityService, CapacityServiceInterface $capacityService, ColorServiceInterface $colorService, ModelServiceInterface $modelService, BrandServiceInterface $brandService, PhoneServiceInterface $phoneService, ClientServiceInterface $clientService)
    {
        $this->phoneModel = $phoneModel;
        $this->warehouseService = $warehouseService;
        $this->stockService = $stockService;
        $this->statusService = $statusService;
        $this->securityService = $securityService;
        $this->capacityService = $capacityService;
        $this->colorService = $colorService;
        $this->modelService = $modelService;
        $this->brandService = $brandService;
        $this->phoneService = $phoneService;
        $this->clientService = $clientService;
    }


    public function addStock(Request $request, User $user): bool
    {
        if($request){
            $warehouse = $this->warehouseService->getOneWarehouseById($request->request->get("warehouse"));
            $phone = $this->phoneModel->existPhone(
                $this->brandService->getOneBrandById($request->request->get("brandName")),
                $this->modelService->getOneModelById($request->request->get("modelName")),
                $this->colorService->getOneColorById($request->request->get("colorName")),
                $this->capacityService->getOneCapacityById($request->request->get("capacity"))
            );
            if($phone != null){
                if ($this->checkCapacity($warehouse, $request->request->get("amount")) === true){
                    $stock = new Stock();
                    $stock->setAmount($request->request->get("amount"));
                    $stock->setWarehouseID($warehouse);
                    $stock->setPhoneID($this->phoneService->getOnePhoneById($phone->getId()));
                    $stock->setDate(new \DateTime());
                    $stock->setPurchasePrice($request->request->get("purchase"));
                    $stock->setStatusID($this->statusService->getOneStatusByName("Megrendelve"));
                    $stock->setUserID($this->securityService->getOneUserById($user->getId()));
                    $stock->setClientID($this->clientService->getOneClientById($request->request->get("clientName")));
                    $this->stockService->addStock($stock);
                    return true;
                }
            }
        }
        return false;
    }

    public function filteredStock(Request $request):iterable{
        /** @var Stock[] $stocks */
        $stocks = $this->stockService->getAllStock();

        /** @var Phone[] $phones */
        $phones = $this->phoneModel->filteredPhones($request);

        /** @var Stock[] $array */
        $array = array();
        foreach($stocks as $stock){
            foreach($phones as $phone){
                if($stock->getPhoneID()->getId() === $phone->getId()){
                    array_push($array, $stock);
                }
            }
        }
        return $array;
    }

    public function edit(Request $request, int $stockId): bool{

        if($request){
            $stock = $this->stockService->getOneStockById($stockId);
            $warehouse = $this->warehouseService->getOneWarehouseById($request->request->get("updateWarehouse"));
            $phone = $this->phoneModel->updatePhone($request, $stock->getPhoneID()->getId());
            $amount = $stock->getAmount();
            if($this->checkCapacity($warehouse, $request->request->get("updateAmount"))){
                $stock->setClientID($this->clientService->getOneClientById($request->request->get("updateClient")));
                $stock->setPhoneID($phone);
                $stock->setWarehouseID($warehouse);
                $stock->setAmount($request->request->get("updateAmount"));
                $stock->setPurchasePrice($request->request->get("updatePrice"));
                $stock->setStatusID($this->statusService->getOneStatusById($request->request->get("updateStatus")));
                $stock->setDate(new \DateTime());
                $this->stockService->updateStock($stockId);
                $warehouse->setCapacity($warehouse->getCapacity() + $amount);
                $this->warehouseService->updateWarehouse($warehouse->getId());
                return true;
            }
        }
        return false;
    }

    public function allWarehouse():iterable{
        return $this->warehouseService->getAllWarehouse();
    }

    public function allArrivedStock():iterable{
        return $this->stockService->getAllStockByStatus("Beérkezett");
    }

    public function allOrderedStock():iterable{
        return $this->stockService->getAllStockByStatus("Megrendelve");
    }

    public function allStatus(): iterable
    {
        return $this->statusService->getAllStatus();
    }

    public function oneStockById(int $id):Stock{
        return $this->stockService->getOneStockById($id);
    }
    public function checkCapacity(Warehouse $warehouse, int $amount):bool{
        $capacity = $warehouse->getCapacity();
        if($capacity > 0){
            if($capacity > $amount){
                $diff = $capacity - $amount;
                $warehouse->setCapacity($diff);
                $this->warehouseService->updateWarehouse($warehouse->getId());
                return true;
            }
        }
        return false;

    }


}