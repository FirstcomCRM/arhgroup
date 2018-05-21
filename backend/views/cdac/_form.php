<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Cdac */
/* @var $form yii\widgets\ActiveForm */ 
if(!is_null(Yii::$app->request->get('id')) || Yii::$app->request->get('id') <> ''){
    $id = Yii::$app->request->get('id'); 
}else{
    $id = 0;
}

?>

<div class="cdac-form">

    <?php $form = ActiveForm::begin(); ?>
    <div style="padding: 1%;">
        <div class="row">
            <div class="col-md-4">
                <input type="hidden" name="id" id="cdacId" value="<?= $id ?>" />
                <?= $form->field($model, 'from_salary')->textInput(['class' => 'form_input form-control', 'id' => 'cdacFromSalary']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'to_salary')->textInput(['class' => 'form_input form-control', 'id' => 'cdacToSalary']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'minimum_monthly_contribution')->textInput(['class' => 'form_input form-control', 'id' => 'cdacMinimumMonthlyContribution']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    <div class="row">

        <div class="col-md-4">
            <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitCDACForm' : 'saveCDACForm']) ?>
            <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
        </div>

    </div>
</div>
    

</div>
