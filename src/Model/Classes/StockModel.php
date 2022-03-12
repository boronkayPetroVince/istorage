<?php


namespace App\Model\Classes;


use App\Entity\Order;
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
use App\Service\Interfaces\OrderServiceInterface;
use App\Service\Interfaces\PhoneServiceInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use App\Service\Interfaces\StatusServiceInterface;
use App\Service\Interfaces\StockServiceInterface;
use App\Service\Interfaces\WarehouseServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /** @var OrderServiceInterface */
    private $orderService;

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
     * @param OrderServiceInterface $orderService
     */
    public function __construct(PhoneModelInterface $phoneModel, WarehouseServiceInterface $warehouseService, StockServiceInterface $stockService, StatusServiceInterface $statusService, SecurityServiceInterface $securityService, CapacityServiceInterface $capacityService, ColorServiceInterface $colorService, ModelServiceInterface $modelService, BrandServiceInterface $brandService, PhoneServiceInterface $phoneService, ClientServiceInterface $clientService, OrderServiceInterface $orderService)
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
        $this->orderService = $orderService;
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

    public function sellStock(Request $request, User $user): iterable
    {
        //itt json visszatérés, és akkor átadom a számlának az adatokat(igy tudom kinyerni a rendelésnek az adatait)
        $orderNumber = "";
        for ($i = 0; $i < 10;$i++){
            $orderNumber .= "".rand(0,9);
        }
        $list = [];
        if ($request) {
            $allSellingData = $request->request->get("sellingTableData");
            $oneData = explode(";", "".$allSellingData);
            foreach ($oneData as $data) {
                $tempList = explode("|", $data);

                $stock = $this->stockService->getOneStockById((int)$tempList[0]);
                if($this->checkStockAmount($stock, $tempList[1])){
                    $order = new Order();
                    $order->setOrderNumber($orderNumber);
                    $order->setAmount($tempList[1]);
                    $order->setPrice($tempList[2]);
                    $order->setDate(new \DateTime('now'));
                    $order->setClientID($this->clientService->getOneClientById($request->request->get("clientName")));
                    $order->setUserID($this->securityService->getOneUserById($user->getId()));

                    $warehouse = $this->warehouseService->getOneWarehouseByName($tempList[3]);
                    $order->setWarehouseID($this->warehouseService->getOneWarehouseById($warehouse->getId()));

                    $phone = $this->phoneModel->existPhone(
                        $this->brandService->getOneBrandByName($tempList[4]),
                        $this->modelService->getOneModelByName($tempList[5]),
                        $this->colorService->getOneColorByName($tempList[6]),
                        $this->capacityService->getOneCapacityByMemory($tempList[7])
                    );
                    $order->setPhoneID($this->phoneService->getOnePhoneById($phone->getId()));
                    $status = $this->statusService->getOneStatusByName("Eladva");
                    $order->setStatusID($this->statusService->getOneStatusById($status->getId()));
                    $this->orderService->addOrder($order);
                    array_push($list,$order);
                }
            }//szarul tér vissza
            return $list;
        }
        return $list;
    }

    public function lastSoldStockData(Order $order, array $list):Response{
        array_push($list,$order);
        return new JsonResponse($list);
    }

    public function edit(Request $request, int $stockId, User $user): bool{
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
                $stock->setUserID($this->securityService->getOneUserById($user->getId()));
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
    public function warehouseById():Warehouse{
        return $this->warehouseService->getOneWarehouseById(1);
    }

    public function allArrivedStock():iterable{
        return $this->stockService->getAllStockByStatus("Beérkezett");
    }

    public function allOrderedStock():iterable{
        return $this->stockService->getAllStockByStatus("Megrendelve");
    }

    public function allSoldStock():iterable{
        return $this->orderService->getAllOrder();
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

    public function checkStockAmount(Stock $stock, int $amount):bool{
        $recentlyAmount = $stock->getAmount();
        if($recentlyAmount > 0){
            if($amount <= $recentlyAmount){
                $diff = $recentlyAmount - $amount;
                $stock->setAmount($diff);
                $this->stockService->updateStock($stock->getId());
                return true;
            }
        }
        return false;
    }

    public function stockCount():int{
        return $this->stockService->stockCount("Beérkezett");
    }
    public function monthOutgoing():int{
        return $this->stockService->currentMonthOutgoings();
    }
    public function monthIncoming():int{
        return $this->orderService->currentMonthIncomings();
    }
    public function allIncomingsPerMonths():iterable{
        return $this->orderService->allIncomingsPerMonth();
    }
    public function allOrderPerWeek():iterable{
        return $this->orderService->allOrderPerWeek();
    }
    public function allArrivedStockPerWeek():iterable{
        return $this->stockService->allArrivedStockPerWeek();
    }

    public function lastSell():iterable{
        $file = fopen("tesztt.txt", "w");
//        fwrite($file, print_r($this->orderService->lastSell(), true));
        return $this->orderService->lastSell();
    }


}