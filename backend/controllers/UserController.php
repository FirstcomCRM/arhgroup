<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\SearchUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'User'])->andWhere(['role_id' => $uRId ] )->andWhere(['status' => 1 ])->all();
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchUser')['fullname'])) {
                $getUser = $searchModel->searchUserFullname(Yii::$app->request->get('SearchUser')['fullname']);
                
        }else {
                $getUser = $searchModel->getUser();
        }
        
        return $this->render('index', [
                        'searchModel' => $searchModel, 
                        'dataProvider' => $dataProvider, 
                        'getUser' => $getUser, 
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
                    ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new SearchUser();
        $getUserById = $model->getUserById($id);

        return $this->render('view', [
            'model' => $getUserById,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        return $this->render('create', [
                            'model' => $model, 
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
    }

    public function actionNew()
    {
        $model = new User();  

        if ( Yii::$app->request->post() ) {   

            $model->role_id = Yii::$app->request->post('role');
            $model->role = 20;
            $model->branch_id = Yii::$app->request->post('branch');
            $model->fullname = Yii::$app->request->post('fullname');
            $model->email = Yii::$app->request->post('email');
            $model->username = Yii::$app->request->post('username');
            $model->password = Yii::$app->request->post('password');
            $model->photo = 'user.png';
            $model->status = 1;
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->login = date("Y-m-d H:i:s");
            $model->deleted = 0;
            // echo "<pre>";
            // print_r($model);exit;
            if($model->validate()) {
                if ( !empty( $model->password ) ) {
                    $model->password_reset_token = 0;
                    $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                    $model->generateAuthKey();
                }

                if( $model->save() ) {
            
                   $auth = Yii::$app->authManager;
                   $userRoleId = $model->role_id;

                        if ( $userRoleId == 1) {
                             $userRole = $auth->getRole('developer');
                             $auth->assign($userRole, $model->id);
                        }
                        if ( $userRoleId == 2) {
                             $userRole = $auth->getRole('admin');
                             $auth->assign($userRole, $model->id);
                        }
                        if ( $userRoleId == 3) {
                             $userRole = $auth->getRole('staff');
                             $auth->assign($userRole, $model->id);
                        }
                        if ( $userRoleId == 4) {
                             $userRole = $auth->getRole('customer');
                             $auth->assign($userRole, $model->id);
                        }

                    return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);
                }

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }
        }
    }

    /**
     * Updates an existing User model.
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

        $model->role_id = Yii::$app->request->post('role');
        $model->branch_id = Yii::$app->request->post('branch');
        $model->fullname = Yii::$app->request->post('fullname');
        $model->email = Yii::$app->request->post('email');
        $model->username = Yii::$app->request->post('username');
        $model->password = Yii::$app->request->post('password');
        $model->updated_at = date('Y-m-d H:i:s');
        $model->updated_by = Yii::$app->user->identity->id;
        
        if ( !empty( $model->password ) ) {
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
            $model->generateAuthKey();
        }

        if($model->validate()) {
           $model->save();
           return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success']);

        } else {
           return json_encode(['message' => $model->errors, 'status' => 'Error']);
        
        }
    }

    /**
     * Deletes an existing User model.
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
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        Yii::$app->getSession()->setFlash('success', 'Your record was successfully deleted in the database.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() 
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $result = $searchModel->getUser();

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
             ->setCellValue('B1', 'Branch')
             ->setCellValue('C1', 'User-Role')
             ->setCellValue('D1', 'Fullname')
             ->setCellValue('E1', 'Email')
             ->setCellValue('F1', 'Status');
             
             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
    
         $row=2;
         $n = 0;

                foreach ($result as $result_row) {  
                    $n++;
                    $status = ( $result_row['status'] == 1 ) ? 'Active' : 'Inactive';     

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$n); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['role']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['fullname']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['email']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$status);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "UserList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() 
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $result = $searchModel->getUser();       
        $content = $this->renderPartial('_pdf', ['result' => $result]);
        
        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('UserList-' . date('m-d-Y'));
          

    }

}
