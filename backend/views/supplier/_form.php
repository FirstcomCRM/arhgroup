<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
$supplierCode = 'SUPPLIERS' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);

if(!is_null(Yii::$app->request->get('id')) || Yii::$app->request->get('id') <> ''){
    $id = Yii::$app->request->get('id'); 
}else{
    $id = 0;
}

?>

<?php $form = ActiveForm::begin(['id' => 'arh-form']); ?>

<div class="row">
    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Supplier Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Supplier Code</label>
        <input type="hidden" name="id" id="id" value="<?= $id ?>" />
        <?= $form->field($model, 'supplier_code')->textInput(['class' => 'form_input form-control', 'readonly' => 'readonly', 'value' => $supplierCode, 'id' => 'supplierCode' ])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">Supplier Name</label>
        <?= $form->field($model, 'supplier_name')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Supplier Name here.', 'id' => 'supplierName' ])->label(false) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <label class="form_label">Address</label>
        <?= $form->field($model, 'address')->textArea(['class' => 'form_input form-control', 'placeholder' => 'Write Address here.', 'id' => 'supplierAddress' ])->label(false) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <label class="form_label">Contact Number</label>
        <?= $form->field($model, 'contact_number')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Contact Number here.', 'id' => 'supplierContactNo' ])->label(false) ?>
    </div>
</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitSupplierForm' : 'saveSupplierForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>









