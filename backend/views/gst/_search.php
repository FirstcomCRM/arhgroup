<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use yii\helpers\ArrayHelper;
use common\models\Branch;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$dataBranch = ArrayHelper::map(Branch::find()->where('id > 2')->all(), 'id', 'name');

?>

<div class="row">
 
    <div class="col-md-12">
        <div class="search-label-container">
            <span class="search-label"><li class="fa fa-edit"></li> Enter Keyword here</span>
        </div> 
    </div>
    <br/>
    
    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get', 'class' => 'form-inline']); ?>

    <div class="col-md-4">
        <?= $form->field($model, 'branch_id')->dropDownList($dataBranch, ['style' => 'width:100%;', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE BRANCH HERE'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <div style="margin-left: -10px;">
            <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'form-btn btn btn-primary']) ?>
        </div>
    </div>

    <div class="col-md-4"></div>

    <?php ActiveForm::end(); ?>
    <br/>

</div>





