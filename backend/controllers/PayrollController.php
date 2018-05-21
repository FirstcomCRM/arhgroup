<?php

namespace backend\controllers;

use Yii;
use common\models\Payroll;
use common\models\SearchPayroll;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use common\models\Staff;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * PayrollController implements the CRUD actions for Payroll model.
 */
class PayrollController extends Controller
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
            $permission = UserPermission::find()->where(['controller' => 'Payroll'])->andWhere(['role_id' => $uRId ])->andWhere(['status' => 1 ])->all();
            
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
     * Lists all Payroll models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPayroll();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchPayroll')['staff_id'])) {
            $getPayroll = $searchModel->searchStaffName(Yii::$app->request->get('SearchPayroll')['staff_id']);
        
        }else {
            $getPayroll = $searchModel->getPayrolls();

        }

        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'getPayroll' => $getPayroll, 
                    'dataProvider' => $dataProvider, 
                    'errTypeHeader' => '', 
                    'errType' => '', 
                    'msg' => ''
        ]);
    }

    /**
     * Displays a single Payroll model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new SearchPayroll();

        return $this->render('view', [
            'model' => $searchModel->getPayrollById($id),
        ]);
    }

    /**
     * Creates a new Payroll model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payroll();
        $editStatus = '';

        return $this->render('create', [
                            'model' => $model, 
                            'editStatus' => $editStatus,
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
    }

    public function actionNew()
    {
        $model = new Payroll();  
        $searchModel = new SearchPayroll();

        if ( Yii::$app->request->post() ) {   

            $cutoffYr = date('y', strtotime(Yii::$app->request->post('cutoff')) );
            $getLastId = $searchModel->getPayrollId();
            $getStaffInfo = Staff::findOne(Yii::$app->request->post('staff_name'));

            $payslipNo = 'PS' . '/' . $cutoffYr . '/' . $getStaffInfo['staff_code'] . '/' . $getLastId;

            $employer_cpf = (Yii::$app->request->post('employer_cpf') <> '')? Yii::$app->request->post('employer_cpf') : 0;
            $employee_cpf = (Yii::$app->request->post('employee_cpf') <> '')? Yii::$app->request->post('employee_cpf') : 0;
            $monthly_levy_charge = (Yii::$app->request->post('monthly_levycharge') <> '')? Yii::$app->request->post('monthly_levycharge') : 0;

            $model->payslip_no = $payslipNo;
            $model->payslip_cutoff = date('M-Y', strtotime(Yii::$app->request->post('cutoff')) );
            $model->date_issue = date('Y-m-d', strtotime(Yii::$app->request->post('date_issue')) );
            $model->staff_id = Yii::$app->request->post('staff_name');
            $model->overtime_hour = Yii::$app->request->post('ot_hour');
            $model->overtime_rate_per_hour = Yii::$app->request->post('ot_ratehour');
            $model->overtime_pay = Yii::$app->request->post('ot_pay');
            $model->employer_cpf = $employer_cpf;
            $model->employee_cpf = $employee_cpf;
            $model->cash_advance = Yii::$app->request->post('cash_advance');
            $model->other_deductions = Yii::$app->request->post('other_deduction');
            $model->monthly_levy_charge = $monthly_levy_charge;
            $model->remarks = Yii::$app->request->post('notes');
            $model->prepared_by = Yii::$app->request->post('prepared_by');
            $model->approved_by = Yii::$app->request->post('approved_by');
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
     * Updates an existing Payroll model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $editStatus = 'disabled';
        
        return $this->render('update', [
                        'model' => $model, 
                        'editStatus' => $editStatus,
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
                    ]);
    }

    public function actionEdit()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));
        $searchModel = new SearchPayroll();

        $cutoffYr = date('y', strtotime(Yii::$app->request->post('cutoff')) );
        $getLastId = $searchModel->getPayrollId();
        $getStaffInfo = Staff::findOne(Yii::$app->request->post('staff_name'));

        $payslipNo = 'PS' . '/' . $cutoffYr . '/' . $getStaffInfo['staff_code'] . '/' . $getLastId;

        $employer_cpf = (Yii::$app->request->post('employer_cpf') <> '')? Yii::$app->request->post('employer_cpf') : 0;
        $employee_cpf = (Yii::$app->request->post('employee_cpf') <> '')? Yii::$app->request->post('employee_cpf') : 0;
        $monthly_levy_charge = (Yii::$app->request->post('monthly_levycharge') <> '')? Yii::$app->request->post('monthly_levycharge') : 0;

        $model->payslip_no = $payslipNo;
        $model->payslip_cutoff = date('M-Y', strtotime(Yii::$app->request->post('cutoff')) );
        $model->date_issue = date('Y-m-d', strtotime(Yii::$app->request->post('date_issue')) );
        $model->staff_id = Yii::$app->request->post('staff_name');
        $model->overtime_hour = Yii::$app->request->post('ot_hour');
        $model->overtime_rate_per_hour = Yii::$app->request->post('ot_ratehour');
        $model->overtime_pay = Yii::$app->request->post('ot_pay');
        $model->employer_cpf = $employer_cpf;
        $model->employee_cpf = $employee_cpf;
        $model->cash_advance = Yii::$app->request->post('cash_advance');
        $model->other_deductions = Yii::$app->request->post('other_deduction');
        $model->monthly_levy_charge = $monthly_levy_charge;
        $model->remarks = Yii::$app->request->post('notes');
        $model->prepared_by = Yii::$app->request->post('prepared_by');
        $model->approved_by = Yii::$app->request->post('approved_by');
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
     * Deletes an existing Payroll model.
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
        $searchModel = new SearchPayroll();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        Yii::$app->getSession()->setFlash('success', 'Your record was successfully deleted in the database.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Payroll model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payroll the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payroll::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrintLocalPayslip($id)
    {
        $this->layout = 'print';
        $searchModel = new SearchPayroll();

        $getPayrollInformation = $searchModel->getPayrolInformationById($id); 

        return $this->render('_print-local-payslip',[
                            'model' => $this->findModel($id),
                            'payrollInformation' => $getPayrollInformation,
                        ]);
    }

    public function actionPrintForeignPayslip($id)
    {
        $this->layout = 'print';
        $searchModel = new SearchPayroll();

        $getPayrollInformation = $searchModel->getPayrolInformationById($id); 

        return $this->render('_print-foreign-payslip',[
                            'model' => $this->findModel($id),
                            'payrollInformation' => $getPayrollInformation,
                        ]);
    }

    public function actionGetStaffCitizenship()
    {
        $getStaffInfo = Staff::findOne(Yii::$app->request->get('staffId'));

        return $getStaffInfo->citizenship;
    }

}
