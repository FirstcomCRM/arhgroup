<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdditionalType */

$this->title = 'View Additional Type';

?>

<div class="row form-container">

 <div class="col-md-12 col-sm-12 col-xs-12">
    
 <div class="form-title-container">
    <span class="form-header"><h4><i class="fa fa-address-book-o"></i> View Additional Type Information</h4></span>
 </div>      
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>

        <?= Html::a( '<i class="fa fa-pencil-square"></i> Edit', '?r=additional-type/update&id=' . $model->id, ['class' => 'form-btn btn btn-info']); ?>

        <?= Html::a( '<i class="fa fa-trash"></i> Delete', '?r=additional-type/delete-column&id=' . $model->id, ['class' => 'form-btn btn btn-danger', 'onclick' => 'return deleteConfirmation()']); ?>
    </div>
 </div>    
 <br/><br/><br/>

    <div class="tbl-container viewDesign">
        <?= 
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'description',
                    [
                        'label' => 'Status',
                        'value' => $model->status ? 'Yes' : 'No',
                    ], 
                    [
                        'label' => 'Created At',
                        'value' => date('m-d-Y', strtotime($model->created_at)),
                    ], 
                ],
            ]) 
        ?>
    </div>   
 
 </div>

</div>