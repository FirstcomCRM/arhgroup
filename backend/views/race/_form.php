<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Race */
/* @var $form yii\widgets\ActiveForm */

$dateTimeNow = date('Y-m-d H:i:s');
$userId = Yii::$app->user->identity->id;

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
        <span class="search-label"><li class="fa fa-edit"></li> Race Information.</span>
    </div>
    <br/>

    <div class="col-md-4">
        <label class="form_label">Name</label>
        <input type="hidden" name="id" id="id" value="<?= $id ?>" />
        <?= $form->field($model, 'name')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Race Name here.', 'id' => 'raceName' ])->label(false) ?>
    </div>
    
</div>

<div class="row">

    <div class="col-md-5">
        <label class="form_label">Description</label>
        <?= $form->field($model, 'description')->textArea(['class' => 'form_input form-control', 'placeholder' => 'Write Race Description here.', 'id' => 'raceDescription' ])->label(false) ?>
    </div>

</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitRaceForm' : 'saveRaceForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>