<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */

$this->title = 'View Staff';
 
?>

<div class="row form-container">
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">
    
 <div class="form-title-container">
    <span class="form-header"><h4><i class="fa fa-user-secret"></i> View Staff Information </h4></span>
 </div>      
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>

        <?= Html::a( '<i class="fa fa-pencil-square"></i> Update', '?r=staff/update&id=' . $model['id'], ['class' => 'form-btn btn btn-info']); ?>

        <?= Html::a( '<i class="fa fa-trash"></i> Delete', '?r=staff/delete-column&id=' . $model['id'], ['class' => 'form-btn btn btn-danger', 'onclick' => 'return deleteConfirmation()']); ?>
    </div>
 </div>    
 <br/><br/><br/>

    <div class="tbl-container viewDesign">
        <?= 
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'staff_group_id',
                        'value' => $model['name'],
                        'label' => 'Staff Group Name',
                    ],
                    'staff_code',
                    'fullname', 
                    'address',
                    'email',
                    'contact_number',
                    'ic_no',
                    'rate_per_hour',
                    'basic',
                    'allowance',
                    [
                        'label' => 'Status',
                        'value' => $model['status'] ? 'Yes' : 'No',
                    ], 
                    [
                        'label' => 'Created At',
                        'value' => date('m-d-Y', strtotime($model['created_at'])),
                    ], 
                ],
            ]) 
        ?>
    </div>   
 
 </div>

</div>




    
