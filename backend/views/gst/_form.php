<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Branch;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$dataBranch = ArrayHelper::map(Branch::find()->where('id > 1')->andWhere(['status' => 1])->all(), 'id', 'name');

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
        <span class="search-label"><li class="fa fa-edit"></li> Gst Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Branch</label>
        <?= $form->field($model, 'branch_id')->dropDownList($dataBranch, ['style' => 'width:100%;', 'class' => 'form_input select2_single', 'required' => 'required', 'data-placeholder' => 'CHOOSE BRANCH HERE', 'id' => 'branchId' ])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">GST Value(%)</label>
        <?= $form->field($model, 'gst')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write GST amount here.', 'id' => 'gst' ])->label(false) ?>
    </div>

</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Update Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitGstForm' : 'saveGstForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>










