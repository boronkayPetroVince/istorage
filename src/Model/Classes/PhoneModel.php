<?php


namespace App\Model\Classes;

use App\Entity\Brand;
use App\Entity\Capacity;
use App\Entity\Color;
use App\Entity\Model;
use App\Entity\Phone;
use App\Model\Interfaces\PhoneModelInterface;
use App\Service\Interfaces\BrandServiceInterface;
use App\Service\Interfaces\CapacityServiceInterface;
use App\Service\Interfaces\ColorServiceInterface;
use App\Service\Interfaces\ModelServiceInterface;
use App\Service\Interfaces\PhoneServiceInterface;
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

    /**
     * PhoneModel constructor.
     * @param ColorServiceInterface $colorService
     * @param ModelServiceInterface $modelService
     * @param BrandServiceInterface $brandService
     * @param PhoneServiceInterface $phoneService
     * @param CapacityServiceInterface $capacityService
     */
    public function __construct(ColorServiceInterface $colorService, ModelServiceInterface $modelService, BrandServiceInterface $brandService, PhoneServiceInterface $phoneService, CapacityServiceInterface $capacityService)
    {
        $this->colorService = $colorService;
        $this->modelService = $modelService;
        $this->brandService = $brandService;
        $this->phoneService = $phoneService;
        $this->capacityService = $capacityService;
    }

    public function addPhone(Request $request): Phone
    {
        $phone = new Phone();
        if($request){
            if($this->checkBrand(strtolower(trim($request->request->get("brandName")))) === false){
                $brand = new Brand();
                $brand->setBrandName(strtolower(trim($request->request->get("brandName"))));
                $this->brandService->addBrand($brand);
            }else{
                $brand = $this->brandService->getOneBrandByName(strtolower($request->request->get("brandName")));
            }

            if($this->checkModel(strtolower(trim($request->request->get("modelName")))) === false){
                $model = new Model();
                $model->setModelName(strtolower(trim($request->request->get("modelName"))));
                $this->modelService->addModel($model);
            }else{
                $model = $this->modelService->getOneModelByName(strtolower($request->request->get("modelName")));
            }

            if($this->checkColor(strtolower(trim($request->request->get("colorName")))) === false){
                $color = new Color();
                $color->setPhoneColor(strtolower(trim($request->request->get("colorName"))));
                $this->colorService->addColor($color);
            }else{
                $color = $this->colorService->getOneColorByName(strtolower($request->request->get("colorName")));
            }

            if($this->checkCapacity((int)$request->request->get("capacity")) === false){
                $capacity = new Capacity();
                $capacity->setCapacity((int)$request->request->get("capacity"));
                $this->capacityService->addCapacity($capacity);
            }else{
                $capacity = $this->capacityService->getOneCapacityByMemory((int)$request->request->get("capacity"));
            }
            $phone->setBrandID($this->brandService->getOneBrandById($brand->getId()));
            $phone->setModelID($this->modelService->getOneModelById($model->getId()));
            $phone->setColorID($this->colorService->getOneColorById($color->getId()));
            $phone->setCapacityID($this->capacityService->getOneCapacityById($capacity->getId()));
            $this->phoneService->addPhone($phone);
            return $phone;
        }
        return $phone;
    }

    public function existPhone(Brand $brand, Model $model, Color $color, Capacity $capacity):Phone{
        /** @var Phone $phone */
        $phone = null;
        /** @var Phone[] $existingPhones */
        $existingPhones = $this->phoneService->getAllPhone();
        foreach($existingPhones as $exphone){
            if($exphone->getBrandID()->getId() === $brand->getId() && $exphone->getModelID()->getId() === $model->getId()
                && $exphone->getColorID()->getId() === $color->getId() && $exphone->getCapacityID()->getId() === $capacity->getId()){
                $phone = $exphone;
                return $phone;
            }
        }
        return $phone;
    }

    public function updatePhone(Request $request, int $phoneID): Phone
    {
        $phone = $this->phoneService->getOnePhoneById($phoneID);
        $phone->setBrandID($this->brandService->getOneBrandById($request->request->get("updateBrand")));
        $phone->setModelID($this->modelService->getOneModelById($request->request->get("updateModel")));
        $phone->setColorID($this->colorService->getOneColorById($request->request->get("updateColor")));
        $phone->setCapacityID($this->capacityService->getOneCapacityById($request->request->get("updateCapacity")));
        $this->phoneService->updatePhone($phone->getId());
        return $phone;
    }

    public function getAllBrand():iterable{
        return $this->brandService->getAllBrand();
    }

    public function allModelByBrand(Request $request): iterable
    {
        return $this->phoneService->getAllPhoneByBrand($request->request->get("brandNameID"));
    }

    public function allColorByModel(Request $request): iterable
    {
        return $this->phoneService->getAllPhoneByModel($request->request->get("modelNameID"));
    }

    public function allCapacityByModel(Request $request): iterable{
        return $this->phoneService->getAllCapacityByModel($request->request->get("modelNameID"), $request->request->get("colorNameID"));
    }

    public function checkBrand(string $brandName):bool{
        /** @var Brand[] $brands */
        $brands = $this->brandService->getAllBrand();
        foreach($brands as $brand){
            if(strtolower($brand->getBrandName()) === strtolower($brandName)){
                return true;
            }
        }
        return false;
    }

    public function checkModel(string $modelName):bool{
        /** @var Model[] $models */
        $models = $this->modelService->getAllModel();
        foreach($models as $model){
            if(strtolower($model->getModelName()) === strtolower($modelName)){
                return true;
            }
        }
        return false;
    }

    public function checkColor(string $colorName):bool{
        /** @var Color[] $colors */
        $colors = $this->colorService->getAllColor();
        foreach($colors as $color){
            if(strtolower($color->getPhoneColor()) === strtolower($colorName)){
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