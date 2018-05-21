<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\LoginForm;

use common\models\SearchInventory;
use common\models\ProductLevel;
use common\models\SearchService;
use common\models\SearchCustomer;
use common\models\SearchPayment;
use common\models\SearchInvoice;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $inventoryModel = new SearchInventory();
        $serviceModel = new SearchService();
        $customerModel = new SearchCustomer();
        $dailysalesModel = new SearchPayment();
        $invoiceModel = new SearchInvoice();

        // customer list
        if( Yii::$app->request->post()) {
            if( Yii::$app->request->post('customerSearchkeyword') <> '' ){
                $getCustomerInvoiceBySearch = $customerModel->getCustomerInvoiceBySearch(Yii::$app->request->post('customerSearchkeyword'));
                $keywordValue = Yii::$app->request->post('customerSearchkeyword');
            
            } else {
                $getCustomerInvoiceBySearch = '';
                $keywordValue = '';
            }

        }else{
                $getCustomerInvoiceBySearch = '';
                $keywordValue = '';
                
        }

        // pending services dashboard
        $pendingInvoiceServices = $serviceModel->getPendingInvoiceServices();

        // products dashboard
        $getZeroStock = $inventoryModel->getZeroStock();
        $getTotalZeroStock = count($inventoryModel->getTotalZeroStock());

        $getPartLevel = ProductLevel::find()->one();
        $criticalLevel = $getPartLevel->critical_level;
        $minimumLevel = $getPartLevel->minimum_level;

        $getCriticalStock = $inventoryModel->getCriticalStock();
        $getTotalCriticalStock = count($inventoryModel->getTotalCriticalStock());
        $getWarningStock = $inventoryModel->getWarningStock($minimumLevel);
        $getTotalWarningStock = count($inventoryModel->getTotalWarningStock($minimumLevel));

        // daily sales
        $getTotalDailySales = $dailysalesModel->getTotalDailySales();
        $getTotalDailyCashSales = $dailysalesModel->getTotalDailyCashSales();
        $getTotalDailyCreditCardSales = $dailysalesModel->getTotalDailyCreditCardSales();
        $getTotalDailyNetsSales = $dailysalesModel->getTotalDailyNetsSales();
        
        $session = Yii::$app->session;

        $session->open();
        $session->set('getTotalDailyCashSales', $getTotalDailyCashSales);
        $session->set('getTotalDailyCreditCardSales', $getTotalDailyCreditCardSales);
        $session->set('getTotalDailyNetsSales', $getTotalDailyNetsSales);
        $session->close();

        // oustanding payments in invoices dashboard
        $oustandingpaymentsInvoice = $invoiceModel->getInvoiceWithOutstandingPayments();

        return $this->render('index', [
                        'getZeroStock' => $getZeroStock, 
                        'getTotalZeroStock' => $getTotalZeroStock,
                        'getCriticalStock' => $getCriticalStock, 
                        'getTotalCriticalStock' => $getTotalCriticalStock,
                        'getWarningStock' => $getWarningStock, 
                        'getTotalWarningStock' => $getTotalWarningStock,
                        'pendingInvoiceServices' => $pendingInvoiceServices,
                        'getCustomerInvoiceBySearch' => $getCustomerInvoiceBySearch,
                        'keywordValue' => $keywordValue,
                        'getTotalDailySales' => $getTotalDailySales,
                        'getTotalDailyCashSales' => $getTotalDailyCashSales,
                        'getTotalDailyCreditCardSales' => $getTotalDailyCreditCardSales,
                        'getTotalDailyNetsSales' => $getTotalDailyNetsSales,
                        'oustandingpaymentsInvoice' => $oustandingpaymentsInvoice,
                    ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout=false;
        
        if (!Yii::$app->user->isGuest) {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        if($session->isActive){
            $session->destroy();
            Yii::$app->cache->flush();
            
            Yii::$app->user->logout();

            return $this->goHome();
        }
    }

    public function actionAutoComplete()
    {
        $serviceModel = new SearchService();

        // pending services dashboard
        $pendingInvoiceServices = $serviceModel->getPendingInvoiceServices();

        return json_encode($pendingInvoiceServices);
    }

}
