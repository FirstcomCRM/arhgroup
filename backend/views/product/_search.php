<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */
$dataCategory = ArrayHelper::map(Category::find()->all(), 'id', 'category');
?>

<div class="row">

    <div class="col-md-12">
        <div class="search-label-container">
            <span class="search-label"><li class="fa fa-edit"></li> Enter Keyword here</span>
        </div> 
    </div>
    <br/>
    
    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get', 'class' => 'form-inline']); ?>

    <div class="col-md-3">
        <?= $form->field($model, 'category_id')->dropDownList(['0' => '- SELECT PARTS-CATEGORY HERE-'] + $dataCategory,['style' => 'width:100%;', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE PARTS CATEGORY HERE'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'product_name')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Part Name here.'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <div style="margin-left: -10px;">
            <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'form-btn btn btn-primary']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
    <br/>

 </div>











