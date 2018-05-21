<?php

namespace backend\controllers;

use Yii;
use common\models\SearchProduct;
use common\models\SearchInvoice;
use mPDF;

class ReportsController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMonthlyStockReport()
    {
        $model = new SearchProduct();

        if( Yii::$app->request->post() ) {

            if( Yii::$app->request->post('date_start') <> "" && Yii::$app->request->post('date_end') <> "" ) {
                $time = date('H:i:s');
                echo $date_start = (Yii::$app->request->post('date_start'))? date('Y-m-d H:i:s', strtotime(Yii::$app->request->post('date_start') . ' ' . $time)) : date('Y-m-d H:i:s');
                echo $date_end = (Yii::$app->request->post('date_end'))? date('Y-m-d H:i:s', strtotime(Yii::$app->request->post('date_end') . ' ' . $time)) : date('Y-m-d H:i:s');

                $getMonthlyStock = $model->getMonthlyStockByDateRange($date_start,$date_end);
                $date_start = date('Y-m-d', strtotime(Yii::$app->request->post('date_start')));
                $date_end = date('Y-m-d', strtotime(Yii::$app->request->post('date_end')));

            } else {
                $getMonthlyStock = $model->getMonthlyStock();
                $date_start = '';
                $date_end = '';
            }

        }else{

            $getMonthlyStock = $model->getMonthlyStock();
            $date_start = '';
            $date_end = '';

        }

    	return $this->render('monthly-stock-report',[
                            'getMonthlyStock' => $getMonthlyStock,
                            'date_start' => $date_start,
                            'date_end' => $date_end,
                        ]);
    }

    // print monthly stock report
    public function actionPrintMonthlyStockReportExcel()
    {
        $model = new SearchProduct();

        if( Yii::$app->request->post('date_start') <> "" && Yii::$app->request->post('date_end') <> "" ) {
            $result = $model->getMonthlyStockByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
            $dateStart = date('M-d-Y',strtotime(Yii::$app->request->post('date_start')));
            $dateEnd = date('M-d-Y',strtotime(Yii::$app->request->post('date_end')));

        }else{
            $result = $model->getMonthlyStock();
            $dateStart = date('M-d-Y');
            $dateEnd = date('M-d-Y');

        }

        $objPHPExcel = new \PHPExcel();
        $styleHeadingArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ));

        $sheet=0;

        $objPHPExcel->setActiveSheetIndex($sheet);

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

            $objPHPExcel->getActiveSheet()->setTitle('xxx')
             ->setCellValue('A1', '#')
             ->setCellValue('B1', 'Supplier Name')
             ->setCellValue('C1', 'Product Name')
             ->setCellValue('D1', 'Quantity')
             ->setCellValue('E1', 'Cost Price')
             ->setCellValue('F1', 'Selling Price')
             ->setCellValue('G1', 'Date Imported');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);

         $row=2;

                foreach ($result as $result_row) {

                    $dateImported = date('m-d-Y', strtotime($result_row['datetime_imported']) );

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['supplier_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['quantity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'$'.$result_row['cost_price'].'.00');
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'$'.$result_row['selling_price'].'.00');
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$dateImported);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Monthly-Stock-Report.xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }

    public function actionMonthlySalesReport()
    {
    	$model = new SearchProduct();

        if( Yii::$app->request->post() ) {

            if( Yii::$app->request->post('date_start') <> "" && Yii::$app->request->post('date_end') <> "" ) {

                $getMonthlySalesCash = $model->getMonthlySalesCashReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
                $getMonthlySalesCreditCard = $model->getMonthlySalesCreditCardReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
                $getMonthlySalesNets = $model->getMonthlySalesNetsReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
                $getMonthlySalesDaysCredit = $model->getMonthlySalesDaysCreditReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));

                $date_start = Yii::$app->request->post('date_start');
                $date_end = Yii::$app->request->post('date_end');

            } else {

                $getMonthlySalesCash = $model->getMonthlySalesCash();
                $getMonthlySalesCreditCard = $model->getMonthlySalesCreditCard();
                $getMonthlySalesNets = $model->getMonthlySalesNets();
                $getMonthlySalesDaysCredit = $model->getMonthlySalesDaysCredit();

                $date_start = '';
                $date_end = '';
            }

        }else{

            $getMonthlySalesCash = $model->getMonthlySalesCash();
            $getMonthlySalesCreditCard = $model->getMonthlySalesCreditCard();
            $getMonthlySalesNets = $model->getMonthlySalesNets();
            $getMonthlySalesDaysCredit = $model->getMonthlySalesDaysCredit();

            $date_start = '';
            $date_end = '';

        }

        return $this->render('monthly-sales-report',[
                            'getMonthlySalesCash' => $getMonthlySalesCash,
                            'getMonthlySalesCreditCard' => $getMonthlySalesCreditCard,
                            'getMonthlySalesNets' => $getMonthlySalesNets,
                            'getMonthlySalesDaysCredit' => $getMonthlySalesDaysCredit,
                            'date_start' => $date_start,
                            'date_end' => $date_end,
                        ]);
    }

    // print monthly sales report
    public function actionPrintMonthlySalesReportExcel()
    {
        $model = new SearchProduct();

        if( Yii::$app->request->post('date_start') <> "" && Yii::$app->request->post('date_end') <> "" ) {

            $getMonthlySalesCash = $model->getMonthlySalesCashReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
            $getMonthlySalesCreditCard = $model->getMonthlySalesCreditCardReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
            $getMonthlySalesNets = $model->getMonthlySalesNetsReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));
            $getMonthlySalesDaysCredit = $model->getMonthlySalesDaysCreditReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));

            $dateStart = Yii::$app->request->post('date_start');
            $dateEnd = Yii::$app->request->post('date_end');

        }else{

            $getMonthlySalesCash = $model->getMonthlySalesCash();
            $getMonthlySalesCreditCard = $model->getMonthlySalesCreditCard();
            $getMonthlySalesNets = $model->getMonthlySalesNets();
            $getMonthlySalesDaysCredit = $model->getMonthlySalesDaysCredit();

            $dateStart = '';
            $dateEnd = '';

        }

        $objPHPExcel = new \PHPExcel();
        $styleHeadingArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ));

        $sheet=0;

        $objPHPExcel->setActiveSheetIndex($sheet);

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

            $objPHPExcel->getActiveSheet()->setTitle('xxx')
             ->setCellValue('A1', 'Invoice Number')
             ->setCellValue('B1', 'Customer Name')
             ->setCellValue('C1', 'Vehicle Number')
             ->setCellValue('D1', 'Net Total')
             ->setCellValue('E1', 'Interest')
             ->setCellValue('F1', 'Points Redeem')
             ->setCellValue('G1', 'Discount')
             ->setCellValue('H1', 'Cash Amount Paid')
             ->setCellValue('I1', 'Date Issue');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleHeadingArray);

         $row=2;

                foreach ($getMonthlySalesCash as $cashRow) {

                    $dateIssue = date('m-d-Y', strtotime($cashRow['date_issue']) );

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $cashRow['invoice_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $cashRow['customerName']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $cashRow['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $cashRow['net_with_interest']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $cashRow['interest']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $cashRow['points_redeem']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $cashRow['discount_amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $cashRow['amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$dateIssue);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

                foreach ($getMonthlySalesCreditCard as $ccRow) {

                    $dateIssue = date('m-d-Y', strtotime($ccRow['date_issue']) );

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $ccRow['invoice_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $ccRow['customerName']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $ccRow['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $ccRow['net_with_interest']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $ccRow['interest']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $ccRow['points_redeem']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $ccRow['discount_amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $ccRow['amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$dateIssue);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

                foreach ($getMonthlySalesNets as $netsRow) {

                    $dateIssue = date('m-d-Y', strtotime($netsRow['date_issue']) );

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $netsRow['invoice_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $netsRow['customerName']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $netsRow['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $netsRow['net_with_interest']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $netsRow['interest']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $netsRow['points_redeem']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $netsRow['discount_amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $netsRow['amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$dateIssue);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

                foreach ($getMonthlySalesDaysCredit as $dcRow) {

                    $dateIssue = date('m-d-Y', strtotime($dcRow['date_issue']) );

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $dcRow['invoice_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dcRow['customerName']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dcRow['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dcRow['net_with_interest']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dcRow['interest']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dcRow['points_redeem']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $dcRow['discount_amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $dcRow['amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$dateIssue);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Monthly-Sales-Report(".$dateStart."-TO-".$dateEnd.").xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }

    public function actionBestSellingProductReport()
    {
        $model = new SearchProduct();

        if( Yii::$app->request->post() ) {

            if( Yii::$app->request->post('date_start') <> "" && Yii::$app->request->post('date_end') <> "" ) {

                // $getBestSellingService = $model->getBestSellingServicesReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));

                $getBestSellingParts = $model->getBestSellingPartsReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));

                $date_start = Yii::$app->request->post('date_start');
                $date_end = Yii::$app->request->post('date_end');

            } else {

                // $getBestSellingService = $model->getBestSellingService();

                $getBestSellingParts = $model->getBestSellingParts();

                $date_start = '';
                $date_end = '';

            }

        }else{

            $getBestSellingParts = $model->getBestSellingParts();

            $date_start = '';
            $date_end = '';

        }

        return $this->render('best-selling-product-report',[
                            'getBestSellingParts' => $getBestSellingParts,
                            'date_start' => $date_start,
                            'date_end' => $date_end,
                        ]);
    }

    // print best selling product report
    public function actionPrintBestSellingProductReportExcel()
    {
        $model = new SearchProduct();

        if( Yii::$app->request->post('date_start') <> "" && Yii::$app->request->post('date_end') <> "" ) {

            // $result = $model->getBestSellingServicesReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));

            $result1 = $model->getBestSellingPartsReportByDateRange(Yii::$app->request->post('date_start'), Yii::$app->request->post('date_end'));

            $dateStart = date('M-d-Y',strtotime(Yii::$app->request->post('date_start')));
            $dateEnd = date('M-d-Y',strtotime(Yii::$app->request->post('date_end')));

        }else{
            // $result = $model->getBestSellingService();

            $result1 = $model->getBestSellingParts();

            $dateStart = date('M-d-Y');
            $dateEnd = date('M-d-Y');

        }

        $objPHPExcel = new \PHPExcel();
        $styleHeadingArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ));

        $sheet=0;

        $objPHPExcel->setActiveSheetIndex($sheet);

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

            $objPHPExcel->getActiveSheet()->setTitle('xxx')
             ->setCellValue('A1', 'Invoice Number')
             ->setCellValue('B1', 'Category')
             ->setCellValue('C1', 'Product Name')
             ->setCellValue('D1', 'Quantity')
             ->setCellValue('E1', 'Unit Price')
             ->setCellValue('F1', 'Line Total');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);

         $row=2;

                foreach ($result1 as $result_row1) {

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row1['invoice_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row1['category']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row1['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row1['quantity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'$'.$result_row1['selling_price'].'.00');
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'$'.$result_row1['subTotal'].'.00');

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Best-Selling-Product-Report(".$dateStart."-TO-".$dateEnd.").xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }

    public function actionCarplateReport(){ //edr
      $searchModel = new SearchInvoice();
      $dataProvider = $searchModel->carplateSearch(Yii::$app->request->queryParams);

      $session = Yii::$app->session;
      if (!$session->isActive) {
          $session->open();
      }
      $session['carplate'] = Yii::$app->request->queryParams;

      return $this->render('carplate-report',[
          'searchModel'=>$searchModel,
          'dataProvider'=>$dataProvider
      ]);
    //  die('carplate');
    }

    public function actionCarplatePdf(){ //edr
      $searchModel = new SearchInvoice(); 
      $dataProvider = $searchModel->carplateSearch(Yii::$app->session->get('carplate'));
      //   echo '<pre>';
    //  print_r($dataProvider->query->all());
     // echo '</pre>';
     // die();
      ini_set('max_execution_time', 180);
      ini_set("memory_limit", "512M");
      $mpdf = new mPDF('utf-8','A4-L');
      $mpdf->content = $this->renderPartial('carplate-pdf',[
          'searchModel'=>$searchModel,
          'dataProvider'=>$dataProvider
      ]);
      $mpdf->setFooter('{PAGENO}');
      $mpdf->WriteHTML($mpdf->content);
      $mpdf->Output('Carplate Report'.'.pdf','I');
      exit;
   
    }
}
