<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Staff;

/* @var $this yii\web\View */
/* @var $model common\models\Payroll */
/* @var $form yii\widgets\ActiveForm */

$dateNow = date('d-m-Y');
$getStaff = ArrayHelper::map(Staff::find()->where(['status' => 1])->all(), 'id', 'fullname');

$userLogName = Yii::$app->user->identity->fullname;

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
        <span class="search-label"><li class="fa fa-edit"></li> Payroll Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Pay-Date Issue</label>
        <input type="hidden" name="id" id="id" value="<?= $id ?>" />
        <?= $form->field($model, 'date_issue')->textInput(['class' => 'form_input form-control', 'style' => 'text-align:center;', 'readonly' => 'readonly', 'id' => 'payslipDate', 'value' => $dateNow, 'placeholder' => 'YYYY-MM-DD'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">Pay Cut-Off Date</label>
        <?= $form->field($model, 'payslip_cutoff')->textInput(['class' => 'form_input form-control', 'style' => 'text-align:center;', 'readonly' => 'readonly', 'id' => 'payslipCutoffDate', 'placeholder' => 'YYYY-MM-DD'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">Staff Fullname</label>
        <?= $form->field($model, 'staff_id')->dropdownList(['0' => '- SELECT STAFF NAME HERE -'] + $getStaff, ['class' => 'qSelect select3_single', 'style' => 'width:100%;', 'id' => 'staffId', 'onchange' => 'getStaffCitizenship()', 'data-placeholder' => 'CHOOSE STAFF HERE', $editStatus => 'disabled' ])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-6">

         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Over-Time Hours</label>
                <?= $form->field($model, 'overtime_hour')->textInput(['class' => 'form_input form-control', 'placeholder' => '0.0', 'id' => 'psOtHour', 'onchange' => 'getOtPay()' ])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Over-Time Rate per Hour</label>
                <?= $form->field($model, 'overtime_rate_per_hour')->textInput(['class' => 'form_input form-control', 'placeholder' => '0.0', 'id' => 'psOtRateHour', 'onchange' => 'getOtPay()' ])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Over-Time Pay</label>
                <?= $form->field($model, 'overtime_pay')->textInput(['class' => 'form_input form-control', 'placeholder' => '0.0', 'id' => 'psOtPay', 'readonly' => 'readonly' ])->label(false) ?>
            </div>
         </div>
         <br/>
         
         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Employer CPF.</label>
                <?= $form->field($model, 'employer_cpf')->textInput(['class' => 'form_input form-control', 'id' => 'employerCpf', 'placeholder' => '0.00', 'readonly' => 'readonly'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Employee CPF.</label>
                <?= $form->field($model, 'employee_cpf')->textInput(['class' => 'form_input form-control', 'id' => 'employeeCpf', 'placeholder' => '0.00', 'readonly' => 'readonly'])->label(false) ?>
            </div>
         </div>

    </div>

    <div class="col-md-6">
        
         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Cash Advance</label>
                <?= $form->field($model, 'cash_advance')->textInput(['class' => 'form_input form-control', 'placeholder' => '0.00', 'id' => 'psCashAdvance' ])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Other Deductions</label>
                <?= $form->field($model, 'other_deductions')->textInput(['class' => 'form_input form-control', 'placeholder' => '0.00', 'id' => 'psOtherDeduction' ])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Monthly Levy Charge</label>
                <?= $form->field($model, 'monthly_levy_charge')->textInput(['class' => 'form_input form-control', 'id' => 'monthlyLevyCharge', 'placeholder' => '0.00', 'readonly' => 'readonly'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Prepared By</label>
                <?= $form->field($model, 'prepared_by')->textInput(['class' => 'form_input form-control', 'value' => $userLogName, 'placeholder' => 'Who Prepare ?', 'id' => 'psPreparedBy' ])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-7">
                <label class="form_label">Approved By</label>
                <?= $form->field($model, 'approved_by')->textInput(['class' => 'form_input form-control', 'value' => $userLogName, 'placeholder' => 'Who Approve ?', 'id' => 'psApprovedBy' ])->label(false) ?>
            </div>
         </div>
         <br/>

    </div>

</div>

<div class="row">

    <div class="col-md-6">
        <label class="form_label">Notes</label>
        <?= $form->field($model, 'remarks')->textarea(['class' => 'form_input form-control', 'placeholder' => 'Write Notes here.', 'id' => 'psNotes' ])->label(false) ?>
    </div>

</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitPayrollForm' : 'savePayrollForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>










