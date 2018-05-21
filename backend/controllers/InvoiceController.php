<?php

/*
Changes/Revision of Invoice

Date            Emblem      Version      Description/Changes
2017-12-12     //EDR-v1      v1           -at actionSubmitPayment, fixed the multiple payment in which shows the wrong balance.
                                          -at actionSubmitPayment, for single and multiple payment, make sure that the points are added to car_information "points" columns
                                          and not at the customer "points", since it has been changed.
*/

namespace backend\controllers;

use Yii;
use common\models\Invoice;
use common\models\SearchInvoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use common\models\Service;
use common\models\Inventory;
use common\models\InvoiceDetail;
use common\models\Category;
use common\models\Product;
use common\models\Gst;
use common\models\Payment;
use common\models\ProductLevel;
use common\models\Customer;
use common\models\PaymentType;
use common\models\SearchCustomer;
use common\models\SearchInventory;
use common\models\SearchService;
use common\models\SearchGst;
use common\models\CarInformation;
use common\models\SearchProduct;
use common\models\Quotation;
use common\models\SearchQuotation;
use common\models\Branch;
use common\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Invoice'])->andWhere(['role_id' => $uRId ] )->andWhere(['status' => 1 ])->all();
            $actionArray = [];
            foreach ( $permission as $p )  {
                $actionArray[] = $p->action;
            }

            $allow[$uRName] = false;
            $action[$uRName] = $actionArray;
            if ( ! empty( $action[$uRName] ) ) {
                $allow[$uRName] = true;
            }

        }   

        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    
                    [
                        'actions' => $action['developer'],
                        'allow' => $allow['developer'],
                        'roles' => ['developer'],
                    ],

                    [
                        'actions' => $action['admin'],
                        'allow' => $allow['admin'],
                        'roles' => ['admin'],
                    ],

                    [
                        'actions' => $action['staff'],
                        'allow' => $allow['staff'],
                        'roles' => ['staff'],
                    ],

                    [
                        'actions' => $action['customer'],
                        'allow' => $allow['customer'],
                        'roles' => ['customer'],
                    ]
       
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = array();

        if(isset(Yii::$app->request->queryParams['SearchInvoice']['date_from']))
            $params = Yii::$app->request->queryParams['SearchInvoice'];

        $searchModel = new SearchInvoice();
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
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
         $model = new Invoice();
         $searchModel = new SearchInvoice();

         $getProcessedInvoice = $searchModel->getProcessedInvoice($id); 
         $getProcessedServices = $searchModel->getProcessedServices($id); 
         $getProcessedParts = $searchModel->getProcessedParts($id);

         $paymentInformation = $searchModel->getInvoicePaymentInformation($id);
         $invoice_detail = InvoiceDetail::getInvoiceDetailByID($id);
         $redeem_price = Payment::getPaymentWithRedeemPoint($id);

        // var_dump($id);//edr, check the invoice/view
        // var_dump( $getProcessedInvoice);
        //die();
        return $this->render('view',[
                'model' => $this->findModel($id),
                'redeem_price' => $redeem_price,
                'customerInfo' => $getProcessedInvoice,
                'services' => $getProcessedServices,
                'parts' => $getProcessedParts,
                'paymentInformation' => $paymentInformation,
                'invoice_detail' => $invoice_detail,
            ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        $model = new Invoice();
        $branch = Branch::getBranchWithKeyId();
        $user = User::dataUser();
        $customer = CarInformation::dataCarInformation();
        $invoiceLastId = $this->_getInvoiceId();
        $category = Category::dataCategory();

        if ($postData = Yii::$app->request->post()) {
            $postData = Yii::$app->request->post();

            $message = "";
            $message = $this->validateInvoice($postData);

            if($message!='')
                return json_encode(array('status'=>'failed', 'message'=>$message, 'redirect'=>''));

            $invoice_id = Invoice::saveInvoice($postData);

            Yii::$app->getSession()->setFlash('success', 'Your record was successfully added in the database.');
            return json_encode(array('status'=>'success', 'message'=>'Your record was successfully added in the database.', 'redirect'=>'?r=invoice/view&id='.$invoice_id));

        } else {
            return $this->render('create', [
                'model' => $model,
                'invoiceId' => $invoiceLastId,
                'branch' => $branch,
                'user' => $user,
                'customer' => $customer,
                'category' =>$category,
                'redeem_point' => '0',
                'redeem_price' => '0.00',
            ]);
        }
    }

    public function actionPreview($id) {

         $model = new Invoice();
         $searchModel = new SearchInvoice();

         $getProcessedInvoiceById = $searchModel->getProcessedInvoiceById($id); 
         $getProcessedServicesById = $searchModel->getProcessedServicesById($id); 
         $getProcessedPartsById = $searchModel->getProcessedPartsById($id);

        return $this->render('processed-invoice',[
                'model' => $this->findModel($id),
                'customerInfo' => $getProcessedInvoiceById,
                'services' => $getProcessedServicesById,
                'parts' => $getProcessedPartsById
            ]);
    }

    /**
     * Updates an existing Invoice model.
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
        $invoiceLastId = $this->_getInvoiceId();
        $category = Category::dataCategory();
        $invoiceDetail = InvoiceDetail::getInvoiceDetailByID($id);
        $redeem_record = Payment::getRedeemPointPaymentRecord($id);

        $redeem_point = "0";
        $redeem_price = "0.00";

        if($redeem_record!=false){
            $redeem_point = $redeem_record['redeem_point'];
            $redeem_price = $redeem_record['redeem_price'];
        }

        if ($postData = Yii::$app->request->post()) {

            $message = "";
            $message = $this->validateInvoice($postData);

            if($message!='')
                return json_encode(array('status'=>'failed', 'message'=>$message, 'redirect'=>''));

            Invoice::updateInvoice($id, $postData);

            Yii::$app->getSession()->setFlash('success', 'Your record was successfully updated in the database.');
            return json_encode(array('status'=>'success', 'message'=>'Your record was successfully updated in the database.', 'redirect'=>'?r=invoice/view&id='.$id));
        } else {
            return $this->render('update', [
                'invoiceId' => $invoiceLastId,
                'model' => $model,
                'branch' => $branch,
                'user' => $user,
                'customer' => $customer,
                'category' =>$category,
                'invoice_detail' => $invoiceDetail,
                'redeem_point' => $redeem_point,
                'redeem_price' => $redeem_price,
                'msg' => '',
            ]);
        }
    }

    public function _getInvoiceId() 
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getInvoiceId();

        return $result;
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->db->createCommand()
            ->update('invoice', ['delete' => 1], "id = $id")
            ->execute();

        $invoice = Invoice::getInvoiceById($id);

        //revert payment points
        InvoiceDetail::revertPoints($id);

        //revert inventory and product quantity
        InvoiceDetail::revertInventoryProductQuantity($id);

        return $this->redirect(['index']);

    }

    public function actionDeleteColumn($id)
    {
        $searchModel = new SearchInvoice();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $this->findModel($id)->delete();
        Yii::$app->db->createCommand()
            ->update('invoice', ['delete' => 1], "id = $id")
            ->execute();

        // Yii::$app->db->createCommand()
        //     ->delete('invoice_detail', "invoice_id = $id" ) 
        //     ->execute();

        // Yii::$app->db->createCommand()
        //     ->delete('payment', "invoice_id = $id" )    
        //     ->execute();

        $getInvoice = $searchModel->getInvoice();   

        return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getInvoice' => $getInvoice,
                            'dataProvider' => $dataProvider, 
                            'date_start' => '',
                            'date_end' => '',
                            'customerName' => '',
                            'vehicleNumber' => '',
                            'errTypeHeader' => 'Success!', 
                            'errType' => 'alert alert-success', 
                            'msg' => 'Your record was successfully deleted in the database.'
                        ]);
    }

    public function actionDeleteSelectedQuotationDetail($id,$invoiceId)
    {
        // Yii::$app->db->createCommand()
        //     ->delete('invoice_detail', "id = $id" )
        //     ->execute();


        return $this->actionUpdate($invoiceId);
    }
    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPaymentMethod($id) 
    {

         $model = new Invoice();
         $searchModel = new SearchInvoice();

         $getProcessedInvoiceById = $searchModel->getProcessedInvoiceById($id); 
         $getProcessedServicesById = $searchModel->getProcessedServicesById($id); 
         $getProcessedPartsById = $searchModel->getProcessedPartsById($id);

         $paymentInformation = ($getProcessedInvoiceById['paid'] > 1)? $searchModel->getInvoicePaymentInformation($id) : '';
         $redeem_price = Payment::getPaymentWithRedeemPoint($id);
         $invoice_detail = InvoiceDetail::getInvoiceDetailByID($id);

        if($getProcessedInvoiceById['paid'] >= 2 || $getProcessedInvoiceById['paid'] == 0){

            return $this->render('payment-method',[
                        'model' => $this->findModel($id),
                        'customerInfo' => $getProcessedInvoiceById,
                        'redeem_price' => $redeem_price,
                        'services' => $getProcessedServicesById,
                        'parts' => $getProcessedPartsById,
                        'paymentInformation' => $paymentInformation,
                        'invoice_detail' => $invoice_detail,
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
                    ]);
        }else{

            return $this->redirect(['view', 'id' => $id]);
        }

    }

    public function actionExportExcel() 
    {
        $model = new SearchInvoice();
        $result = $model->getInvoice();

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
             ->setCellValue('C1', 'Invoice Number')
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
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['invoice_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['fullname']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['salesPerson']);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "InvoiceList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                
    }

// ------- SELECT PARTS ------ //

    public function actionPartsList()
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getPartsList();

        $data = array();
        foreach($result as $rowP)
        {
           $products = array(
                    'id' => $rowP['id'],
                    'supplier_name' => $rowP['supplier_name'],
                    'product_name' => $rowP['product_name'],   
                );
            
            $data[] = $products;    
        }
         
        return json_encode($data);
    }

    public function actionPartsByCategory()
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getPartsByCategory(Yii::$app->request->get('partsCategory'));

        $data = array();
        foreach($result as $rowP)
        {
           $products = array(
                    'id' => $rowP['id'],
                    'supplier_name' => $rowP['supplier_name'],
                    'product_name' => $rowP['product_name'],   
                );
            
            $data[] = $products;    
        }
        

        return json_encode($data);
    }

// -------- SELECT SERVICE ---------- //

    public function actionServiceList()
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getServicesList();

        $data = array();
        foreach($result as $rowS)
        {
           $services = array(
                    'id' => $rowS['id'],
                    'service_category' => $rowS['name'],
                    'service_name' => $rowS['service_name'],   
                );
            
            $data[] = $services;    
        }
         
        return json_encode($data);
    }

    public function actionServiceByCategory()
    {
        $searchModel = new SearchInvoice();
        $result = $searchModel->getServicesByCategory(Yii::$app->request->get('serviceCategory'));

        $data = array();
        foreach($result as $rowS)
        {
           $products = array(
                    'id' => $rowS['id'],
                    'service_category' => $rowS['name'],
                    'service_name' => $rowS['service_name'],   
                );
            
            $data[] = $products;    
        }
        

        return json_encode($data);
    }

    // ---------------------------------------- //
    public function actionGetBranchGstById()
    {
        $searchModel = new SearchGst();
        $getBranchGst = $searchModel->getBranchGst(Yii::$app->request->get('branchId'));
        
        if( $getBranchGst == 0 ) {
            return 0;

        }else{
            return $getBranchGst;

        }

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

    // ---------------------------------------- //
    public function actionGetPaymentType()
    {
        $getPaymentType = PaymentType::findOne(Yii::$app->request->post('mode_payment'));

        $data = array();
        $data['id'] = $getPaymentType['id'];
        $data['name'] = $getPaymentType['name'];
        $data['interest'] = $getPaymentType['interest'];


      //  print_r(data);die();

        return json_encode($data);
    }

    // ---------------------------------------- //

    // public function actionPrintSinglePayment($invoiceId,$invoiceNo,$customerId)
    // {
    //     $searchModel = new SearchInvoice();

    //     $getInvoice = $searchModel->getPaidInvoice($invoiceId,$invoiceNo,$customerId);
    //     $getServices = $searchModel->getInvoiceServiceDetail($invoiceId);
    //     $getParts = $searchModel->getInvoicePartDetail($invoiceId);

    //     $this->layout = 'print';

    //     return $this->render('_print-invoice',[
    //                         'customerInfo' => $getInvoice,
    //                         'services' => $getServices,
    //                         'parts' => $getParts
    //                     ]);
    // }

    // ------------------------ PRINT -------------------------- //
    public function actionPrintInvoice($id) 
    {
        $invoiceInfo = Invoice::getInvoiceInformation($id);
        // $payment = Payment::getPaymentbyInvoiceId($id);
        $invoiceDetail = InvoiceDetail::getInvoiceDetailByID($id);
        $redeem_price = Payment::getPaymentWithRedeemPoint($id);
        $payment = Payment::getPaidPayment($id);

        if(count($payment)==0)
        {
            $payment[] = array(
                'payment_type' => 0,
                'net_with_interest' => $invoiceInfo['net'],
                'balance' => $invoiceInfo['net']
            );
        }

        $this->layout = 'print';

        return $this->render('_print-invoice',[
            'invoiceInfo' => $invoiceInfo,
            'invoiceDetail' => $invoiceDetail,
            'redeem_price' => $redeem_price,
            'payment' => $payment,
        ]);
    }

    // ------ VIEW INVOICE FROM DASHBOARD ------- //

    public function actionViewByCustomerSearch($id,$invoiceNo)
    {
        $model = new Invoice();
        $searchModel = new SearchInvoice();

        $getInvoice = $searchModel->getProcessedInvoice($id);
        $getParts = $searchModel->getInvoicePartDetail($id);

        $paymentInformation = ( $getInvoice['paid'] > 1)? $searchModel->getInvoicePaymentInformation($id) : '';

        return $this->render('_view-customer-invoice',[
            'customerInfo' => $getInvoice,
            'parts' => $getParts,
            'paymentInformation' => $paymentInformation,
        ]);

    }

    public static function validateInvoice($postData){
        $invoice = $postData['Invoice'];
        $message = "";

        if($invoice['branch_id']=='0' || $invoice['branch_id']=='')
            $message = "Please select a branch";
        else if($invoice['user_id']=='0' || $invoice['user_id']=='')
            $message = "Please select a sales person";
        else if($invoice['customer_id']=='0' || $invoice['customer_id']=='')
            $message = "Please select a car plate";
        else if(!isset($postData['service_part_id']) || count($postData['service_part_id'])==0 )
            $message = "Please add in at least one item for Product or Service";

        return $message;
    }

    // ------ FOR SINGLE AND MULTIPLE PAYMENT ------- //
    public function actionSubmitPayment()
    {
        if ($postData = Yii::$app->request->post()) {
            $payment = $postData['Payment'];
            $invoice = Invoice::getInvoiceById($payment['invoice_id']);
              $car_information = CarInformation::getCarInformationById($invoice->customer_id);
            $customer = SearchCustomer::getCustomerById($car_information->customer_id);

            //single payment
            if( $postData['paymentMethod']== 1 ){
                $new_payment = New Payment();
                $new_payment->payment_method = $postData['paymentMethod'];
                $new_payment->payment_type = $payment['payment_type'];
                $new_payment->points_redeem = 0;
                $new_payment->remarks = $payment['remarks'];
                $new_payment->invoice_id = $invoice->id;
                $new_payment->invoice_no = $invoice->invoice_no;
                $new_payment->customer_id = $invoice->customer_id;
                $new_payment->payment_date = $payment['payment_date'];
                $new_payment->payment_time = $payment['payment_time'];
                $new_payment->amount = $postData['net'] ;
                $new_payment->net_with_interest = '0.00';
                $new_payment->net = $payment['amount'];
                $new_payment->status = 1;
                $new_payment->interest = $postData['sInterest'];
                $new_payment->payment_status = 'Paid';

                if($customer['is_member']=='1')
                    $new_payment->points_earned = floor($invoice->net);
                else
                    $new_payment->points_earned = 0;

               $new_payment->save(false);

                $invoice->payment_status = "Paid";
                $invoice->paid = 1;
                $invoice->status = 1;
                $invoice->paid_type = 1;
                $invoice->balance_amount = "0.00";
                $invoice->save();


                if($car_information['is_member']=='1')//EDR-v1
                {
                    $car_information->points = $car_information->points + floor($invoice->net);
                    $car_information->save();
                }

                Yii::$app->getSession()->setFlash('success', 'Successfully added new payment');

                $redirect= "?r=invoice/view&id=".$invoice->id;
                return json_encode(array('status'=>'success','message'=>'','redirect'=>$redirect));
            }
            else{//multiple payment
                $payment_type = $postData['payment_type'];
                $interest_amount = $postData['interest_amount'];
                $total_amount = $postData['total_amount'];
                $remarks = $postData['remarks'];
                $interests = $postData['interests'];
                $balance_amount = $invoice->balance_amount;
                $left_amount = $invoice->balance_amount;
                $i = 0;
              //  $invoice_amount = $invoice->net;
                $invoice_amount = $invoice->balance_amount;//EDR-v1


                while($i < count($payment_type))
                {
                    $left_amount -= $total_amount[$i];
                    $new_invoice = Invoice::getInvoiceById($payment['invoice_id']);

                    $new_payment = New Payment();
                    $new_payment->payment_method = $postData['paymentMethod'];
                    $new_payment->payment_type = $payment_type[$i];
                    $new_payment->points_redeem = 0;
                    $new_payment->remarks = $remarks[$i];
                    $new_payment->invoice_id = $invoice->id;
                    $new_payment->invoice_no = $invoice->invoice_no;
                    $new_payment->customer_id = $invoice->customer_id;
                    $new_payment->payment_date = date('Y-m-d');
                    $new_payment->payment_time = date('H:i:s');
                    $new_payment->amount = $interest_amount[$i]!='0.00' ? ($total_amount[$i] - $interest_amount[$i]) : $total_amount[$i];
                    $new_payment->net_with_interest = ($balance_amount - $new_payment->amount);
                    $new_payment->net = $total_amount[$i];
                    $new_payment->status = 1;
                    $new_payment->interest = $interests[$i];

                    if($left_amount <= '0.00'){
                        $new_payment->payment_status = 'Paid';


                        if($i == (count($payment_type)-1))
                        {

                            if($car_information['is_member']=='1')//EDR-v1
                                $new_payment->points_earned = floor($invoice->net);
                            else
                                $new_payment->points_earned = 0;
                        }
                    }
                    else{    
                        $new_payment->payment_status = 'Partially Paid';
                        $new_payment->points_earned = 0;
                    }

                    $new_payment->save(false);
                    $mounts[] = $total_amount[$i] - $interest_amount[$i];////EDR-v1
                    $invoice_amount = $invoice_amount - ($total_amount[$i] - $interest_amount[$i] );

                    $i++;
                    $balance_amount -= $new_payment->amount;
                }

                    if($car_information['is_member']=='1')//EDR-v1
                      {
                          $car_information->points = $car_information->points + floor(array_sum($mounts));
                          $car_information->save(false);
                      }

                if($invoice_amount<= '0.00')
                {
                    $invoice->payment_status = "Paid";
                    $invoice->paid = 1;
                    $invoice->paid_type = 1;
                    $invoice->balance_amount = "0.00";

                }
                else
                {
              //      $invoice->balance_amount = $invoice_amount;
                    $invoice->balance_amount = $invoice->balance_amount-array_sum($mounts);//EDR-v1
                    $invoice->payment_status = "Partially Paid";
                    $invoice->paid = 2;
                }
                $invoice->status = 1;
                $invoice->save();

            }
            Yii::$app->getSession()->setFlash('success', 'Successfully added new payment');
            $redirect= "?r=invoice/view&id=".$invoice->id;
            return json_encode(array('status'=>'success','message'=>'','redirect'=>$redirect));
        }
    }

}
