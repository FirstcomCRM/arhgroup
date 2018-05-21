<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SearchJob Sheet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quotation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); 
    $model->branch = isset($params['branch']) ? $params['branch']: '';
    $model->username = isset($params['username']) ? $params['username']: '';
    ?>
    <div class="row form-group">
            <div class='col-sm-offset-1 col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'quotation_code')->textInput(['autocomplete' => 'off', 'placeholder' => 'Quotation No.', 'value'=>isset($params['quotation_code']) ? $params['quotation_code']:''])->label(false) ?>
            </div>
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'date_from')->textInput(['autocomplete' => 'off', 'placeholder' => 'Date From', 'id'=>'datestart', 'value' =>isset($params['date_from']) ? $params['date_from'] : '', 'readonly'=>true])->label(false) ?>
            </div>
            <div class='col-sm-2 col-xs-12'>    
                <?= $form->field($model, 'date_to')->textInput(['autocomplete' => 'off', 'placeholder' => 'Date To', 'id'=>'dateend', 'value' =>isset($params['date_to']) ? $params['date_to'] : '' , 'readonly'=>true])->label(false) ?>
            </div>
            <div class='col-sm-3 col-xs-12'>    
                <?= $form->field($model, 'branch')->dropDownList( $branches, ['class' => 'select2_single form-control', 'prompt' =>'Branch', 'data-placeholder' => 'Branch'])->label(false) ?>
            </div>
    </div>
    <div class="row">
        <div class='col-sm-offset-1 col-sm-2 col-xs-12'>    
            <?= $form->field($model, 'username')->dropDownList( $staff, ['class' => 'select2_single form-control', 'prompt' =>'Staff', 'data-placeholder' => 'Staff'])->label(false) ?>
        </div>
        <div class='col-sm-2 col-xs-12'>    
            <?= $form->field($model, 'carplate')->textInput(['autocomplete' => 'off', 'placeholder' => 'Car Plate', 'value'=>isset($params['carplate']) ? $params['carplate']:''])->label(false) ?>
        </div>
        <div class='col-sm-2 col-xs-12'>    
            <?= $form->field($model, 'cust_name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Customer Name', 'value'=>isset($params['cust_name']) ? $params['cust_name']:''])->label(false) ?>
        </div>
    </div>

    <div class="col-sm-12 text-right">
        <div class="form-group">
            <?= Html::submitButton('<i class=\'fa fa-search\'></i> Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
