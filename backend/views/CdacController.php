<?php

namespace backend\controllers;

use Yii;
use common\models\Cdac;
use common\models\SearchCdac;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * CdacController implements the CRUD actions for Cdac model.
 */
class CdacController extends Controller
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
            $permission = UserPermission::find()->where(['controller' => 'Cdac'])->andWhere(['role_id' => $uRId ])->andWhere(['status' => 1 ])->all();
            
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
     * Lists all Cdac models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Cdac();
        $searchModel = new SearchCdac();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchCdac')['from_age']) || !empty(Yii::$app->request->get('SearchCdac')['to_age'])) {
                $getCdac = $searchModel->SearchCdacSalary(Yii::$app->request->get('SearchCdac')['from_salary'],Yii::$app->request->get('SearchCdac')['to_salary']);

        }else {
                $getCdac = Cdac::find()->where(['status' => 1])->all();

        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'getCdac' => $getCdac,
            'model' => $model,
            'errTypeHeader' => '', 
            'errType' => '', 
            'msg' => ''
        ]);
    }

    /**
     * Displays a single Cdac model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cdac model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cdac();

        return $this->render('create', [
                            'model' => $model, 
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
    }

    public function actionNew()
    {
        $model = new Cdac();  

        if ( Yii::$app->request->post() ) {   

            $model->from_salary = Yii::$app->request->post('fromSalary');
            $model->to_salary = Yii::$app->request->post('toSalary');
            $model->minimum_monthly_contribution = Yii::$app->request->post('minimumMonthlyContribution');
            $model->date_time_created = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;

            if($model->validate()) {
                $model->save();
                return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);

            }
        }
    }

    /**
     * Updates an existing Cdac model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        return $this->render('update', [
                        'model' => $model, 
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
                    ]); 
    }

     public function actionEdit()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        $model->from_salary = Yii::$app->request->post('fromSalary');
        $model->to_salary = Yii::$app->request->post('toSalary');
        $model->minimum_monthly_contribution = Yii::$app->request->post('minimumMonthlyContribution');
        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = Yii::$app->user->identity->id;
      
        if($model->validate()) {
           $model->save();
           return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success']);

        } else {
           return json_encode(['message' => $model->errors, 'status' => 'Error']);
        
        }
    }


    /**
     * Deletes an existing Cdac model.
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
        $searchModel = new SearchCdac();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        Yii::$app->getSession()->setFlash('success', 'Your record was successfully deleted in the database.');
        return $this->redirect(['index']);
    }
    /**
     * Finds the Cdac model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cdac the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cdac::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // public function actionExportExcel() 
    // {
    //     $result = Cpf::find()->where('id > 1')->andWhere(['status' => 1])->all();

    //     $objPHPExcel = new \PHPExcel();
    //     $styleHeadingArray = array(
    //         'font'  => array(
    //         'bold'  => true,
    //         'color' => array('rgb' => '000000'),
    //         'size'  => 11,
    //         'name'  => 'Calibri'
    //     ));

    //     $sheet=0;
          
    //     $objPHPExcel->setActiveSheetIndex($sheet);
        
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
    //         $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
    //          ->setCellValue('A1', '#')
    //          ->setCellValue('B1', 'From Age')
    //          ->setCellValue('C1', 'To Age')
    //          ->setCellValue('D1', 'Employee Cpf')
    //          ->setCellValue('E1', 'Employer Cpf')
    //          ->setCellValue('F1', 'Description');
             
    //          $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
    //          $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
    //          $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
    //          $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
    //          $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
    //          $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
                
    //      $row=2;
    //      $n = 0;

    //             foreach ($result as $result_row) {  
    //                 $n++;        
    //                 $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$n); 
    //                 $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['from_age']);
    //                 $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['to_age']);
    //                 $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['employee_cpf']);
    //                 $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['employer_cpf']);
    //                 $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['description']);

    //                 $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
    //                 $row++ ;
    //             }
                        
    //     header('Content-Type: application/vnd.ms-excel');
    //     $filename = "CpfList-".date("m-d-Y").".xls";
    //     header('Content-Disposition: attachment;filename='.$filename);
    //     header('Cache-Control: max-age=0');
    //     $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    //     $objWriter->save('php://output');                

    // }

    // public function actionExportPdf() 
    // {
    //     $result = Cpf::find()->where('id > 1')->andWhere(['status' => 1])->all();
    //     $content = $this->renderPartial('_pdf', ['result' => $result]);

    //     $dompdf = new Dompdf();

    //     $dompdf->loadHtml($content);
    //     $dompdf->setPaper('A4', 'landscape');
    //     $dompdf->render();

    //     $dompdf->stream('CpfList-' . date('m-d-Y'));
    // }

}
