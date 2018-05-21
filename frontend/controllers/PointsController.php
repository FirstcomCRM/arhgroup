<?php

namespace frontend\controllers;

use Yii;
use common\models\Customer;
use common\models\SearchCustomer;

class PointsController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$searchModel = new SearchCustomer();

    	$session = Yii::$app->session;
    	$id = $session->get('id');
    	
        $getPoints = Customer::findOne($id);
        $customerPoints = $getPoints->points;
        
        $getRedeemPoints = $searchModel->getRedeemPoints($id);
        
        return $this->render('index', [
                                'customerPoints' => $customerPoints,
                                'getRedeemPoints' => $getRedeemPoints,
                            ]);
    }

}
