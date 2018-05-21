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

use common\models\StockIn;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class StocksController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Stocks'])->andWhere(['role_id' => $uRId ] )->andWhere(['status' => 1 ])->all();
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Inventory();

        $searchModel = new SearchInventory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getProductInInventory = $searchModel->getProductInInventory();

        return $this->render('index', [
                                'model' => $model, 
                                'searchModel' => $searchModel, 
                                'dataProvider' => $dataProvider, 
                                'getProductInInventory' => $getProductInInventory, 
                                'errTypeHeader' => '', 
                                'errType' => '', 
                                'msg' => ''
                            ]);
    }

    public function actionCreate() 
    {
        if( Yii::$app->request->post('updateQty') <> "" ) {
            foreach( Yii::$app->request->post('updateQty') as $key => $value) {
                 $result = explode('|', $value);

                 $array = array(
                            'itemId' => $result[0], 
                            'itemName' => $result[1], 
                            'itemQty' => $result[2], 
                            'ProductId' => $result[3], 
                            'SupplierId' => $result[4], 
                            'costPrice' => $result[5], 
                            'sellingPrice' => $result[6]
                        );
                 
                 $data[] = $array;    
            }

            return $this->render('update', ['data' => $data]);

        }else {

                $model = new Inventory();
                $searchModel = new SearchInventory();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $getProductInInventory = $searchModel->getProductInInventory();

                return $this->render('index', [
                                    'model' => $model, 
                                    'searchModel' => $searchModel, 
                                    'dataProvider' => $dataProvider, 
                                    'getProductInInventory' => $getProductInInventory, 
                                    'errTypeHeader' => 'Error!', 
                                    'errType' => 'alert alert-error', 
                                    'msg' => 'You have an error, No record selected.'
                                ]);
        }

    }

    public function actionUpdate() 
    {
        foreach( Yii::$app->request->post('qtyStock') as $key => $value ) {

            $inventory = Inventory::find()->where(['id' => Yii::$app->request->post('inventoryId')[$key] ])->andWhere(['supplier_id' => Yii::$app->request->post('SupplierId')[$key] ])->one();
            $inventory->quantity = Yii::$app->request->post('qtyStock')[$key];
            $inventory->save();
            
            $stockin = new StockIn();
            $stockin->product_id = Yii::$app->request->post('ProductId')[$key];
            $stockin->supplier_id = Yii::$app->request->post('SupplierId')[$key];
            $stockin->quantity = Yii::$app->request->post('qtyStock')[$key];
            $stockin->cost_price = Yii::$app->request->post('costPrice')[$key];
            $stockin->selling_price = Yii::$app->request->post('sellingPrice')[$key];
            $stockin->date_imported = date('Y-m-d');
            $stockin->time_imported = date('H:i:s');
            $stockin->created_at = date("Y-m-d");
            $stockin->created_by = Yii::$app->user->identity->id;
            
            $stockin->save();
        }

        $model = new Inventory();
        $searchModel = new SearchInventory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getProductInInventory = $searchModel->getProductInInventory();

        return $this->render('index', [
                            'model' => $model, 
                            'searchModel' => $searchModel, 
                            'dataProvider' => $dataProvider, 
                            'getProductInInventory' => $getProductInInventory, 
                            'errTypeHeader' => 'Success!', 
                            'errType' => 'alert alert-success', 
                            'msg' => 'Record was successfully updated.'
                        ]);
    }

}    