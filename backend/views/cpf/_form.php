<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Cpf */
/* @var $form yii\widgets\ActiveForm */

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
        <span class="search-label"><li class="fa fa-edit"></li> Cpf Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">From Age</label>
        <input type="hidden" name="id" id="id" value="<?= $id ?>" />
        <?= $form->field($model, 'from_age')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Age from here.', 'id' => 'cpfAgeFrom' ])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">To Age</label>
        <?= $form->field($model, 'to_age')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Age to here.', 'id' => 'cpfAgeTo' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label">Employee Cpf(% of wage)</label>
        <?= $form->field($model, 'employee_cpf')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Employee Cpf here.', 'id' => 'cpfEmployee' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label">Employer Cpf(% of wage)</label>
        <?= $form->field($model, 'employer_cpf')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Employer Cpf here.', 'id' => 'cpfEmployer' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-6">
        <label class="form_label">Description</label>
        <?= $form->field($model, 'description')->textarea(['class' => 'form_input form-control', 'placeholder' => 'Write Description here.', 'id' => 'cpfDescription' ])->label(false) ?>
    </div>
</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitCPFForm' : 'saveCPFForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/>