<?php


namespace App\Model\Classes;


use App\Entity\Brand;
use App\Entity\Capacity;
use App\Entity\Color;
use App\Entity\Model;
use App\Entity\Phone;
use App\Entity\Stock;
use App\Model\Interfaces\PhoneModelInterface;
use App\Service\Interfaces\BrandServiceInterface;
use App\Service\Interfaces\CapacityServiceInterface;
use App\Service\Interfaces\ColorServiceInterface;
use App\Service\Interfaces\ModelServiceInterface;
use App\Service\Interfaces\PhoneServiceInterface;
use App\Service\Interfaces\StockServiceInterface;
use Symfony\Component\HttpFoundation\Request;

class PhoneModel implements PhoneModelInterface
{
    /** @var ColorServiceInterface */
    private $colorService;

    /** @var ModelServiceInterface */
    private $modelService;

    /** @var BrandServiceInterface */
    private $brandService;

    /** @var PhoneServiceInterface */
    private $phoneService;

    /** @var CapacityServiceInterface */
    private $capacityService;

    /** @var StockServiceInterface */
    private $stockService;

    /**
     * PhoneModel constructor.
     * @param ColorServiceInterface $colorService
     * @param ModelServiceInterface $modelService
     * @param BrandServiceInterface $brandService
     * @param PhoneServiceInterface $phoneService
     * @param CapacityServiceInterface $capacityService
     * @param StockServiceInterface $stockService
     */
    public function __construct(ColorServiceInterface $colorService, ModelServiceInterface $modelService, BrandServiceInterface $brandService, PhoneServiceInterface $phoneService, CapacityServiceInterface $capacityService, StockServiceInterface $stockService)
    {
        $this->colorService = $colorService;
        $this->modelService = $modelService;
        $this->brandService = $brandService;
        $this->phoneService = $phoneService;
        $this->capacityService = $capacityService;
        $this->stockService = $stockService;
    }


    public function addPhone(Request $request): Phone
    {
            if($this->checkBrand(strtolower($request->request->get("brandName"))) === false){
                $brand = new Brand();
                $brand->setBrandName(strtolower($request->request->get("brandName")));
                $this->brandService->addBrand($brand);
            }else{
                $brand = $this->brandService->getOneBrandByName(strtolower($request->request->get("brandName")));
            }

            if($this->checkModel(strtolower($request->request->get("modelName"))) === false){
                $model = new Model();
                $model->setModelName(strtolower($request->request->get("modelName")));
                $this->modelService->addModel($model);
            }else{
                $model = $this->modelService->getOneModelByName(strtolower($request->request->get("modelName")));
            }

            if($this->checkColor(strtolower($request->request->get("colorName"))) === false){
                $color = new Color();
                $color->setPhoneColor($request->request->get("colorName"));
                $this->colorService->addColor($color);
            }else{
                $color = $this->colorService->getOneColorByName(strtolower($request->request->get("colorName")));
            }

            if($this->checkCapacity($request->request->get("capacity")) === false){
                $capacity = new Capacity();
                $capacity->setCapacity($request->request->get("capacity"));
                $this->capacityService->addCapacity($capacity);
            }else{
                $capacity = $this->capacityService->getOneCapacityByMemory($request->request->get("capacity"));
            }

            $phone = new Phone();
            $phone->setBrandID($this->brandService->getOneBrandById($brand->getId()));
            $phone->setModelID($this->modelService->getOneModelById($model->getId()));
            $phone->setColorID($this->colorService->getOneColorById($color->getId()));
            $phone->setCapacityID($this->capacityService->getOneCapacityById($capacity->getId()));
            $this->phoneService->addPhone($phone);
            if ($this->checkPhone($phone) === true){
                return $this->phoneService->removePhone($phone->getId());
            }
            return $phone;

    }

    public function checkPhone(Phone $phone):bool{
        /** @var Phone[] $existingPhones */
        $existingPhones = $this->phoneService->getAllPhone();
        foreach($existingPhones as $exphone){
            if($exphone->getBrandID()->getId() === $phone->getBrandID()->getId() && $exphone->getModelID()->getId() === $phone->getModelID()->getId()
            && $exphone->getColorID()->getId() === $phone->getColorID()->getId() && $exphone->getCapacityID()->getId() === $phone->getCapacityID()->getId()){
                $this->phoneService->removePhone($phone->getId());
                return true;
            }
        }
        return false;

    }

    public function updatePhone(Request $request): bool
    {

    }

    public function allPhones(): iterable
    {
        // TODO: Implement allPhones() method.
    }


    public function allOrderedBrand(): iterable
    {
        return $this->stockService->getAllBrandByStatus(1); // dinamikussá tevés
    }
    public function allOrderedModel(Request $request): iterable
    {
        return $this->stockService->getAllModelByStatusAndBrand(1,$request->request->get("brandID"));
    }

    public function allOrderedColor(Request $request): iterable
    {
        return $this->stockService->getAllColorByStatusAndModel(1,$request->request->get("modelID"));
    }

    public function allOrderedCapacity(Request $request): iterable
    {
        return $this->stockService->getAllCapacityByStatusAndColor(1,$request->request->get("colorID"));
    }

    public function allArrivedBrand(): iterable
    {
        return $this->stockService->getAllBrandByStatus(3); // dinamikussá tevés
    }
    public function allArrivedModel(Request $request): iterable
    {
        return $this->stockService->getAllModelByStatusAndBrand(3,$request->request->get("brandID"));
    }


    public function allArrivedColor(Request $request): iterable
    {
        return $this->stockService->getAllColorByStatusAndModel(3,$request->request->get("modelID"));
    }

    public function allArrivedCapacity(Request $request): iterable
    {
        return $this->stockService->getAllCapacityByStatusAndColor(3,$request->request->get("colorID"));
    }


    public function allModelByBrand(Request $request): iterable
    {
        return $this->phoneService->getAllPhoneByBrand($request->request->get("brandID"));
    }

    public function allColorByModel(Request $request): iterable
    {
        return $this->phoneService->getAllPhoneByModel($request->request->get("modelID"));
    }

    public function allCapacityByColor(Request $request): iterable{
        return $this->phoneService->getAllPhoneByColor($request->request->get("colorID"));
    }

    public function filteredPhones(Request $request): iterable
    {
        if($request){
            $brand = $this->brandService->getOneBrandById($request->request->get("brands"));
            $model = $this->modelService->getOneModelById($request->request->get("models"));
            $color = $this->colorService->getOneColorById($request->request->get("colors"));
            $capacity = $this->capacityService->getOneCapacityById($request->request->get("capacities"));
            return $this->phoneService->getAllFilteredPhone($brand->getId(),$model->getId(),$color->getId(),$capacity->getId());
        }
    }

    public function checkBrand(string $brandName):bool{
        /** @var Brand[] $brands */
        $brands = $this->brandService->getAllBrand();
        foreach($brands as $brand){
            if($brand->getBrandName() === $brandName){
                return true;
            }
        }
        return false;
    }

    public function checkModel(string $modelName):bool{
        /** @var Model[] $models */
        $models = $this->modelService->getAllModel();
        foreach($models as $model){
            if($model->getModelName() === $modelName){
                return true;
            }
        }
        return false;
    }

    public function checkColor(string $colorName):bool{
        /** @var Color[] $colors */
        $colors = $this->colorService->getAllColor();
        foreach($colors as $color){
            if($color->getPhoneColor() === $colorName){
                return true;
            }
        }
        return false;
    }

    public function checkCapacity(int $capacity):bool{
        /** @var Capacity[] $capacities */
        $capacities = $this->capacityService->getAllCapacity();
        foreach($capacities as $cap){
            if($cap->getCapacity() === $capacity){
                return true;
            }
        }
        return false;
    }


}