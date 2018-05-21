<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PaymentStatus */
/* @var $form yii\widgets\ActiveForm */
$dateNow = date('Y-m-d');
$userId = Yii::$app->user->identity->id;

?>

<?php $form = ActiveForm::begin(['id' => 'arh-form']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Payment-Status Information.</span>
    </div>
    <br/>

    <div class="col-md-4">
        <label class="form_label">Name</label>
        <?= $form->field($model, 'name')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Payment-Status Name here.'])->label(false) ?>
    </div>

</div>

<div class="row">
    
    <div class="col-md-5">
        <label class="form_label">Description</label>
        <?= $form->field($model, 'description')->textArea(['class' => 'form_input form-control', 'placeholder' => 'Write Payment-Status Description here.'])->label(false) ?>
    </div>

</div>
<hr/>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Update Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>

<?php ActiveForm::end(); ?>
