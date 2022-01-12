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
     * @Route(name="updatePhone", path="/updatePhone")
     */
    public function updatePhone(Request $request): Response{
//        $this->denyAccessUnlessGranted("ROLE_ADMIN");
//        if($request->isMethod("POST")){
//            $selected = $this->phoneService->getAllPhoneByBrand($request->request->get("brands"));
//            $phone = $this->phoneService->getAllPhone();
//            return $this->render("phone/removePhone.html.twig", ["kivalasztott" => $selected, "phones"=>$this->phoneService->getAllPhone()]);
//
//        }else return $this->render("phone/removePhone.html.twig",["kivalasztott" => "", "phones"=>""]);
        return $this->render("phone/updatePhone.html.twig");
    }

    /**
     * @return Response
     * @Route(name="allBrand", path="/allBrand")
     */
    public function allBrand(): Response{
        return new JsonResponse($this->phoneModel->allBrands());
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



}