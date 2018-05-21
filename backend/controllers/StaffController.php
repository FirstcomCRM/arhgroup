<?php

namespace backend\controllers;

use Yii;
use common\models\Staff;
use common\models\SearchStaff;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
        // $userRole = Role::find()->all();

        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Staff'])->andWhere(['role_id' => $uRId ])->andWhere(['status' => 1 ])->all();
            
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
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchStaff();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchStaff')['fullname'])) {
            $getStaff = $searchModel->searchStaffName(Yii::$app->request->get('SearchStaff')['fullname']);
        
        }else {
            $getStaff = Staff::find()->where(['status' => 1])->all();

        }

        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'getStaff' => $getStaff, 
                    'dataProvider' => $dataProvider, 
                    'errTypeHeader' => '', 
                    'errType' => '', 
                    'msg' => ''
        ]);
    }

    /**
     * Displays a single Staff model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new SearchStaff();
        $result = $model->getStaffListById($id);
        
        return $this->render('view', [
            'model' => $result,
        ]);
    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staff();
        $searchModel = new SearchStaff();

        $getStaffId = $searchModel->getStaffId();

        return $this->render('create', [
                        'model' => $model, 
                        'getStaffId' => $getStaffId,
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
                     ]);
    }

    public function actionNew()
    {
        $model = new Staff();  

        if ( Yii::$app->request->post() ) {   

            $levy_supplement = (Yii::$app->request->post('levy_supplement') <> '')? Yii::$app->request->post('levy_supplement') : 0;

            $model->staff_code = Yii::$app->request->post('code');
            $model->citizenship = Yii::$app->request->post('citizenship');
            $model->staff_group_id = Yii::$app->request->post('staff_group');
            $model->designated_position_id = Yii::$app->request->post('position');
            $model->fullname = Yii::$app->request->post('fullname');
            $model->address = Yii::$app->request->post('address');
            $model->ic_no = Yii::$app->request->post('nric');
            $model->birthday = date('Y-m-d', strtotime(Yii::$app->request->post('birthday')));
            $model->email = Yii::$app->request->post('email');
            $model->mobile_number = Yii::$app->request->post('mobile_number');
            $model->phone_number = Yii::$app->request->post('phone_number');
            $model->language_prefer = Yii::$app->request->post('preferredLanguages');
            $model->gender = Yii::$app->request->post('gender');
            $model->nationality_id = Yii::$app->request->post('nationality');
            $model->marital_status_id = Yii::$app->request->post('maritalStatus');
            $model->race_id = Yii::$app->request->post('race');
            $model->religion_id = Yii::$app->request->post('religion');
            $model->remarks = Yii::$app->request->post('remarks');
            $model->contact_person = Yii::$app->request->post('contactPerson');
            $model->contact_number = Yii::$app->request->post('contact_no');
            $model->contact_person_relationship = Yii::$app->request->post('relationship');
            $model->contact_person_address = Yii::$app->request->post('contactAddress');
            $model->work_time_start = date('H:i:s', strtotime(Yii::$app->request->post('worktimeStart')));
            $model->join_date = date('Y-m-d', strtotime(Yii::$app->request->post('joinDate')));
            $model->work_time_end = date('H:i:s', strtotime(Yii::$app->request->post('worktimeEnd')));
            $model->resignation_termination_date = date('Y-m-d', strtotime(Yii::$app->request->post('rtDate')));
            $model->resignation_termination_reason = Yii::$app->request->post('rtReason');
            $model->rate_per_hour = Yii::$app->request->post('rate');
            $model->allowance = Yii::$app->request->post('allowance');
            $model->basic = Yii::$app->request->post('basic');
            $model->non_tax_allowance = Yii::$app->request->post('nontax_allowance');
            $model->levy_supplement = $levy_supplement;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->status = 1;

            if($model->validate()) {
                $model->save();
                return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }
        }
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new SearchStaff();
        
        $getStaffId = $searchModel->getStaffId();

        return $this->render('update', [
                    'model' => $model, 
                    'getStaffId' => $getStaffId,
                    'errTypeHeader' => '', 
                    'errType' => '', 
                    'msg' => ''
                ]);
    }

    public function actionEdit()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        $levy_supplement = (Yii::$app->request->post('levy_supplement') <> '')? Yii::$app->request->post('levy_supplement') : 0;

        $model->staff_group_id = Yii::$app->request->post('staff_group');
        $model->designated_position_id = Yii::$app->request->post('position');
        $model->staff_code = Yii::$app->request->post('code');
        $model->fullname = Yii::$app->request->post('fullname');
        $model->address = Yii::$app->request->post('address');
        $model->race_id = Yii::$app->request->post('race');
        $model->citizenship = Yii::$app->request->post('citizenship');
        $model->gender = Yii::$app->request->post('gender');
        $model->email = Yii::$app->request->post('email');
        $model->contact_number = Yii::$app->request->post('contact_no');
        $model->ic_no = Yii::$app->request->post('nric');
        $model->rate_per_hour = Yii::$app->request->post('rate');
        $model->allowance = Yii::$app->request->post('allowance');
        $model->basic = Yii::$app->request->post('basic');
        $model->non_tax_allowance = Yii::$app->request->post('nontax_allowance');
        $model->levy_supplement = $levy_supplement;
        $model->created_at = date('Y-m-d H:i:s');
        $model->created_by = Yii::$app->user->identity->id;
        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = Yii::$app->user->identity->id;
        $model->status = 1;

        if($model->validate()) {
           $model->save();
           return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success']);

        } else {
           return json_encode(['message' => $model->errors, 'status' => 'Error']);
        
        }
    }

    /**
     * Deletes an existing Staff model.
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
        $searchModel = new SearchStaff();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = $this->findModel($id);
        $model->status = 0;
        $model->save(); 
        
        Yii::$app->getSession()->setFlash('success', 'Your record was successfully deleted in the database.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() 
    {
        $result = Staff::find()->where(['status' => 1])->all();

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
             ->setCellValue('B1', 'Staff Code')
             ->setCellValue('C1', 'Fullname');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
                 
         $row = 2;
         $n = 0;

                foreach ($result as $result_row) {  
                    $n++;    

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$n); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['staff_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['fullname']);
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "StaffList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() 
    {
        $result = Staff::find()->where(['status' => 1])->all();
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('StaffList-' . date('m-d-Y'));
    }
}
