<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Customer;
use common\models\CarInformation;
use common\models\Branch;
use common\models\User;

$data = Customer::find()->orderBy(['fullname'=>SORT_ASC])->all();
$cust =ArrayHelper::map($data,'fullname','fullname');
$cust_com = ArrayHelper::map($data,'company_name','company_name');
$data = CarInformation::find()->orderBy(['carplate'=>SORT_ASC])->all();
$plate = ArrayHelper::map($data,'carplate','carplate');
$data = Branch::find()->orderBy(['name'=>SORT_ASC])->all();
$branch = ArrayHelper::map($data,'id','code');
$data = User::find()->orderBy(['fullname'=>SORT_ASC])->all();
$users = ArrayHelper::map($data,'id','fullname');
?>

<div class="carplate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['carplate-report'],
        'method' => 'get',
    ]); ?>
    <div class="row">
      <div class="col-md-4">
        <?= $form->field($model, 'customer_name')->dropDownList($cust,['class'=>'select2_single form-control', 'prompt'=>'Full Name','data-placeholder' => 'Full Name'])->label(false) ?>
        <?= $form->field($model, 'company')->dropDownList($cust_com,['class'=>'select2_single form-control', 'prompt'=>'Company Name','data-placeholder' => 'Company Name'])->label(false) ?>
        <?= $form->field($model, 'plate')->dropDownList($plate,['class'=>'select2_single form-control', 'prompt'=>'Plate','data-placeholder' => 'Plate'])->label(false) ?>

      </div>
      <div class="col-md-4">
        <?= $form->field($model, 'date_a')->textInput(['placeholder'=>'Date From','id'=>'datestart','readonly'=>true])->label(false) ?>
        <?= $form->field($model, 'date_b')->textInput(['placeholder'=>'Date To','id'=>'dateend','readonly'=>true])->label(false) ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($model, 'branch_id')->dropDownList($branch,['class'=>'select2_single form-control', 'prompt'=>'Branch','data-placeholder' => 'Branch'])->label(false) ?>
        <?= $form->field($model, 'user_id')->dropDownList($users,['class'=>'select2_single form-control', 'prompt'=>'User','data-placeholder' => 'User'])->label(false) ?>
      </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Search', ['class' => 'btn btn-default']) ?>
        <?php echo Html::a('<i class="fa fa-undo" aria-hidden="true"></i> Reset',['carplate-report'],['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
