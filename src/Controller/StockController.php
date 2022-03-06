<?php


namespace App\Controller;



use App\Entity\Stock;
use App\Entity\User;
use App\Model\Interfaces\PhoneModelInterface;
use App\Model\Interfaces\StockModelInterface;
use App\Service\Classes\StatusService;
use App\Service\Interfaces\SecurityServiceInterface;
use App\Service\Interfaces\StockServiceInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use DragonBe\Vies\Vies;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

    /**
     * StockController constructor.
     * @param StockModelInterface $stockModel
     * @param SecurityServiceInterface $securityService
     * @param StockServiceInterface $stockService
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
        return $this->render("Stock/orderedStock.html.twig",["stocks" => $this->stockModel->allOrderedStock(), "user" => $this->getUser(),
            "resultMessage"=> "", "resultColor" => ""]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="allStock", path="/allStock")
     */
    public function allStock(Request $request):Response{
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
//        /** @var User $user */
//        $user = $this->getUser();
//        if($request->isMethod("POST")){
//            return new JsonResponse($this->stockModel->sellStock($request,$user));
//        }
        return $this->render("Stock/sellingStock.html.twig", [
            "stocks" => $this->stockModel->allArrivedStock(),
            "user" => $this->getUser(), "result" =>"",
            "wh" => $this->stockModel->warehouseById(),
            "soldStock" => ""

        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route(name="teszt", path="/teszt", methods={"post"})
     */
    public function tezst(Request $request):Response{

        return new JsonResponse($this->stockModel->sellStock($request,$this->getUser()));
    }

    /**
     * @return Response
     * @Route(name="allWarehouse", path="/allWarehouse")
     */
    public function allWarehouse():Response{
        return new JsonResponse($this->stockModel->allWarehouse());
    }

    /**
     * @return Response
     * @Route(name="allStatus", path="/allStatus")
     */
    public function allStatus():Response{
        $status = $this->stockModel->allStatus();
        return new JsonResponse($status);
    }

    /**
     * @Route(name="generateOrderedPDF", path="/generateOrderedPDF")
     */
    public function generateOrderedPDF(){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('Stock/orderedStockPDF.html.twig', ["stocks" => $this->stockService->getAllStock()]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ob_get_clean();
        $dompdf->stream("rendeltKeszlet.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route(name="generateOrderedExcel", path="/generateOrderedExcel")
     */
    public function generateOrderedExcel(){
        /** @var Stock[] $stocks */
        $stocks = $this->stockService->getAllStock();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Mennyiség');
        $sheet->setCellValue('B1', 'Beszerzési ár (Ft)');
        $sheet->setCellValue('C1', 'Eladási ár (Ft)');
        $sheet->setCellValue('D1', 'Telefon');
        $sheet->setCellValue('E1', 'Raktár');
        $sheet->setCellValue('F1', 'Státusz');
        $sheet->setCellValue('G1', 'Dátum');
        $sheet->setCellValue('H1', 'Felhasználó');
        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($stocks as $stock){
            if ($stock->getStatusID()->getStatus() == "Megrendelve"){
                $sellingPrice = $stock->getPurchasePrice() * 1.27;
                $sheet->setCellValue('A'.$counter, $stock->getAmount());
                $sheet->setCellValue('B'.$counter, $stock->getPurchasePrice());
                $sheet->setCellValue('C'.$counter, $sellingPrice);
                $sheet->setCellValue('D'.$counter, $stock->getPhoneID()->getBrandID()->getBrandName()." ".
                    $stock->getPhoneID()->getModelID()->getModelName()." ".$stock->getPhoneID()->getColorID()->getPhoneColor()." ".
                    $stock->getPhoneID()->getCapacityID()->getCapacity());
                $sheet->setCellValue('E'.$counter, $stock->getWarehouseID()->getWhName());
                $sheet->setCellValue('F'.$counter, $stock->getStatusID()->getStatus());
                $sheet->setCellValue('G'.$counter, $stock->getDate());
                $sheet->setCellValue('H'.$counter, $stock->getUserID()->getUsername()." (".$stock->getUserID()->getRoles()[0].")" );
                $counter++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $filename = "rendeltKeszlet";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        $writer->save('php://output');
        die();
    }

    /**
     * @Route(name="generateArrivedPDF", path="/generateArrivedPDF")
     */
    public function generateArrivedPDF(){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('Stock/arrivedStockPDF.html.twig', ["stocks" => $this->stockService->getAllStock()]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ob_get_clean();
        $dompdf->stream("keszlet.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route(name="generateArrivedExcel", path="/generateArrivedExcel")
     */
    public function generateArrivedExcel(){
        /** @var Stock[] $stocks */
        $stocks = $this->stockService->getAllStock();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Mennyiség');
        $sheet->setCellValue('B1', 'Beszerzési ár (Ft)');
        $sheet->setCellValue('C1', 'Eladási ár (Ft)');
        $sheet->setCellValue('D1', 'Telefon');
        $sheet->setCellValue('E1', 'Raktár');
        $sheet->setCellValue('F1', 'Státusz');
        $sheet->setCellValue('G1', 'Dátum');
        $sheet->setCellValue('H1', 'Felhasználó');
        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($stocks as $stock){
            if ($stock->getStatusID()->getStatus() == "Beérkezett"){
                $sellingPrice = $stock->getPurchasePrice() * 1.27;
                $sheet->setCellValue('A'.$counter, $stock->getAmount());
                $sheet->setCellValue('B'.$counter, $stock->getPurchasePrice());
                $sheet->setCellValue('C'.$counter, $sellingPrice);
                $sheet->setCellValue('D'.$counter, $stock->getPhoneID()->getBrandID()->getBrandName()." ".
                    $stock->getPhoneID()->getModelID()->getModelName()." ".$stock->getPhoneID()->getColorID()->getPhoneColor()." ".
                    $stock->getPhoneID()->getCapacityID()->getCapacity());
                $sheet->setCellValue('E'.$counter, $stock->getWarehouseID()->getWhName());
                $sheet->setCellValue('F'.$counter, $stock->getStatusID()->getStatus());
                $sheet->setCellValue('G'.$counter, $stock->getDate());
                $sheet->setCellValue('H'.$counter, $stock->getUserID()->getUsername()." (".$stock->getUserID()->getRoles()[0].")" );
                $counter++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $filename = "keszlet";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        $writer->save('php://output');
        die();
    }


}