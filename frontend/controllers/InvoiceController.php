<?php

namespace frontend\controllers;

use Yii;
use common\models\SearchInvoice;
use common\models\Invoice;

class InvoiceController extends \yii\web\Controller
{
    public function actionIndex()
    {
       $searchModel = new SearchInvoice();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
       $session = Yii::$app->session;
       $id = $session->get('id');

        if( Yii::$app->request->get('date_start') <> "" && Yii::$app->request->get('date_end') <> "" ) {
            $getCustomerInvoice = $searchModel->getInvoiceByDateRangeForCustomer($id, Yii::$app->request->get('date_start'), Yii::$app->request->get('date_end'));
            $date_start = Yii::$app->request->get('date_start');
            $date_end = Yii::$app->request->get('date_end');

        } else {
            $getCustomerInvoice = $searchModel->getInvoiceForCustomer($id);
            $date_start = '';
            $date_end = '';

        }

       return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'getCustomerInvoice' => $getCustomerInvoice,
                        'date_start' => $date_start,
                        'date_end' => $date_end
                    ]);
    }

    public function actionView($id)
    {
    	$model = new Invoice();
        $searchModel = new SearchInvoice();

        $getProcessedInvoice = $searchModel->getProcessedInvoice($id); 
        $getProcessedServices = $searchModel->getProcessedServices($id); 
        $getProcessedParts = $searchModel->getProcessedParts($id);

        return $this->render('view',[
                'model' => $this->findModel($id),
                'customerInfo' => $getProcessedInvoice,
                'services' => $getProcessedServices,
                'parts' => $getProcessedParts
            ]);
    }

    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
