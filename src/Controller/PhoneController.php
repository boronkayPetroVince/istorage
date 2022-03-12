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
     * @Route(name="addPhone", path="/addPhone", methods={"post"})
     */
    public function addPhone(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return new JsonResponse($this->phoneModel->addPhone($request));
    }

    /**
     * @param Request $request
     * @param int $phoneID
     * @return Response
     * @Route(name="updatePhone", path="/updatePhone/{phoneID}")
     */
    //Egy készülékek menüpont, ahol a hozzáadott telefonokat kiirja a tipusokkal együtt, csak azokat amiknek nincsen foreign key semelyik táblájukhoz, csak törölni tudja!!!
    public function updatePhone(Request $request, int $phoneID): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if($this->phoneModel->updatePhone($request,$phoneID)){
            $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allStock(), "user" => $this->getUser(),
                "resultMessage"=> "", "resultColor" => ""]);
        }

    }
    /**
     * @return Response
     * @Route(name="allBrands", path="/allBrands")
     */
    public function allBrands(): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return new JsonResponse($this->phoneModel->getAllBrand());
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allModelByBrand", path="/allModelByBrand")
     */
    public function allModelByBrand(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return new JsonResponse($this->phoneModel->allModelByBrand($request));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allColorByModel", path="/allColorByModel")
     */
    public function allColorByModel(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return new JsonResponse($this->phoneModel->allColorByModel($request));
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allCapacityByModel", path="/allCapacityByModel")
     */
    public function allCapacityByModel(Request $request): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return new JsonResponse($this->phoneModel->allCapacityByModel($request));
    }
}