<?php


namespace App\Controller;



use App\Model\Interfaces\PhoneModelInterface;
use App\Model\Interfaces\StockModelInterface;
use App\Service\Classes\StatusService;
use App\Service\Interfaces\SecurityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController
{
    /** @var StockModelInterface */
    private $stockModel;

    /** @var SecurityServiceInterface */
    private $securityService;

    /** @var PhoneModelInterface */
    private $phoneModel;

    /** @var StatusService */
    private $statusService;

    /**
     * StockController constructor.
     * @param StockModelInterface $stockModel
     * @param SecurityServiceInterface $securityService
     * @param PhoneModelInterface $phoneModel
     * @param StatusService $statusService
     */
    public function __construct(StockModelInterface $stockModel, SecurityServiceInterface $securityService, PhoneModelInterface $phoneModel, StatusService $statusService)
    {
        $this->stockModel = $stockModel;
        $this->securityService = $securityService;
        $this->phoneModel = $phoneModel;
        $this->statusService = $statusService;
    }


    /**
     * @param Request $request
     * @return Response
     * @Route(name="addStock", path="/addStock")
     */
    public function addStock(Request $request):Response{
        if($request->isMethod("POST")){
            if($this->stockModel->addStock($request)=== true){
                return new Response("SIKERES0");
            }
            return new Response("nem sikerült");
        }
        return $this->render("Stock/addstock.html.twig", ["user" => $this->getUser()]);
    }

    /**
     * @param Request $request
     * @param int $stockId
     * @return Response
     * @Route(name="updateOrderedStock", path="/updateOrdered/{stockId}")
     */
    public function updateOrdered(Request $request, int $stockId): Response{
        if($request->isMethod("POST")){
            if($this->stockModel->changeStatusBystockID($request, $stockId) === true){
                return new Response("Sikeres módosítás");
            }
        }
        return $this->render("Stock/edit.html.twig", ["user" => $this->getUser(), "stock" => $this->stockModel->oneStockById($stockId)]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="orderedStock", path="/orderedStock")
     */
    public function orderedStock(Request $request):Response{
        if ($request->isMethod("POST")){
            return $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->filteredStock($request), "user" => $this->getUser()]);
        }else{
            return $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allStock(), "user" => $this->getUser()]);
        }
    }

    /**
     * @return Response
     * @Route(name="allWarehouse", path="/allWarehouse")
     */
    public function allWarehouse():Response{
        return new JsonResponse($this->stockModel->allWarehouse());
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allStock", path="/allStock")
     */
    public function allStock(Request $request):Response{
        if ($request->isMethod("POST")){
            return $this->render("Stock/allStock.html.twig",["stocks" => $this->stockModel->filteredStock($request), "user" => $this->getUser()]);
        }else{
            return $this->render("Stock/allStock.html.twig",["stocks" => $this->stockModel->allStock(), "user" => $this->getUser()]);
        }

    }

    /**
     * @return Response
     * @Route(name="allStatus", path="/allStatus")
     */
    public function allStatus():Response{
        $status = $this->stockModel->allStatus();
        return new JsonResponse($status);
    }


}