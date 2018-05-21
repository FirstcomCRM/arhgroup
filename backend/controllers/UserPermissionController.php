<?php

namespace backend\controllers;

use Yii;
use common\models\SearchUserPermission;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * UserPermissionController implements the CRUD actions for UserPermission model.
 */
class UserPermissionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'UserPermission'])->andWhere(['role_id' => $uRId ] )->andWhere(['status' => 1 ])->all();
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
     * Lists all UserPermission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUserPermission();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchUserPermission')['role_id'] ) || !empty(Yii::$app->request->get('SearchUserPermission')['controller'] )  || !empty(Yii::$app->request->get('SearchUserPermission')['action'] ) ) {
                $getUserPermission = $searchModel->searchUserPermissionNames(Yii::$app->request->get('SearchUserPermission')['role_id'],Yii::$app->request->get('SearchUserPermission')['controller'],Yii::$app->request->get('SearchUserPermission')['action']);

        }else {
                $getUserPermission = $searchModel->getUserPermission();

        }

        return $this->render('index', [
                        'searchModel' => $searchModel, 
                        'getUserPermission' => $getUserPermission, 
                        'dataProvider' => $dataProvider, 
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => ''
                    ]);
    }

    /**
     * Displays a single UserPermission model.
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
     * Creates a new UserPermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserPermission();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserPermission model.
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
     * Deletes an existing UserPermission model.
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
        // $this->findModel($id)->delete();
        // $model = $this->findModel($id);
        // $model->deleted = 1;
        // if ( $model->save() ) {
        //     Yii::$app->getSession()->setFlash('success', 'Customer deleted');
        // } else {
        //     Yii::$app->getSession()->setFlash('danger', 'Unable to delete Customer');
        // }
        $searchModel = new SearchUserPermission();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete(); 
       
        Yii::$app->getSession()->setFlash('success', 'Your record was successfully deleted in the database.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserPermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserPermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserPermission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetPermission() 
    {
        $model = new UserPermission();
        $searchModel = new SearchUserPermission();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $controllerlist = array();
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        $controllerList = array();
        foreach ($controllerlist as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $addDash = preg_replace('/\B([A-Z])/', '-$1', $display[1]);
                            $controllerList[substr($controller, 0, -4)][] = strtolower($addDash);
                            // d($addDash);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;

        $controllerActions = false;
        $userRoleId = 0;
        $controllerNameChosen = '';
        $controllerNameLong = '';
        $userRole = Role::find()->where(['status' => 1])->all();
        $permission = [];

        if ( isset( $_GET['c'] ) && !empty( $_GET['c'] ) && isset( $_GET['u'] ) && !empty( $_GET['u'] ) ) {
            $controllerName = $_GET['c'];
            $userRoleId = $_GET['u'];

            $controllerNameLong = $controllerName.'Controller';
            $controllerNameChosen = $controllerNameLong;
            $controllerActions = $controllerList[$controllerNameLong];
           
            $getPermission = UserPermission::find()->where(['role_id' => $userRoleId])->andWhere(['controller' => $controllerName])->all();
            foreach ( $getPermission as $gP ) {
                $permission[] = $gP->action;
            }
        }

        if ( Yii::$app->request->post() ) {

            $controllerNameLong = Yii::$app->request->post()['controllerName'];
            $getModelName = explode('Controller', $controllerNameLong);
            $controllerName = $getModelName[0];
            $userRoleId = Yii::$app->request->post()['userRole'];

            $controllerNameChosen = $controllerNameLong;
            $controllerActions = $controllerList[$controllerNameLong];
            $permission = [];
            $getPermission = UserPermission::find()->where(['role_id' => $userRoleId])->andWhere(['controller' => $controllerName])->all();
            foreach ( $getPermission as $gP ) {
                $permission[] = $gP->action;
            }

        if ( isset( Yii::$app->request->post()['checkBox'] ) && !empty ( Yii::$app->request->post()['checkBox'] ) )  {
                UserPermission::deleteAll("role_id = $userRoleId AND controller = '$controllerName' ");
                $checkBox = Yii::$app->request->post()['checkBox'] ;
                foreach ( $checkBox as $actions => $cB ) {
                    $newPermission = new UserPermission();
                    $newPermission->controller = $controllerName;
                    $newPermission->action = $actions;
                    $newPermission->role_id = $userRoleId;
                    $newPermission->status = 1;
                    $newPermission->save();
                }

                $getUserPermission = $searchModel->getUserPermission();
                
                Yii::$app->getSession()->setFlash('success', 'Your record was successfully added in the database.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('set-permission', [
                        'model' => $model, 
                        'userRole' => $userRole,
                        'userRoleId' => $userRoleId,
                        'controllerNameLong' => $controllerNameLong,
                        'controllerNameChosen' => $controllerNameChosen,
                        'controllerList' => $controllerList,
                        'controllerActions' => $controllerActions,
                        'permission' => $permission
                    ]);
    }
}
