<?php

namespace backend\controllers;

use Yii;
use common\models\Inventory;
use common\models\SearchInventory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
use common\models\Product;

use yii\data\Pagination;

/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Inventory'])->andWhere(['role_id' => $uRId ] )->andWhere(['status' => 1 ])->all();
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
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInventory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchInventory')['type'])) {
            $getParts = $searchModel->getPartsInInventoryByType(Yii::$app->request->get('SearchInventory')['type']);
            
            /* pagination */
            $countParts = clone $getParts;
            $pages = new Pagination(['totalCount' => $countParts->count()]);
            $partsList = $getParts->offset($pages->offset)
                    ->limit($pages->limit)
                    ->orderBy(['id' => SORT_DESC])
                    ->all();

        }else {
            $getParts = $searchModel->getPartsInInventory();

            /* pagination */
            $countParts = clone $getParts;
            $pages = new Pagination(['totalCount' => $countParts->count()]);
            $partsList = $getParts->offset($pages->offset)
                    ->limit($pages->limit)
                    ->orderBy(['id' => SORT_DESC])
                    ->all();

        }

        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'getParts' => $partsList, 
                    'pages' => $pages,
                    'dataProvider' => $dataProvider, 
                    'errTypeHeader' => '', 
                    'errType' => '', 
                    'msg' => ''
        ]);
    }

    /**
     * Displays a single Inventory model.
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
     * Creates a new Inventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inventory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Inventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Inventory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Inventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inventory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() 
    {
        $searchModel = new SearchInventory();
        if( !empty(Yii::$app->request->get('SearchInventory')['type'])) {
            $result = $searchModel->getPartsInInventoryByType(Yii::$app->request->get('SearchInventory')['type']);
        
        }else {
            $result = $searchModel->getPartsInInventory();

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
             ->setCellValue('C1', 'Product Code')
             ->setCellValue('D1', 'Product Name')
             ->setCellValue('E1', 'Unit of Measure')
             ->setCellValue('F1', 'Old Quantity')
             ->setCellValue('G1', 'New Quantity')
             ->setCellValue('H1', 'Invoice No.')
             ->setCellValue('I1', 'Inventory Type');

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
                                
                foreach ($result as $result_row) {  
                    
                    if($result_row['type'] == 1){
                        $inventoryType = 'Stock-In';

                    }elseif($result_row['type'] == 2){
                        $inventoryType = 'Stock-Out';

                    }else{
                        $inventoryType = 'Stock-Adjustment';
                    }    

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['supplier_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['product_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['unit_of_measure']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['old_quantity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['new_quantity']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,($result_row['invoice_no'])? $result_row['invoice_no']: 'N/A');
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$inventoryType);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "PartsInventoryList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() 
    {

        $searchModel = new SearchInventory();
        if( !empty(Yii::$app->request->get('SearchInventory')['type'])) {
            $result = $searchModel->getPartsInInventoryByType(Yii::$app->request->get('SearchInventory')['type']);
        
        }else {
            $result = $searchModel->getPartsInInventory();

        }

        $content = $this->renderPartial('_pdf', ['result' => $result]);
        
        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('PartsInventoryList-' . date('m-d-Y'));  
    }

}
