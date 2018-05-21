<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\SearchProduct;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;

use common\models\Inventory;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Product'])->andWhere(['role_id' => $uRId ] )->andWhere(['status' => 1 ])->all();
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->searchForIndex(Yii::$app->request->queryParams);
        
        if( !empty(Yii::$app->request->get('SearchProduct')['category_id'] ) || !empty(Yii::$app->request->get('SearchProduct')['product_name'] ) ) {
                $getProduct = $searchModel->searchProductName(Yii::$app->request->get('SearchProduct')['category_id'], Yii::$app->request->get('SearchProduct')['product_name']);

        }else {
                $getProduct = $searchModel->getProducts();

        }

        return $this->render('index', [
                        'searchModel' => $searchModel, 
                        'dataProvider' => $dataProvider, 
                        'getProduct' => $getProduct, 
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
                    ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = new SearchProduct();
        $getProducts = $model->getProductById($id);

        return $this->render('view', [
            'model' => $getProducts,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->searchForIndex(Yii::$app->request->queryParams);
        $getProduct = $searchModel->getProducts();

        if ($model->load(Yii::$app->request->post()) ) {
        
                $uploadedFile = UploadedFile::getInstance($model,'product_image');
                $fileName = "{$uploadedFile}";  // random number + file name

                $model->supplier_id = Yii::$app->request->post('Product')['supplier_id'];
                $model->category_id = Yii::$app->request->post('Product')['category_id'];
                $model->product_code = Yii::$app->request->post('Product')['product_code'];
                $model->product_name = Yii::$app->request->post('Product')['product_name'];
                $model->unit_of_measure = Yii::$app->request->post('Product')['unit_of_measure'];
                $model->quantity = Yii::$app->request->post('Product')['quantity'];
                $model->cost_price = Yii::$app->request->post('Product')['cost_price'];
                $model->gst_price = Yii::$app->request->post('Product')['gst_price'];
                $model->selling_price = Yii::$app->request->post('Product')['selling_price'];
                $model->reorder_level = Yii::$app->request->post('Product')['reorder_level'];
                $model->status = 1;
                $model->created_at = date('Y-m-d');
                $model->created_by = Yii::$app->user->identity->id;
                
                if( isset($uploadedFile) ){
                    $model->product_image = $fileName;
                    if( $model->save() ){

                        $uploadedFile->saveAs('assets/products/'.$fileName);

                        $inventoryModel = new Inventory();

                        $inventoryModel->product_id = $model->id;
                        $inventoryModel->old_quantity = Yii::$app->request->post('Product')['quantity'];
                        $inventoryModel->new_quantity = Yii::$app->request->post('Product')['quantity'];
                        $inventoryModel->type = 1;
                        $inventoryModel->datetime_imported = date('Y-m-d H:i:s');
                        $inventoryModel->created_at = date('Y-m-d H:i:s');
                        $inventoryModel->created_by = Yii::$app->user->identity->id;
                        $inventoryModel->status = 1;
                        $inventoryModel->save();

                        Yii::$app->getSession()->setFlash('success', 'Your record was successfully added in the database.');
                        return $this->redirect(['index']);
                    }

                }else{
                    if( $model->save() ){

                        $inventoryModel = new Inventory();

                        $inventoryModel->product_id = $model->id;
                        $inventoryModel->old_quantity = Yii::$app->request->post('Product')['quantity'];
                        $inventoryModel->new_quantity = Yii::$app->request->post('Product')['quantity'];
                        $inventoryModel->type = 1;
                        $inventoryModel->datetime_imported = date('Y-m-d H:i:s');
                        $inventoryModel->created_at = date('Y-m-d H:i:s');
                        $inventoryModel->created_by = Yii::$app->user->identity->id;
                        $inventoryModel->status = 1;
                        $inventoryModel->save();

                        Yii::$app->getSession()->setFlash('success', 'Your record was successfully added in the database.');
                        return $this->redirect(['index']);
                    }
                }

            }
          
            return $this->render('create', [
                            'model' => $model, 
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->searchForIndex(Yii::$app->request->queryParams);
        $getProduct = $searchModel->getProducts();
        
        if ( $model->load(Yii::$app->request->post()) ) {
            
                $product = Product::findOne($id);

                $uploadedFile = UploadedFile::getInstance($product,'product_image');
                $fileName = "{$uploadedFile}";  // random number + file name

                $product->supplier_id = Yii::$app->request->post('Product')['supplier_id'];
                $product->category_id = Yii::$app->request->post('Product')['category_id'];
                $product->product_code = Yii::$app->request->post('Product')['product_code'];
                $product->product_name = Yii::$app->request->post('Product')['product_name'];
                $product->unit_of_measure = Yii::$app->request->post('Product')['unit_of_measure'];
                $product->quantity = Yii::$app->request->post('Product')['quantity'];
                $product->cost_price = Yii::$app->request->post('Product')['cost_price'];
                $product->gst_price = Yii::$app->request->post('Product')['gst_price'];
                $product->selling_price = Yii::$app->request->post('Product')['selling_price'];
                $product->reorder_level = Yii::$app->request->post('Product')['reorder_level'];
                $product->status = 1;
                $product->created_at = date('Y-m-d');
                $product->created_by = Yii::$app->user->identity->id;

                if( isset($uploadedFile) ){
                    
                    $product->product_image = $fileName;
                    if( $product->save() ){
                        $uploadedFile->saveAs('assets/products/'.$fileName);

                        Yii::$app->getSession()->setFlash('success', 'Your record was successfully updated in the database.');
                        return $this->redirect(['index']);
                    }

                }else{
                    if( $product->save() ){
                     
                        Yii::$app->getSession()->setFlash('success', 'Your record was successfully updated in the database.');
                        return $this->redirect(['index']);
                    }

                }

            } 

            $getProducts = $searchModel->getProductById($id);

            return $this->render('update', [
                            'model' => $model, 
                            'getProducts' => $getProducts, 
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
    }

    /**
     * Deletes an existing Product model.
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
        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->searchForIndex(Yii::$app->request->queryParams);
        
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();
           
        Yii::$app->getSession()->setFlash('success', 'Your record was successfully deleted in the database.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() 
    {
        $searchModel = new SearchProduct();
        $result = $searchModel->getProducts();

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
             ->setCellValue('B1', 'Parts-Category')
             ->setCellValue('C1', 'Product Code')
             ->setCellValue('D1', 'Product Name')
             ->setCellValue('E1', 'Unit of Measure');

            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
            $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);

         $row=2;
                                
                foreach ($result as $result_row) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['category']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['product_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['unit_of_measure']);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "PartsList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() 
    {

        $searchModel = new SearchProduct();
        $result = $searchModel->getProducts();

        $content = $this->renderPartial('_pdf', ['result' => $result]);
        
        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('PartsList-' . date('m-d-Y'));  
    }

     public function actionEditQty()
    {  
        if( Yii::$app->request->post('partsChkbox') <> "" ) {

            foreach( Yii::$app->request->post('partsChkbox') as $key => $value) {
                 $result = explode('|', $value);

                 $array = array(
                            'itemId' => $result[0], 
                            'itemName' => $result[1], 
                            'itemQty' => $result[2],  
                            'SupplierId' => $result[3], 
                            'costPrice' => $result[4], 
                            'sellingPrice' => $result[5]
                        );
                 
                 $data[] = $array;    
            }

            return $this->render('_form-update-qty', ['data' => $data]);

        }else {

            Yii::$app->getSession()->setFlash('success', 'No record selected.');
            return $this->redirect(['index']);
        }
    }

    public function actionUpdateStocksQuantity() 
    {
        if( Yii::$app->request->post() ){

            foreach( Yii::$app->request->post('partsNewQty') as $key => $value ) {

                $partsInfo = Product::find()->where(['id' => Yii::$app->request->post('partsId')[$key] ])->andWhere(['supplier_id' => Yii::$app->request->post('supplierId')[$key] ])->one();
                $partsInfo->quantity = Yii::$app->request->post('partsNewQty')[$key];
                $partsInfo->save();
                
                $inventory = new Inventory();
                $inventory->product_id = Yii::$app->request->post('partsId')[$key];
                $inventory->old_quantity = Yii::$app->request->post('partsOldQty')[$key];
                $inventory->new_quantity = Yii::$app->request->post('partsNewQty')[$key];
                $inventory->type = 3;
                $inventory->datetime_imported = date('Y-m-d H:i:s');
                $inventory->created_at = date("Y-m-d H:i:s");
                $inventory->created_by = Yii::$app->user->identity->id;
                $inventory->status = 1;
                
                $inventory->save();
            }

            Yii::$app->getSession()->setFlash('success', 'Your record was successfully updated in the database.');
            return $this->redirect(['index']);

        }
    }

    public function actionGetProductInformation()
    {
        $searchModel = new SearchProduct();
        $getProduct = $searchModel->getProductInformation(Yii::$app->request->get('productId'));

        $data = array();
        $data['id'] = $getProduct['id'];
        $data['supplier_name'] = $getProduct['supplier_name'];
        $data['product_code'] = $getProduct['product_code'];
        $data['product_name'] = $getProduct['product_name'];
        $data['quantity'] = $getProduct['quantity'];

        return json_encode($data);
    }

    public function actionUpdateStockQuantity()
    {
        $inventoryModel = new Inventory();
        $inventoryModel->product_id = Yii::$app->request->post('productId');
        $inventoryModel->old_quantity = Yii::$app->request->post('oldQty');
        $inventoryModel->new_quantity = Yii::$app->request->post('newQty');
        $inventoryModel->type = 3;
        $inventoryModel->datetime_imported = date('Y-m-d H:i:s');
        $inventoryModel->created_at = date("Y-m-d H:i:s");
        $inventoryModel->created_by = Yii::$app->user->identity->id;
        $inventoryModel->status = 1;
        
        $inventoryModel->save();

        $productModel = Product::findOne(Yii::$app->request->post('productId'));
        $productModel->quantity = Yii::$app->request->post('newQty');
        $productModel->save();

        return json_encode(['result' => 'success']);
    }

}









