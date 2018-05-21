<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Role;
use common\models\Branch;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$dataRole = ArrayHelper::map(Role::find()->where('id <> 1')->andWhere(['status' => 1])->all(), 'id', 'role');
$dataBranch = ArrayHelper::map(Branch::find()->where('id <> 1')->andWhere(['status' => 1])->all(), 'id', 'name');

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
        <span class="search-label"><li class="fa fa-edit"></li> User Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">User Role</label>
        <input type="hidden" name="id" id="id" value="<?= $id ?>" />
        <?= $form->field($model, 'role_id')->dropDownList(['0' => '- SELECT USER-ROLE HERE -'] + $dataRole,['style' => 'width:100%;', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE ROLE HERE', 'id' => 'userRole' ])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">User Branch</label>
        <?= $form->field($model, 'branch_id')->dropDownList(['0' => '- SELECT BRANCH HERE -'] + $dataBranch,['style' => 'width:100%;', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE BRANCH HERE', 'id' => 'userBranch' ])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">Fullname</label>
        <?= $form->field($model, 'fullname')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Fullname here.', 'id' => 'userFullname' ])->label(false) ?>
    </div>
    <div class="col-md-3">
        <label class="form_label">E-mail</label>
        <?= $form->field($model, 'email')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write E-mail here...', 'id' => 'userEmail' ])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">Username</label>
        <?= $form->field($model, 'username')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Username here...', 'id' => 'userName' ])->label(false) ?>
    </div>
    <div class="col-md-3">
        <label class="form_label">Password</label>
        <?= $form->field($model, 'password')->passwordInput(['class' => 'form_input form-control', 'placeholder' => 'Write Password here...', 'id' => 'userPassword' ])->label(false) ?>
    </div>

</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitUserForm' : 'saveUserForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/>










