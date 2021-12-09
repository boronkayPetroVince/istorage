<?php


namespace App\Model\Classes;


use App\Entity\Stock;
use App\Model\Interfaces\PhoneModelInterface;
use App\Model\Interfaces\StockModelInterface;
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

    /**
     * StockModel constructor.
     * @param PhoneModelInterface $phoneModel
     * @param WarehouseServiceInterface $warehouseService
     * @param StockServiceInterface $stockService
     */
    public function __construct(PhoneModelInterface $phoneModel, WarehouseServiceInterface $warehouseService, StockServiceInterface $stockService)
    {
        $this->phoneModel = $phoneModel;
        $this->warehouseService = $warehouseService;
        $this->stockService = $stockService;
    }


    public function listAllStock(Request $request): bool
    {
        if($request){

        }
    }

    public function addStock(Request $request): bool
    {
        if($request){
            $stock = new Stock();
            $warehouse = $this->warehouseService->getOneWarehouseById($request->request->get("warehouse"));
            $phone = $this->phoneModel->addPhone($request); //phone id_val kell visszatérnie
            $stock->setWarehouseID($warehouse);
            $stock->setPhoneID($phone);
            $stock->setAmount($request->request->get("amount"));
            $stock->setPurchasePrice($request->request->get("purchase"));
            $stock->setStatus("Megrendelve");
            $this->stockService->addStock($stock);
            return true;
        }
        return false;
    }

    public function editStock(Request $request): bool
    {
        // TODO: Implement editStock() method.
    }

    public function removeStock(Request $request): bool
    {
        // TODO: Implement removeStock() method.
    }

    public function changeStatus(Request $request): bool
    {
        // TODO: Implement changeStatus() method.
    }

    public function allWarehouse():iterable{
        return $this->warehouseService->getAllWarehouse();
    }
    public function allStock():iterable{
        return $this->stockService->getAllStock();
    }

}