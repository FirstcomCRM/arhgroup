<?php

namespace backend\controllers;

use Yii;
use common\models\Customer;
use common\models\CarInformation;
use common\models\SearchCustomer;
use common\models\Invoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Customer'])->andWhere(['role_id' => $uRId ] )->andWhere(['status' => 1 ])->all();
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchCustomer')['fullname'])) {
                $getCustomer = $searchModel->searchCustomerFullname(Yii::$app->request->get('SearchCustomer')['fullname']);

        }else{
                $getCustomer = $searchModel->getCustomerList();
        }
        
        $getBlacklistCustomer = $searchModel->getBlacklistCustomerList();

        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'dataProvider' => $dataProvider, 
                    'getCustomer' => $getCustomer,
                    'getBlacklistCustomer' => $getBlacklistCustomer, 
                    'errTypeHeader' => '', 
                    'errType' => '', 
                    'msg' => ''
                ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new SearchCustomer();
        $result = $model->getCustomerById($id);
        $carResult = CarInformation::find()->where(['customer_id' => $id])->all();

        return $this->render('view', [
            'model' => $result,
            'carModel' => $carResult,
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();
        $carModel = new CarInformation();

         return $this->render('create', [
                            'model' => $model, 
                            'carModel' => $carModel,
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
    }

    public function actionNewCompany()
    {
        if ( Yii::$app->request->post() ) {

            $model = new Customer();



            $contactPerson = (Yii::$app->request->post('contactPerson'))? Yii::$app->request->post('contactPerson') : '';
            $companyName = (Yii::$app->request->post('companyName'))? Yii::$app->request->post('companyName') : '';
            $uen_no = (Yii::$app->request->post('uenno'))? Yii::$app->request->post('uenno') : '';
            $companyAddress = (Yii::$app->request->post('address'))? Yii::$app->request->post('address') : '';
            $companyHanphoneNo = (Yii::$app->request->post('phoneNumber'))? Yii::$app->request->post('phoneNumber') : '';
            $joinDate = (date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate')) ) : '0000-00-00';
            $memberExpiry = (date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate')) ) : '0000-00-00';
            $isMember = (Yii::$app->request->post('isMember') )? Yii::$app->request->post('isMember') : '';
            $companyOfficeNo = (Yii::$app->request->post('officeNumber'))? Yii::$app->request->post('officeNumber') : '';
            $faxNumber = (Yii::$app->request->post('faxNumber'))? Yii::$app->request->post('faxNumber') : '';
            $companyEmail = (Yii::$app->request->post('email'))? Yii::$app->request->post('email') : '';
            $remarks = (Yii::$app->request->post('message'))? Yii::$app->request->post('message') : '';
           
            $model->password = Yii::$app->request->post('password');

            if ( !empty( $model->password ) ) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
                $model->role = 10;
            }

            $model->fullname = $contactPerson;
            $model->company_name = $companyName;
            $model->uen_no = $uen_no;
            $model->address = $companyAddress;
            $model->hanphone_no = $companyHanphoneNo;
            $model->office_no = $companyOfficeNo;
            $model->fax_number = $faxNumber;
            $model->email = $companyEmail;
            $model->remarks = $remarks;
            $model->is_blacklist = 0;
            $model->join_date = $joinDate;
            $model->member_expiry = $memberExpiry;
            $model->is_member = $isMember;
            $model->type = 1;
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->deleted = 0;

            if($model->validate()) {
               $model->save();

                $customerId = $model->id;

                $company_vehicleNumber = Yii::$app->request->post('vehicleNumber');
                $company_carModel = Yii::$app->request->post('carModel');
                $company_carMake = Yii::$app->request->post('carMake');
                $company_chasis = Yii::$app->request->post('chasis');
                $company_engineNo = Yii::$app->request->post('engineNo');
                $company_yearMfg = Yii::$app->request->post('yearMfg');
                $company_rewardPoints = Yii::$app->request->post('rewardPoints');


                foreach($company_vehicleNumber as $key => $companyCarRow){
                    $commpanyCarInfo = new CarInformation();

                    $commpanyCarInfo->customer_id = $customerId;
                    $commpanyCarInfo->carplate = $company_vehicleNumber[$key]['value'];
                    $commpanyCarInfo->make = $company_carMake[$key]['value'];
                    $commpanyCarInfo->model = $company_carModel[$key]['value'];
                    $commpanyCarInfo->engine_no = $company_engineNo[$key]['value'];
                    $commpanyCarInfo->year_mfg = $company_yearMfg[$key]['value'];
                    $commpanyCarInfo->chasis = $company_chasis[$key]['value'];
                    $commpanyCarInfo->points = $company_rewardPoints[$key]['value'];
                    $commpanyCarInfo->type = 1;
                    $commpanyCarInfo->status = 1;
                    $commpanyCarInfo->join_date =$joinDate; //edr
                    $commpanyCarInfo->member_expiry = $memberExpiry;
                    $commpanyCarInfo->is_member=$isMember;

                    $commpanyCarInfo->save();
                }

                // if($isMember == 1){
                //     Yii::$app->mailer->compose('layouts/member', ['customerName' => $companyName, 'memberPassword' => Yii::$app->request->post('password')])
                //         ->setFrom('jcyanga412060@gmail.com')
                //         ->setTo($companyEmail)
                //         ->setSubject('ARH Group Pte Ltd. - Membership Confirmation')
                //         ->send();
                // }

               return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        } 
    }

    public function actionNewCustomer()
    {
        if ( Yii::$app->request->post() ) {
            
            $model = new Customer();

            $fullname = (Yii::$app->request->post('customerName') )? Yii::$app->request->post('customerName') : '';
            $nric = (Yii::$app->request->post('nric') )? Yii::$app->request->post('nric') : '';
            $personAddress = (Yii::$app->request->post('address'))? Yii::$app->request->post('address') : '';
            $raceId = (Yii::$app->request->post('race') )? Yii::$app->request->post('race') : '';
            $personHanphone = (Yii::$app->request->post('phoneNumber') )? Yii::$app->request->post('phoneNumber') : '';
            $personOfficeNo = (Yii::$app->request->post('phoneNumber') )? Yii::$app->request->post('phoneNumber') : '';
            $customerFaxNumber = (Yii::$app->request->post('customerFaxNumber'))? Yii::$app->request->post('customerFaxNumber') : '';
            $personEmail = (Yii::$app->request->post('email'))? Yii::$app->request->post('email') : '';
            $remarks = (Yii::$app->request->post('message'))? Yii::$app->request->post('message') : '';
            $joinDate = (date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate')) ) : '0000-00-00';
            $memberExpiry = (date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate')) ) : '0000-00-00';
            $isMember = (Yii::$app->request->post('isMember') )? Yii::$app->request->post('isMember') : '';
           
            $model->password = Yii::$app->request->post('password');


            if ( !empty( $model->password ) ) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
                $model->role = 10;
            }

            $model->fullname = $fullname; 
            $model->nric = $nric;
            $model->address = $personAddress;
            $model->race_id = $raceId;
            $model->hanphone_no = $personHanphone;
            $model->office_no = $personOfficeNo;
            $model->fax_number = $customerFaxNumber;
            $model->email = $personEmail;
            $model->remarks = $remarks;
            $model->join_date =  $joinDate;
            $model->member_expiry = $memberExpiry;
            $model->is_member = $isMember;
            $model->is_blacklist = 0;
            $model->type = 2;
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->deleted = 0;
            
            if($model->validate()) {
               $model->save();

                $customerId = $model->id;

                $company_vehicleNumber = Yii::$app->request->post('vehicleNumber');
                $company_carModel = Yii::$app->request->post('carModel');
                $company_carMake = Yii::$app->request->post('carMake');
                $company_chasis = Yii::$app->request->post('chasis');
                $company_engineNo = Yii::$app->request->post('engineNo');
                $company_yearMfg = Yii::$app->request->post('yearMfg');
                $company_rewardPoints = Yii::$app->request->post('rewardPoints');



                foreach($company_vehicleNumber as $key => $companyCarRow){
                    $commpanyCarInfo = new CarInformation();

                    $commpanyCarInfo->customer_id = $customerId;
                    $commpanyCarInfo->carplate = $company_vehicleNumber[$key]['value'];
                    $commpanyCarInfo->make = $company_carMake[$key]['value'];
                    $commpanyCarInfo->model = $company_carModel[$key]['value'];
                    $commpanyCarInfo->engine_no = $company_engineNo[$key]['value'];
                    $commpanyCarInfo->year_mfg = $company_yearMfg[$key]['value'];
                    $commpanyCarInfo->chasis = $company_chasis[$key]['value'];
                    $commpanyCarInfo->points = $company_rewardPoints[$key]['value'];
                    $commpanyCarInfo->type = 1;
                    $commpanyCarInfo->status = 1;
                    $commpanyCarInfo->join_date =$joinDate; //edr
                    $commpanyCarInfo->member_expiry = $memberExpiry;
                    $commpanyCarInfo->is_member=$isMember;

                    $commpanyCarInfo->save();
                    
                }

                // if($isMember == 1){
                //     Yii::$app->mailer->compose('layouts/member', ['customerName' => $fullname, 'memberPassword' => Yii::$app->request->post('password')])
                //         ->setFrom('jcyanga412060@gmail.com')
                //         ->setTo($personEmail)
                //         ->setSubject('ARH Group Pte Ltd. - Membership Confirmation')
                //         ->send();
                // }

                return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);



            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }

        } 
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new Customer();
        $carModel = new CarInformation();
        $searchModel = new SearchCustomer();

        $result = $searchModel->getCustomerById($id);
        $carResult = CarInformation::find()->where(['customer_id' => $id])->all();
        $getCarLastId = $searchModel->getCarLastId($id);
        
        return $this->render('update', [
                                'model' => $model, 
                                'carModel' => $carModel,
                                'result' => $result,
                                'carResult' => $carResult,
                                'lastId' => $getCarLastId['lastId'],
                                'errTypeHeader' => '', 
                                'errType' => '', 
                                'msg' => ''
                            ]);
    }

    public function actionEditCompany()
    {
        if ( Yii::$app->request->post() ) {

            $car_information = new CarInformation;
            $companyInfo = Customer::findOne(Yii::$app->request->post('id'));

            $contactPerson = (Yii::$app->request->post('contactPerson'))? Yii::$app->request->post('contactPerson') : '';
            $companyName = (Yii::$app->request->post('companyName'))? Yii::$app->request->post('companyName') : '';
            $uen_no = (Yii::$app->request->post('uenno'))? Yii::$app->request->post('uenno') : '';
            $companyAddress = (Yii::$app->request->post('address'))? Yii::$app->request->post('address') : '';
            $companyHanphoneNo = (Yii::$app->request->post('phoneNumber'))? Yii::$app->request->post('phoneNumber') : '';
            $companyOfficeNo = (Yii::$app->request->post('officeNumber'))? Yii::$app->request->post('officeNumber') : '';
            $companyFaxNumber = (Yii::$app->request->post('companyFaxNumber'))? Yii::$app->request->post('companyFaxNumber') : '';
            $companyEmail = (Yii::$app->request->post('email'))? Yii::$app->request->post('email') : '';
            $remarks = (Yii::$app->request->post('message'))? Yii::$app->request->post('message') : '';
            $joinDate = (date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate')) ) : '0000-00-00';
            $memberExpiry = (date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate')) ) : '0000-00-00';
            $isMember = (Yii::$app->request->post('isMember') )? Yii::$app->request->post('isMember') : '';

            $companyInfo->password = Yii::$app->request->post('password');

            if ( !empty( $companyInfo->password ) ) {
                $companyInfo->password_hash = Yii::$app->security->generatePasswordHash($companyInfo->password); 
                $companyInfo->generateAuthKey();
                $companyInfo->role = 10;
            }

            $companyInfo->fullname = $contactPerson;
            $companyInfo->company_name = $companyName;
            $companyInfo->uen_no = $uen_no;
            $companyInfo->address = $companyAddress;
            $companyInfo->hanphone_no = $companyHanphoneNo;
            $companyInfo->office_no = $companyOfficeNo;
            $companyInfo->fax_number = $companyFaxNumber;
            $companyInfo->email = $companyEmail;
            $companyInfo->remarks = $remarks;
            $companyInfo->join_date = $joinDate;
            $companyInfo->member_expiry = $memberExpiry;
            $companyInfo->is_member = $isMember;
            $companyInfo->is_blacklist = 0;
            $companyInfo->type = 1;
            $companyInfo->status = 1;
            $companyInfo->created_at = date('Y-m-d H:i:s');
            $companyInfo->created_by = Yii::$app->user->identity->id;
            $companyInfo->updated_at = date('Y-m-d H:i:s');
            $companyInfo->updated_by = Yii::$app->user->identity->id;
            $companyInfo->deleted = 0;

            if($companyInfo->validate()) {
               $companyInfo->save();

                $id = Yii::$app->request->post('id');

                Yii::$app->db->createCommand()
                    ->update('car_information',['status' => 0],"customer_id = $id")
                    ->execute();

                $company_vehicleNumber = Yii::$app->request->post('vehicleNumber');
                $company_carModel = Yii::$app->request->post('carModel');
                $company_carMake = Yii::$app->request->post('carMake');
                $company_chasis = Yii::$app->request->post('chasis');
                $company_engineNo = Yii::$app->request->post('engineNo');
                $company_yearMfg = Yii::$app->request->post('yearMfg');
                $company_rewardPoints = Yii::$app->request->post('rewardPoints');
                $company_carInfoId = Yii::$app->request->post('carInfoId');
                $company_carId = Yii::$app->request->post('carId');

                foreach($company_vehicleNumber as $key => $companyCarRow){
                    $commpanyCarInfo = new CarInformation();

                    if($company_carId[$key]['value']!='')
                        $commpanyCarInfo = CarInformation::findOne($company_carId[$key]['value']);

                    $commpanyCarInfo->customer_id = $id;
                    // $commpanyCarInfo->id = $company_carInfoId[$key]['value'];
                    $commpanyCarInfo->carplate = $company_vehicleNumber[$key]['value'];
                    $commpanyCarInfo->make = $company_carMake[$key]['value'];
                    $commpanyCarInfo->model = $company_carModel[$key]['value'];
                    $commpanyCarInfo->engine_no = $company_engineNo[$key]['value'];
                    $commpanyCarInfo->year_mfg = $company_yearMfg[$key]['value'];
                    $commpanyCarInfo->chasis = $company_chasis[$key]['value'];
                    $commpanyCarInfo->points = $company_rewardPoints[$key]['value'];
                    $commpanyCarInfo->type = 1;
                    $commpanyCarInfo->status = 1;
                    $commpanyCarInfo->join_date =$joinDate; //edr
                    $commpanyCarInfo->member_expiry = $memberExpiry;
                    $commpanyCarInfo->is_member=$isMember;

                    $commpanyCarInfo->save();
                }

                Yii::$app->db->createCommand()
                    ->delete('car_information', ["customer_id"=>$id, "status"=>0] )
                    ->execute();



               return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $companyInfo->errors, 'status' => 'Error']);
            
            }

        } 
    }

    public function actionEditCustomer()
    {
        if ( Yii::$app->request->post() ) {
            
            $car_information = new CarInformation;
            $customerInfo = Customer::findOne(Yii::$app->request->post('id'));

            $fullname = (Yii::$app->request->post('customerName') )? Yii::$app->request->post('customerName') : '';
            $nric = (Yii::$app->request->post('nric') )? Yii::$app->request->post('nric') : '';
            $personAddress = (Yii::$app->request->post('address'))? Yii::$app->request->post('address') : '';
            $raceId = (Yii::$app->request->post('race') )? Yii::$app->request->post('race') : '';
            $personHanphone = (Yii::$app->request->post('phoneNumber') )? Yii::$app->request->post('phoneNumber') : '';
            $personOfficeNo = (Yii::$app->request->post('phoneNumber') )? Yii::$app->request->post('phoneNumber') : '';
            $customerFaxNumber = (Yii::$app->request->post('customerFaxNumber'))? Yii::$app->request->post('customerFaxNumber') : '';
            $personEmail = (Yii::$app->request->post('email'))? Yii::$app->request->post('email') : '';
            $remarks = (Yii::$app->request->post('message'))? Yii::$app->request->post('message') : '';
            $joinDate = (date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberJoinDate')) ) : '0000-00-00';
            $memberExpiry = (date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate'))) )? date('Y-m-d', strtotime(Yii::$app->request->post('memberExpiryDate')) ) : '0000-00-00';
            $isMember = (Yii::$app->request->post('isMember') )? Yii::$app->request->post('isMember') : '';

            $customerInfo->password = Yii::$app->request->post('password');

            if ( !empty( $customerInfo->password ) ) {
                $customerInfo->password_hash = Yii::$app->security->generatePasswordHash($customerInfo->password); 
                $customerInfo->generateAuthKey();
                $customerInfo->role = 10;
            }

            $customerInfo->fullname = $fullname; 
            $customerInfo->nric = $nric;
            $customerInfo->address = $personAddress;
            $customerInfo->race_id = $raceId;
            $customerInfo->hanphone_no = $personHanphone;
            $customerInfo->office_no = $personOfficeNo;
            $customerInfo->fax_number = $customerFaxNumber;
            $customerInfo->email = $personEmail;
            $customerInfo->remarks = $remarks;
            $customerInfo->join_date =  $joinDate;
            $customerInfo->member_expiry = $memberExpiry;
            $customerInfo->is_member = $isMember;
            $customerInfo->is_blacklist = 0;
            $customerInfo->type = 2;
            $customerInfo->status = 1;
            $customerInfo->created_at = date('Y-m-d H:i:s');
            $customerInfo->created_by = Yii::$app->user->identity->id;
            $customerInfo->updated_at = date('Y-m-d H:i:s');
            $customerInfo->updated_by = Yii::$app->user->identity->id;
            $customerInfo->deleted = 0;
            
            if($customerInfo->validate()) {
               $customerInfo->save();

                $id = Yii::$app->request->post('id');

                Yii::$app->db->createCommand()
                    ->delete('car_information', "customer_id = $id" )
                    ->execute();

                $company_vehicleNumber = Yii::$app->request->post('vehicleNumber');
                $company_carModel = Yii::$app->request->post('carModel');
                $company_carMake = Yii::$app->request->post('carMake');
                $company_chasis = Yii::$app->request->post('chasis');
                $company_engineNo = Yii::$app->request->post('engineNo');
                $company_yearMfg = Yii::$app->request->post('yearMfg');
                $company_rewardPoints = Yii::$app->request->post('rewardPoints');
                $company_carInfoId = Yii::$app->request->post('carInfoId');


                foreach($company_vehicleNumber as $key => $companyCarRow){
                    $commpanyCarInfo = new CarInformation();

                    $commpanyCarInfo->customer_id = $id;
                    $commpanyCarInfo->id = $company_carInfoId[$key]['value'];
                    $commpanyCarInfo->carplate = $company_vehicleNumber[$key]['value'];
                    $commpanyCarInfo->make = $company_carMake[$key]['value'];
                    $commpanyCarInfo->model = $company_carModel[$key]['value'];
                    $commpanyCarInfo->engine_no = $company_engineNo[$key]['value'];
                    $commpanyCarInfo->year_mfg = $company_yearMfg[$key]['value'];
                    $commpanyCarInfo->chasis = $company_chasis[$key]['value'];
                    $commpanyCarInfo->points = $company_rewardPoints[$key]['value'];
                    $commpanyCarInfo->type = 1;
                    $commpanyCarInfo->status = 1;
                    $commpanyCarInfo->join_date =$joinDate; //edr
                    $commpanyCarInfo->member_expiry = $memberExpiry;
                    $commpanyCarInfo->is_member=$isMember;

                    $commpanyCarInfo->save();
                }

               return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $customerInfo->errors, 'status' => 'Error']);
            
            }

        } 
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteColumn($id)
    {
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Yii::$app->db->createCommand()
            ->update('customer',['deleted' => 1],"id = $id")
            ->execute();

        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        Yii::$app->db->createCommand()
                ->update('car_information', ['status' => 0],  "id = $id" )
                ->execute();

        Yii::$app->getSession()->setFlash('success', 'Your record was successfully deleted in the database.');
        return $this->redirect(['index']);
    }

    public function actionBlockCustomer($id)
    {
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getCustomer = $searchModel->getCustomerList();
        $getBlacklistCustomer = $searchModel->getBlacklistCustomerList();

        Yii::$app->db->createCommand()
                    ->update('customer', ['is_blacklist' => 1],  "id = $id" )
                    ->execute();

        Yii::$app->db->createCommand()
                    ->update('car_information', ['status' => 0],  "customer_id = $id" )
                    ->execute();

        Yii::$app->getSession()->setFlash('success', 'Customer record was successfully blocked in the list.');
        return $this->redirect(['index']);
    }

    public function actionUnblockCustomer($id)
    {
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getCustomer = $searchModel->getCustomerList();
        $getBlacklistCustomer = $searchModel->getBlacklistCustomerList();

        Yii::$app->db->createCommand()
                    ->update('customer', ['is_blacklist' => 0],  "id = $id" )
                    ->execute();

        Yii::$app->db->createCommand()
                    ->update('car_information', ['status' => 1],  "customer_id = $id" )
                    ->execute();

        Yii::$app->getSession()->setFlash('success', 'Customer record was successfully unblocked in the list.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPointsRedemptionHistory($id)
    {   
        $searchModel = new SearchCustomer();

        $getCarPoints = CarInformation::find()->where(['customer_id' => $id])->all();
        $getRedeemPoints = $searchModel->getRedeemPoints($id);
        
        return $this->render('_points-redeem', [
                                'model' => $this->findModel($id),
                                'getCarPoints' => $getCarPoints
                            ]);
    }

    public function actionInsertItemInList()
    {
        $car_plate = Yii::$app->request->post('car_plate');
        $car_model = Yii::$app->request->post('car_model');
        $car_make = Yii::$app->request->post('car_make');
        $chasis = Yii::$app->request->post('chasis');
        $engine_no = Yii::$app->request->post('engine_no');
        $year_mfg = Yii::$app->request->post('year_mfg');
        $reward_points = Yii::$app->request->post('reward_points');
        $n = Yii::$app->request->post('n');

        $this->layout = false;

        return $this->render('insert-item-in-list', [
                            'car_plate' => $car_plate,
                            'car_model' => $car_model,
                            'car_make' => $car_make,
                            'chasis' => $chasis,
                            'engine_no' => $engine_no,
                            'year_mfg' => $year_mfg,
                            'reward_points' => $reward_points,
                            'n' => $n,
                        ]);
    }

    public function actionExportExcel() 
    {
        $model = new SearchCustomer();

        $result = $model->getCustomerList();
        
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
             ->setCellValue('A1', 'Fullname')
             ->setCellValue('B1', 'Address')
             ->setCellValue('C1', 'Email Address')
             ->setCellValue('D1', 'Hand-Phone Number')
             ->setCellValue('E1', 'Office Number')
             ->setCellValue('F1', 'Race')
             ->setCellValue('G1', 'Member Expiry')
             ->setCellValue('H1', 'Status');
             
             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleHeadingArray);

         $row=2;
                                
                foreach ($result as $result_row) {  
                    
                    $expiryDate = date('m-d-Y', strtotime($result_row['member_expiry']) );    
                    $status = ( $result_row['status'] == 1 ) ? 'Active' : 'Inactive';

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['fullname']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['address']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['email']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['hanphone_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['office_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$expiryDate);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$status);
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "CustomerList-".date("d-m-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() 
    {
        $model = new SearchCustomer();

        $result = $model->getCustomerList();
        $content = $this->renderPartial('_pdf', ['result' => $result]);
        
        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('CustomerList-' . date('m-d-Y'));
    }
    
    public function actionExportInvoices($customer_id){

        $data = Invoice::exportInvoicesByCustomerId($customer_id);
        $customer = SearchCustomer::getCustomerListById($customer_id);

        $customer_name = $customer['fullname'];

        if($customer['fullname']=='' || $customer['fullname']==null)
            $customer_name = $customer['company_name'];

        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($customer_name));

        // echo "<pre>";
        // var_dump($data);
        // exit;
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
             ->setCellValue('A1', 'Invoice No')
             ->setCellValue('B1', 'Branch Nname')
             ->setCellValue('C1', 'Car Plate')
             ->setCellValue('D1', 'Date Issue')
             ->setCellValue('E1', 'Staff')
             ->setCellValue('F1', 'Customer Name')
             ->setCellValue('G1', 'Amount')
             ->setCellValue('H1', 'GST')
             ->setCellValue('I1', 'Item')
             ->setCellValue('J1', 'Quantity')
             ->setCellValue('K1', 'Selling Price')
             ->setCellValue('L1', 'Subtotal');
             
             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($styleHeadingArray);

         $row=2;
                
                $invoice_no = "";          
                foreach ($data as $result_row) {  

                    if($invoice_no!=$result_row['invoice_no'])
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['invoice_no']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['branch_name']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['carplate']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['date_issue']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['username']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['name']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['net']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$result_row['gst']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$result_row['item']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$result_row['selling_price']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$result_row['quantity']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$result_row['subTotal']); 
                    }
                    else
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,''); 
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,''); 
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,''); 
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,''); 
                        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,''); 
                        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,''); 
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,''); 
                        $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,''); 
                        $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$result_row['item']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$result_row['selling_price']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$result_row['quantity']); 
                        $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$result_row['subTotal']); 
                    }
                    

                    // $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                    $invoice_no = $result_row['invoice_no'];
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "customer-".$slug."-all-invoices.xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
