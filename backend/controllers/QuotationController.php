<?php

namespace backend\controllers;

use Yii;
use common\models\Quotation;
use common\models\SearchQuotation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Branch;
use common\models\User;
use common\models\Customer;
use common\models\CarInformation;
use common\models\SearchCustomer;
use common\models\Category;
use common\models\QuotationDetail;
use common\models\SearchInvoice;
use common\models\Inventory;
use common\models\SearchInventory;
use common\models\Invoice;
use common\models\InvoiceDetail;
use common\models\Product;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Quotation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = array();

        if(isset(Yii::$app->request->queryParams['SearchQuotation']['date_from']))
            $params = Yii::$app->request->queryParams['SearchQuotation'];

        $searchModel = new SearchQuotation();
        $dataProvider = $searchModel->search($params);
        $branches = Branch::dataBranch();
        $staff = User::dataUser();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'params' => $params,
            'branches' => $branches,
            'staff' => $staff,
        ]);
    }

    /**
     * Displays a single Quotation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new Quotation();
        $searchModel = new SearchQuotation();

        $getQuotation = $searchModel->getProcessedQuotation($id); 
        $getProcessedServices = $searchModel->getProcessedServices($id); 
        $getProcessedParts = $searchModel->getProcessedParts($id);
        $quotationDetail = QuotationDetail::getQuotationDetailByID($id);

        return $this->render('view',[
                        'model' => $this->findModel($id),
                        'customerInfo' => $getQuotation,
                        'services' => $getProcessedServices,
                        'parts' => $getProcessedParts, 
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => '',
                        'quotationDetail'=>$quotationDetail
                    ]);
    }

    /**
     * Creates a new Quotation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Quotation();
        $branch = Branch::getBranchWithKeyId();
        $user = User::dataUser();
        $customer = CarInformation::dataCarInformation();
        $quotationLastId = $this->_getQuotationId();
        $category = Category::dataCategory();

        if ($postData = Yii::$app->request->post()) {
            $postData = Yii::$app->request->post();

            // echo "<pre>";
            // var_dump($postData);
            // exit;
            $message = "";
            $message = $this->validateQuotation($postData);

            if($message!='')
                return json_encode(array('status'=>'failed', 'message'=>$message, 'redirect'=>''));

            $quotation_id = Quotation::saveQuotation($postData);

            Yii::$app->getSession()->setFlash('success', 'Your record was successfully added in the database.');
            return json_encode(array('status'=>'success', 'message'=>'Your record was successfully added in the database.', 'redirect'=>'?r=quotation/view&id='.$quotation_id));

        } else {
            return $this->render('create', [
                'model' => $model,
                'quotationId' => $quotationLastId,
                'branch' => $branch,
                'user' => $user,
                'customer' => $customer,
                'category' =>$category,
            ]);
        }
    }

    /**
     * Updates an existing Quotation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $branch = Branch::getBranchWithKeyId();
        $user = User::dataUser();
        $customer = CarInformation::dataCarInformation();
        $quotationLastId = $this->_getQuotationId();
        $category = Category::dataCategory();
        $quotationDetail = QuotationDetail::getQuotationDetailByID($id);

        // echo "<pre>";
        // var_dump($model);
        // exit;
        if ($postData = Yii::$app->request->post()) {

            $message = "";
            $message = $this->validateQuotation($postData);

            if($message!='')
                return json_encode(array('status'=>'failed', 'message'=>$message, 'redirect'=>''));

            Quotation::updateQuotation($id, $postData);

            Yii::$app->getSession()->setFlash('success', 'Your record was successfully updated in the database.');

            return json_encode(array('status'=>'success', 'message'=>'Your record was successfully updated in the database.', 'redirect'=>'?r=quotation/view&id='.$id));
        } else {
            return $this->render('update', [
                'model' => $model,
                'branch' => $branch,
                'user' => $user,
                'customer' => $customer,
                'category' =>$category,
                'quotation_detail' => $quotationDetail,
            ]);
        }
    }

    /**
     * Deletes an existing Quotation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        Yii::$app->db->createCommand()
            ->update('quotation', ['delete' => 1], "id = $id")
            ->execute();

        Yii::$app->db->createCommand()
            ->delete('quotation_detail', "quotation_id = $id" )
            ->execute();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Quotation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quotation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quotation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function _getQuotationId() 
    {
        $searchModel = new SearchQuotation();
        $result = $searchModel->getQuotationId();

        return $result;
    }

    public function actionGetCustomerInformation()
    {
        $searchModel = new SearchCustomer();

        $getCustId = CarInformation::findOne(Yii::$app->request->get('car_id'));
        $getCustInfo = $searchModel->getCustomerListById($getCustId['customer_id']);

        $data = array();
        $data['fullname'] = $getCustInfo['fullname'];
        $data['nric'] = $getCustInfo['nric'];
        $data['company_name'] = $getCustInfo['company_name'];
        $data['uen_no'] = $getCustInfo['uen_no'];
        $data['address'] = $getCustInfo['address'];
        $data['hanphone_no'] = $getCustInfo['hanphone_no'];
        $data['office_no'] = $getCustInfo['office_no'];
        $data['email'] = $getCustInfo['email'];
        $data['remarks'] = $getCustInfo['remarks'];
        $data['type'] = $getCustInfo['type'];
        $data['name'] = $getCustInfo['name'];

        $getCarInfo = CarInformation::find()->where(['id' => Yii::$app->request->get('car_id') ])->one();
        $carInfo = array();
        $carInfo['carplate'] = $getCarInfo['carplate'];
        $carInfo['make'] = $getCarInfo['make'];
        $carInfo['model'] = $getCarInfo['model'];
        $carInfo['engine_no'] = $getCarInfo['engine_no'];
        $carInfo['year_mfg'] = $getCarInfo['year_mfg'];
        $carInfo['chasis'] = $getCarInfo['chasis'];
        $carInfo['points'] = $getCarInfo['points'];

        return json_encode(['customer_information' => $data, 'car_information' => $carInfo ]);
    }

    public function actionExportExcel() 
    {
        $model = new SearchQuotation();
        $result = $model->getQuotation();

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
             ->setCellValue('B1', 'Date Issue')
             ->setCellValue('C1', 'Jobsheet No.')
             ->setCellValue('D1', 'Branch Name')
             ->setCellValue('E1', 'Customer Name')
             ->setCellValue('F1', 'Car Plate')
             ->setCellValue('G1', 'Sales Person');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);

         $row=2;
                                
                foreach ($result as $result_row) {  
                    $dateIssue = date('m-d-Y', strtotime($result_row['date_issue']) );           
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dateIssue);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['quotation_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['fullname']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['salesPerson']);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "JobSheetList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }
    

    public function actionPartsByCategory()
    {
        $searchModel = new SearchQuotation();
        $result = $searchModel->getPartsByCategory(Yii::$app->request->get('partsCategory'));

        $data = array();
        foreach($result as $rowP)
        {
           $products = array(
                    'id' => $rowP['id'],
                    'supplier_name' => $rowP['supplier_name'],
                    'product_name' => $rowP['product_name'], 
                    'selling_price' => $rowP['selling_price'], 
                    'quantity' =>  $rowP['quantity'], 
                );
            
            $data[] = $products;    
        }
        

        return json_encode($data);
    }

    public function actionInsertPartsInItemList() 
    {
        $searchModel = new SearchProduct();
        $getParts = $searchModel->getProductListById(Yii::$app->request->post('services_parts'));

        $this->layout = false;

        if( Yii::$app->request->post() ) {

            return $this->render('parts-in-item-list', [
                'getParts' => $getParts,
                'partsCtr' => Yii::$app->request->post('partsCtr')
            ]);

        }
    }

    public static function validateQuotation($postData){
        $quotation = $postData['Quotation'];
        $message = "";

        if($quotation['branch_id']=='0' || $quotation['branch_id']=='')
            $message = "Please select a branch";
        else if($quotation['user_id']=='0' || $quotation['user_id']=='')
            $message = "Please select a sales person";
        else if($quotation['customer_id']=='0' || $quotation['customer_id']=='')
            $message = "Please select a car plate";
        else if(!isset($postData['service_part_id']) || count($postData['service_part_id'])==0 )
            $message = "Please add in at least one item for Product or Service";

        return $message;
    }

    public function actionDeleteColumn($id)
    {
        $searchModel = new SearchQuotation();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $branches = Branch::dataBranch();
        $staff = User::dataUser();

        Yii::$app->db->createCommand()
            ->update('quotation', ['delete' => 1], "id = $id")
            ->execute();

        Yii::$app->db->createCommand()
            ->delete('quotation_detail', "quotation_id = $id" )
            ->execute();

        $getQuotation = $searchModel->getQuotation();

        return $this->render('index', [
                        'searchModel' => $searchModel, 
                        'getQuotation' => $getQuotation,
                        'dataProvider' => $dataProvider, 
                        'params' => array(),
                        'branches' => $branches,
                        'staff' => $staff,
                        'date_start' => '',
                        'date_end' => '',
                        'customerName' => '',
                        'vehicleNumber' => '',
                        'errTypeHeader' => 'Success!', 
                        'errType' => 'alert alert-success', 
                        'msg' => 'Your record was successfully deleted in the database.'
                    ]);
    }

    public function actionInsertInvoice($id) 
    {
        $model = new Quotation();
        $details = new QuotationDetail();
        $searchInvoice = new SearchInvoice();
        $searchModel = new SearchQuotation();

        $getQuotation = $searchModel->getProcessedQuotationbyId($id);
        $quotationDetail = QuotationDetail::getQuotationDetailByID($id);
        $getLastId = $searchModel->getLastId($id);

       /* echo "<pre>";
        print_r($getQuotation['quotation_code']);
        exit;*/
        $getInvoice = Invoice::find()->where(['quotation_code' => $getQuotation['quotation_code'] ])->one();
     
        if( empty($getInvoice) ) {
            $invoice = new Invoice();

            $invoice->gst = $getQuotation['gst'];
            $invoice->net = $getQuotation['net'];
            $invoice->balance_amount = $invoice->net;
            
            $invoice->discount_amount = $getQuotation['discount_amount'];
            $invoice->grand_total = $getQuotation['grand_total'];

            $invoice->quotation_code = $getQuotation['quotation_code'];
            
            $invoice->user_id = Yii::$app->user->identity->id;
            $invoice->customer_id = $getQuotation['customer_id'];
            $invoice->branch_id = $getQuotation['branch_id'];
            $invoice->date_issue = $getQuotation['date_issue'];
            $invoice->remarks = $getQuotation['remarks'];
            $invoice->mileage = $getQuotation['mileage'];
            $invoice->come_in = $getQuotation['come_in'];
            $invoice->come_out = $getQuotation['come_out'];
            $invoice->created_at = $getQuotation['created_at'];
            $invoice->time_created = $getQuotation['time_created'];
            $invoice->discount_remarks = $getQuotation['discount_remarks'];
            $invoice->created_by = $getQuotation['created_by'];
            $invoice->updated_at = $getQuotation['updated_at'];
            $invoice->updated_by = $getQuotation['updated_by'];
            $invoice->delete = $getQuotation['delete'];
            $invoice->task = $getQuotation['task'];
            $invoice->paid = 0;
            $invoice->paid_type = 0;
            $invoice->status = 0;
            $invoice->payment_status = 'Unpaid';

            $yrNow = date('Y');
            $monthNow = date('m');
            $getInvoiceId = $searchInvoice->getInvoiceId();

            $invoiceNo ='INV' . $yrNow  . $monthNow . sprintf('%003d', $getInvoiceId);
            $invoice->invoice_no = $invoiceNo;

            $invoice->save();
            $invoiceId = $invoice->id;

            foreach($quotationDetail as $key=>$item)
            {
                $invDetails = new InvoiceDetail();

                $invDetails->invoice_id = $invoiceId;
                $invDetails->service_part_id = $item['service_part_id'];
                $invDetails->quantity = $item['quantity'];
                $invDetails->selling_price = $item['selling_price'];
                $invDetails->subTotal = $item['subTotal'];
                $invDetails->created_at = $item['created_at'];
                $invDetails->created_by = $item['created_by'];
                $invDetails->type = $item['type'];
                $invDetails->task = $item['task'];
                $invDetails->status = 0;
                
                $invDetails->save();
                //if is product
                if($item['type']==1 && is_numeric($item['service_part_id']))
                {
                    $getPart = Product::find()->where(['id' => $item['service_part_id'] ])->one();
                    $old_qty = $getPart->quantity;
                    $new_qty = $getPart->quantity - $item['quantity'];

                    $inventoryModel = new Inventory();
                                
                    $inventoryModel->product_id = $item['service_part_id'];
                    $inventoryModel->old_quantity = $old_qty;
                    $inventoryModel->new_quantity = $new_qty;
                    $inventoryModel->qty_purchased = $item['quantity'];
                    $inventoryModel->type = 2;
                    $inventoryModel->invoice_no = $invoiceNo;
                    $inventoryModel->datetime_purchased = date('Y-m-d H:i:s', strtotime($getQuotation['date_issue']));
                    $inventoryModel->created_at = date('Y-m-d H:i:s');
                    $inventoryModel->created_by = Yii::$app->user->identity->id;
                    $inventoryModel->status = 1;
                    
                    $inventoryModel->save();
                    $getPart = Product::find()->where(['id' => $item['service_part_id'] ])->one();
                    $getPart->quantity -= $item['quantity'];
                    $getPart->save();
                }
            }

             Yii::$app->db->createCommand()
                 ->update('quotation', ['invoice' => 1], "id = $id")
                ->execute();

            Yii::$app->db->createCommand()
                 ->update('quotation_detail', ['invoice' => 1], "quotation_id = $id")
                 ->execute();
      

            return $this->redirect(['invoice/payment-method', 'id' => $invoiceId ]);

        }else{

            return $this->redirect(['invoice/payment-method', 'id' => $getInvoice->id ]);
        }  

    }

    public function actionPreview($id) {

         $this->layout = 'print';
         $model = new Quotation();
         $searchModel = new SearchQuotation();

         $getProcessedQuotation = $searchModel->getProcessedQuotation($id); 
         $getProcessedServices = $searchModel->getProcessedServices($id); 
         $getProcessedParts = $searchModel->getProcessedParts($id);
         $quotationDetail = QuotationDetail::getQuotationDetailByID($id);

        return $this->render('_print-quotation',[
                            'model' => $this->findModel($id),
                            'customerInfo' => $getProcessedQuotation,
                            'services' => $getProcessedServices,
                            'parts' => $getProcessedParts,
                            'quotationDetail' => $quotationDetail
                        ]);
    }
}
