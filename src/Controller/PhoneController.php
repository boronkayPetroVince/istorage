<?php


namespace App\Controller;


use App\Model\Interfaces\PhoneModelInterface;
use App\Service\Interfaces\BrandServiceInterface;
use App\Service\Interfaces\CapacityServiceInterface;
use App\Service\Interfaces\ColorServiceInterface;
use App\Service\Interfaces\ModelServiceInterface;
use App\Service\Interfaces\PhoneServiceInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Routing\Annotation\Route;

class PhoneController extends AbstractController
{
    /** @var PhoneModelInterface */
    private $phoneModel;

    /** @var SecurityServiceInterface */
    private $securityService;

    /** @var PhoneServiceInterface */
    private $phoneService;

    /** @var BrandServiceInterface */
    private $brandService;

    /** @var ModelServiceInterface */
    private $modelService;

    /** @var ColorServiceInterface */
    private $colorService;

    /** @var CapacityServiceInterface */
    private $capacityService;

    /**
     * PhoneController constructor.
     * @param PhoneModelInterface $phoneModel
     * @param SecurityServiceInterface $securityService
     * @param PhoneServiceInterface $phoneService
     * @param BrandServiceInterface $brandService
     * @param ModelServiceInterface $modelService
     * @param ColorServiceInterface $colorService
     * @param CapacityServiceInterface $capacityService
     */
    public function __construct(PhoneModelInterface $phoneModel, SecurityServiceInterface $securityService, PhoneServiceInterface $phoneService, BrandServiceInterface $brandService, ModelServiceInterface $modelService, ColorServiceInterface $colorService, CapacityServiceInterface $capacityService)
    {
        $this->phoneModel = $phoneModel;
        $this->securityService = $securityService;
        $this->phoneService = $phoneService;
        $this->brandService = $brandService;
        $this->modelService = $modelService;
        $this->colorService = $colorService;
        $this->capacityService = $capacityService;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="addPhone", path="/addPhone")
     */
    public function addPhone(Request $request): Response{
        if($request->isMethod("POST")){
            if($this->phoneModel->addPhone($request)){
                return $this->render("Phone/addPhone.html.twig", ["resultMessage"=> "Sikeresen hozzáadtál egy új eszközt! 
            Innentől kezdve mikor rendelnél, hozzáadnál, illetve módosítanál, akkor ez a tipusú telefon is megfog jelenni a választási lehetőségekben! ",
                    "resultColor" => "success", "user" =>$this->getUser()]);
            }
        }
        return $this->render("Phone/addPhone.html.twig", ["resultMessage"=> "", "resultColor" => "", "user" =>$this->getUser()]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="updatePhone", path="/updatePhone")
     */
    public function updatePhone(Request $request): Response{
        $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allStock(), "user" => $this->getUser(),
            "resultMessage"=> "", "resultColor" => "",
            "addResultColor"=>"success", "addResultMessage" => "Sikeresen hozzáadtad a telefont!" ]);
    }

    /**
     * @return Response
     * @Route(name="allBrands", path="/allBrands")
     */
    public function allBrands(): Response{
        return new JsonResponse($this->phoneModel->getAllBrand());
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allModelByBrand", path="/allModelByBrand")
     */
    public function allModelByBrand(Request $request): Response{
        return new JsonResponse($this->phoneModel->allModelByBrand($request));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allColorByModel", path="/allColorByModel")
     */
    public function allColorByModel(Request $request): Response{
        return new JsonResponse($this->phoneModel->allColorByModel($request));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allCapacityByColor", path="/allCapacityByColor")
     */
    public function allCapacityByColor(Request $request): Response{
        return new JsonResponse($this->phoneModel->allCapacityByColor($request));
    }


    /**
     * @return Response
     * @Route(name="allArrivedBrand", path="/allArrivedBrand")
     */
    public function ArrivedBrands(): Response{
        return new JsonResponse($this->phoneModel->allArrivedBrand());
    }
    /**
     * @param Request $request
     * @return Response
     * @Route(name="allArrivedModel", path="/allArrivedModel")
     */
    public function allArrivedPhoneModelByBrand(Request $request): Response{
        return new JsonResponse($this->phoneModel->allArrivedModel($request));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allArrivedColor", path="/allArrivedColor")
     */
    public function allArrivedPhoneColorByModel(Request $request): Response{
        return new JsonResponse($this->phoneModel->allArrivedColor($request));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allArrivedCapacityByColor", path="/allArrivedCapacity")
     */
    public function allArrivedPhoneCapacityByColor(Request $request): Response{
        return new JsonResponse($this->phoneModel->allArrivedCapacity($request));
    }

    /**
     * @return Response
     * @Route(name="allOrderedBrand", path="/allOrderedBrand")
     */
    public function OrderedBrands(): Response{
        return new JsonResponse($this->phoneModel->allOrderedBrand());
    }
    /**
     * @param Request $request
     * @return Response
     * @Route(name="allOrderedModel", path="/allOrderedModel")
     */
    public function allOrderedPhoneModelByBrand(Request $request): Response{
        return new JsonResponse($this->phoneModel->allOrderedModel($request));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allOrderedColor", path="/allOrderedColor")
     */
    public function allOrderedPhoneColorByModel(Request $request): Response{
        return new JsonResponse($this->phoneModel->allOrderedColor($request));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allOrderedCapacity", path="/allOrderedCapacity")
     */
    public function allAOrderedPhoneCapacityByColor(Request $request): Response{
        return new JsonResponse($this->phoneModel->allOrderedCapacity($request));
    }



}