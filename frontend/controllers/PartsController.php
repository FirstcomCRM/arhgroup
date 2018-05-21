<?php

namespace frontend\controllers;

use Yii;
use common\models\SearchInventory;

class PartsController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$searchModel = new SearchInventory();
    	$getProductInInventory = $searchModel->getProductInInventory();

        return $this->render('index', [
        				'getProductInInventory' => $getProductInInventory ]);
    }

}
