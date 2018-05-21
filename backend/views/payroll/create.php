<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Payroll */

$this->title = 'Create PAyroll';

?>

<div class="row form-container">

<div>
    <?php if($msg <> ''){ ?>
        <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
            <?php echo $msg; ?>
        </div>
    <?php } ?>
</div>
 
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-globe"></i> Create Payroll Information</h4></span>
    </div>
    <hr/>

    <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
    <br/><br/>

    <div class="form-crud-container">
        <?= $this->render('_form', ['model' => $model, 'editStatus' => $editStatus]) ?>
    </div>   
</div>

</div>
