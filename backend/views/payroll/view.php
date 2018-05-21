<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Payroll */

$this->title = 'View Category';
 
?>

<div class="row form-container">
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">
    
 <div class="form-title-container">
    <span class="form-header"><h4><i class="fa fa-globe"></i> View Payroll Information</h4></span>
 </div>      
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>

        <?= Html::a( '<i class="fa fa-pencil-square"></i> Edit', '?r=payroll/update&id=' . $model['id'], ['class' => 'form-btn btn btn-info']); ?>

        <?= Html::a( '<i class="fa fa-trash"></i> Delete', '?r=payroll/delete-column&id=' . $model['id'], ['class' => 'form-btn btn btn-danger', 'onclick' => 'return deleteConfirmation()']); ?>
    </div>
 </div>    
 <br/><br/><br/>

    <div class="tbl-container viewDesign">
        <?= 
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'staff_code',
                    'ic_no',
                    'fullname',
                    'address',
                    'contact_no',
                    'gender',
                    'email',
                    'rate_per_hour',
                    'basic',
                    'allowance',
                    'non_tax_allowance',
                    'levy_supplement',
                    'overtime_hour',
                    'overtime_rate_per_hour',
                    'overtime_pay',
                    'employee_cpf',
                    'employer_cpf',
                    'cash_advance',
                    'other_deductions',
                    'month_levy_charge',
                    'remarks',
                ],
            ]) 
        ?>
    </div>   
 
 </div>

</div>
