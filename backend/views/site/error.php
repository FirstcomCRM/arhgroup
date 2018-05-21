<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use common\models\ServiceCategory;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $name;

?>

<div class="row form-container">

<div class="alert alert-danger">
    <h1><i class="fa fa-warning"></i> <?= Html::encode($this->title) ?></h1>
</div>
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">

    <p><b> - You're not allowed to access this webpage. </b></p>
    <p><b> - The above error occurred while the Web server was processing your request. </b></p>
    <p><b> - Please contact us if you think this is a server error. Thank you. </b></p>
    <br/><hr/>

    <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?> 

    <div><br/></div> 
 
 </div>

</div>
<br/>

