<?php


namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Model\Interfaces\StockModelInterface;
use App\Service\Interfaces\SecurityServiceInterface;
use App\Service\Interfaces\StockServiceInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
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

    /** @var StockServiceInterface */
    private $stockService;

    private $list = array();

    /**
     * StockController constructor.
     * @param StockModelInterface $stockModel
     * @param SecurityServiceInterface $securityService
     * @param StockServiceInterface $stockService
     * @param array $list
     */
    public function __construct(StockModelInterface $stockModel, SecurityServiceInterface $securityService, StockServiceInterface $stockService)
    {
        $this->stockModel = $stockModel;
        $this->securityService = $securityService;
        $this->stockService = $stockService;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="addStock", path="/addStock")
     */
    public function addStock(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        /** @var User $user */
        $user = $this->getUser();
        if($request->isMethod("POST")){
            if($this->stockModel->addStock($request, $user)=== true){
                return $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allOrderedStock(), "user" => $this->getUser(),
                    "resultMessage"=> "Sikeres hozzáadás!", "resultColor" => "success"]);
            }
            return $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allOrderedStock(), "user" => $this->getUser(),
                "resultMessage"=> "Sikertelen hozzáadás!", "resultColor" => "danger"]);
        }
        return $this->redirectToRoute('orderedStock');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="orderedStock", path="/orderedStock")
     */
    public function orderedStock(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allOrderedStock(), "user" => $this->getUser(),
            "resultMessage"=> "", "resultColor" => ""]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allStock", path="/allStock")
     */
    public function allStock(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return $this->render("Stock/allStock.html.twig",["stocks" => $this->stockModel->allArrivedStock(), "user" => $this->getUser(),
            "resultMessage"=> "", "resultColor" => "", "allElement" => ""]);
    }
    /**
     * @param Request $request
     * @param int $stockId
     * @return Response
     * @Route(name="updateOrderedStock", path="/updateOrdered/{stockId}")
     */
    public function updateOrdered(Request $request, int $stockId): Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        if($request->isMethod("POST")){
            if($this->stockModel->edit($request, $stockId,$this->getUser()) === true){
                return $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allOrderedStock(), "user" => $this->getUser(),
                    "resultMessage"=> "Sikeres módosítás", "resultColor" => "success", "allElement" => ""]);
            }else return $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allOrderedStock(), "user" => $this->getUser(),
                "resultMessage"=> "Sikertelen módosítás", "resultColor" => "danger", "allElement" =>""]);
        }
        return $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allOrderedStock(), "user" => $this->getUser(),
            "resultMessage"=> "", "resultColor" => "", "allElement" => ""]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="sellingStock", path="/sellingStock")
     */
    public function sellingStock(Request $request):Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        /** @var User $user */
        $user = $this->getUser();
        if($request->isMethod("POST")){
            /** @var Order[] $temp */
            $temp = $this->list;
            array_push($this->list,$this->stockModel->sellStock($request, $user));

            return $this->render("Stock/bill.html.twig", [
                "orderedPhones" => $this->stockModel->sellStock($request, $user),
                "user" =>$this->getUser()
            ]);
        }
        return $this->render("Stock/sellingStock.html.twig", [
            "stocks" => $this->stockModel->allArrivedStock(),
            "user" => $this->getUser(), "result" =>"",
            "wh" => $this->stockModel->warehouseById()
        ]);
    }

    /**
     * @return Response
     * @Route(name="allWarehouse", path="/allWarehouse")
     */
    public function allWarehouse():Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        return new JsonResponse($this->stockModel->allWarehouse());
    }

    /**
     * @return Response
     * @Route(name="allStatus", path="/allStatus")
     */
    public function allStatus():Response{
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $status = $this->stockModel->allStatus();
        return new JsonResponse($status);
    }

    /**
     * @param Request $request
     * @Route(name="billPDF", path="/billPDF")
     */
    public function generateBillPDF(Request $request){
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $html = $this->renderView('Stock/billPDF.html.twig', [
            "orderedPhones" => $this->stockModel->lastSell(),
            "user" =>$this->getUser()]);
        $this->stockModel->billPDF($html);
        $file = fopen("bill.txt","w" );
        fwrite($file, var_export($this->list));
    }

    /**
     * @Route(name="generateOrderedPDF", path="/generateOrderedPDF")
     */
    public function generateOrderedPDF(){
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $html = $this->renderView('Stock/orderedStockPDF.html.twig', ["stocks" => $this->stockModel->allOrderedStock()]);
        $this->stockModel->OrderedPDF($html);
    }

    /**
     * @Route(name="generateOrderedExcel", path="/generateOrderedExcel")
     */
    public function generateOrderedExcel(){
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $this->stockModel->OrderedExcel();
    }

    /**
     * @Route(name="generateArrivedPDF", path="/generateArrivedPDF")
     */
    public function generateArrivedPDF(){
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $html = $this->renderView('Stock/arrivedStockPDF.html.twig', ["stocks" => $this->stockModel->allArrivedStock()]);
        $this->stockModel->ArrivedPDF($html);
    }

    /**
     * @Route(name="generateArrivedExcel", path="/generateArrivedExcel")
     */
    public function generateArrivedExcel(){
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $this->stockModel->ArrivedExcel();
    }


}