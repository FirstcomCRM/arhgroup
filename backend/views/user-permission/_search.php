    <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Role;

/* @var $this yii\web\View */
/* @var $model common\models\SearchUserPermission */
/* @var $form yii\widgets\ActiveForm */
$dataRole = ArrayHelper::map(Role::find()->where('id > 1')->andWhere(['status' => 1])->all(), 'id', 'role');

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
        <?= $form->field($model, 'role_id')->dropDownList($dataRole,['style' => 'width:100%;', 'class' => 'form_input select2_single'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'controller')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Enter Controller here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'action')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Enter Actions here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <div style="margin-left: -10px;">
            <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'form-btn btn btn-primary']) ?>
        </div>
    </div>  

    <?php ActiveForm::end(); ?>
    <br/>

 </div>











