<?php

namespace frontend\controllers;

use Yii;
use common\models\SearchService;

class ServiceController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$searchModel = new SearchService();
    	$getServicesList = $searchModel->getServices();

        return $this->render('index',[
        				'getServicesList' => $getServicesList]);
    }

}
