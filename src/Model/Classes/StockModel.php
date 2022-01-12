<?php


namespace App\Model\Classes;


use App\Entity\Phone;
use App\Entity\Status;
use App\Entity\Stock;
use App\Entity\Warehouse;
use App\Model\Interfaces\PhoneModelInterface;
use App\Model\Interfaces\StockModelInterface;
use App\Service\Interfaces\StatusServiceInterface;
use App\Service\Interfaces\StockServiceInterface;
use App\Service\Interfaces\WarehouseServiceInterface;
use phpDocumentor\Reflection\Types\Array_;
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


    /**
     * StockModel constructor.
     * @param PhoneModelInterface $phoneModel
     * @param WarehouseServiceInterface $warehouseService
     * @param StockServiceInterface $stockService
     * @param StatusServiceInterface $statusService
     */
    public function __construct(PhoneModelInterface $phoneModel, WarehouseServiceInterface $warehouseService, StockServiceInterface $stockService, StatusServiceInterface $statusService)
    {
        $this->phoneModel = $phoneModel;
        $this->warehouseService = $warehouseService;
        $this->stockService = $stockService;
        $this->statusService = $statusService;
    }

    public function listAllStock(Request $request): bool
    {
        // TODO: Implement listAllStock() method.
    }


    public function addStock(Request $request): bool
    {
        if($request){
            $warehouse = $this->warehouseService->getOneWarehouseById($request->request->get("warehouse"));
            $phone = $this->phoneModel->addPhone($request);
            if ($this->checkCapacity($warehouse, $request->request->get("amount")) === true){
                $stock = new Stock();
                $stock->setAmount($request->request->get("amount"));
                $stock->setWarehouseID($warehouse);
                $stock->setPhoneID($phone);
                $stock->setDate(new \DateTime());
                $stock->setPurchasePrice($request->request->get("purchase"));
                $stock->setStatusID($this->statusService->getOneStatusById(1));
                $this->stockService->addStock($stock);
                return true;
            }
        }
        return false;
    }

    public function editStock(Request $request): bool
    {
        // TODO: Implement editStock() method.
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


    public function removeStock(Request $request): bool
    {
        // TODO: Implement removeStock() method.
    }

    public function changeStatusBystockID(Request $request, int $stockId): bool
    {
        if($request){
            $status = $this->statusService->getOneStatusById($request->request->get("status"));
            $stock = $this->stockService->getOneStockById($stockId);
            $stock->setStatusID($status);
            $stock->setDate(new \DateTime());
            //Ha módosítja a behozott darabszámot, akkor diff számolás és újból levonás/hozzáadás a tárhelybe
            $this->stockService->updateStock($stockId);
            return true;
        }
        return false;
    }

    public function allWarehouse():iterable{
        return $this->warehouseService->getAllWarehouse();
    }
    public function allStock():iterable{
        return $this->stockService->getAllStock();
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