<?php


namespace App\Controller;

use App\Model\Interfaces\PhoneModelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneController extends AbstractController
{
    /** @var PhoneModelInterface */
    private $phoneModel;

    /**
     * PhoneController constructor.
     * @param PhoneModelInterface $phoneModel
     */
    public function __construct(PhoneModelInterface $phoneModel)
    {
        $this->phoneModel = $phoneModel;
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