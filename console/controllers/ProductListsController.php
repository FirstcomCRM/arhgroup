<?php
 
namespace console\controllers;

use Yii;

use yii\console\Controller;
use common\models\Product;
use common\models\ProductNotificationRecipient;
use common\models\SearchProduct;

/**
 * Test controller
 */
class ProductListsController extends Controller {
 
    public function actionLowStock(){

        $productModel = new SearchProduct();
        $result = $productModel->getLowStock();
        
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
             ->setCellValue('A1', 'Product Code')
             ->setCellValue('B1', 'Product Name')
             ->setCellValue('C1', 'Unit of Measure');
             
             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);

         $row=2;
                                
                foreach ($result as $result_row) {  

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['product_code']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['unit_of_measure']);
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
        
        $name = 'console/controllers/product-list/xyz.xls';
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($name);      

        $message = Yii::$app->mailer->compose('layouts/product-notification')
                ->setFrom('jcyanga412060@gmail.com')
                ->setTo('jcyanga28@yahoo.com')
                ->setSubject('ARH Group Pte Ltd. - Low Stock Product Lists')
                ->attach('console/controllers/product-list/xyz.xls')
                ->send();
    }
 
}