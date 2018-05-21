<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\StaffGroup;
use common\models\DesignatedPosition;
use common\models\Race;
use common\models\MaritalStatus;
use common\models\Nationality;
use common\models\Religion;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */
/* @var $form yii\widgets\ActiveForm */

$staffCode = 'EMP'.sprintf('%0003d', $getStaffId); 
$dataStaffGroup = ArrayHelper::map(StaffGroup::find()->where(['status' => 1])->all(),'id', 'name');
$dataDesignatedPosition = ArrayHelper::map(DesignatedPosition::find()->where(['status' => 1])->all(),'id', 'name');
$dataRace = ArrayHelper::map(Race::find()->where(['status' => 1])->all(),'id', 'name');
$dataGender = array('Male' => 'Male', 'Female' => 'Female');
$dataCitizen = array('1' => 'LOCAL', '2' => 'INTERNATIONAL / FOREIGNER');
$dataMaritalStatus = ArrayHelper::map(MaritalStatus::find()->where(['status' => 1])->all(),'id', 'name');
$dataNationality = ArrayHelper::map(Nationality::find()->where(['status' => 1])->all(),'id', 'name');
$dataReligion = ArrayHelper::map(Religion::find()->where(['status' => 1])->all(),'id', 'name');
$dataGender = array('Male' => 'Male', 'Female' => 'Female');
$dataLanguage = array('1' => 'ENGLISH', '2' => 'CHINESE');

if(!is_null(Yii::$app->request->get('id')) || Yii::$app->request->get('id') <> ''){
    $id = Yii::$app->request->get('id'); 
}else{
    $id = 0;
}

?>

<?php $form = ActiveForm::begin(['id' => 'arh-form']); ?>

<div class="row" >

    <div class="" role="tabpanel" data-example-id="togglable-tabs">

    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active"><a href="#staff_generalinfo" id="generalinfo-tab" role="tab" data-toggle="tab" aria-expanded="true">
            <b> General Info. </b></a>
        </li>
        <li role="presentation" class=""><a href="#staff_contactinfo" role="tab" id="contactinfo-tab" data-toggle="tab"  aria-expanded="false">
            <b> Emergency Contact Info. </b></a>
        </li>
        <li role="presentation" class=""><a href="#staff_jobinfo" role="tab" id="jobinfo-tab" data-toggle="tab"  aria-expanded="false">
            <b> Job Info. </b></a>
        </li>
        <li role="presentation" class=""><a href="#staff_salaryinfo" role="tab" id="salaryinfo-tab" data-toggle="tab"  aria-expanded="false">
            <b> Salary Info. </b></a>
        </li>
        <li role="presentation" class=""><a href="#staff_leave" role="tab" id="leave-tab" data-toggle="tab"  aria-expanded="false">
            <b> Leave </b></a>
        </li>
    </ul>

        <div id="myTabContent" class="tab-content">

            <div role="tabpanel" class="tab-pane fade active in" id="staff_generalinfo" aria-labelledby="generalinfo-tab">
            <br/>

                <div class="row" >
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        
                        <div class="row columnAlignment">
                            <div class="col-md-6">
                                <label class="form_label">Employee Code</label>
                                <input type="hidden" name="id" id="id" value="<?= $id ?>" />
                                <?= $form->field($model, 'staff_code')->textInput(['class' => 'form_input form-control', 'style' => 'text-align:center; font-weight: bold;', 'readonly' => 'readonly', 'value' => $staffCode, 'id' => 'staffCode' ])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-6">
                                <label class="form_label">Citizenship</label>
                                <?= $form->field($model, 'citizenship')->dropdownList(['0' => '- SELECT CITIZENSHIP HERE -'] + $dataCitizen, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'id' => 'citizenship', 'data-placeholder' => 'CHOOSE CITIZENSHIP HERE'])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-6">
                                <label class="form_label">Department</label>
                                <?= $form->field($model, 'staff_group_id')->dropdownList(['0' => '- SELECT DEPARTMENT HERE -'] + $dataStaffGroup, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE DEPARTMENT HERE', 'id' => 'staffGroup' ])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-6">
                                <label class="form_label">Designated Position</label>
                                <?= $form->field($model, 'designated_position_id')->dropdownList(['0' => '- SELECT DESIGNATED POSITION HERE -'] + $dataDesignatedPosition, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE DESIGNATED POSITION HERE', 'id' => 'staffPosition' ])->label(false) ?>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-4">
                    
                        <div style="margin-left: -250px; margin-top: 25px;">
                            Image
                        </div>
                    
                    </div>
                </div>

                <div class="row columnAlignment">
                    <div class="col-md-5">
                        <label class="form_label">Fullname</label>
                        <?= $form->field($model, 'fullname')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Name here.', 'id' => 'staffFullname' ])->label(false) ?>
                    </div>
                </div>

                <div class="row columnAlignment">
                    <div class="col-md-7">
                        <label class="form_label">Address</label>
                        <?= $form->field($model, 'address')->textArea(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Address here.', 'id' => 'staffAddress', 'rows' => 2 ])->label(false) ?>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-md-6 col-sm-6 col-xs-6">

                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">NRIC/WP/FIN</label>
                                <?= $form->field($model, 'ic_no')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff IC Number here.', 'id' => 'staffNric' ])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">Birthday</label>
                                <?= $form->field($model, 'birthday')->textInput(['class' => 'form_input form-control', 'id' => 'staffBirthday', 'placeholder' => 'MM-DD-YYYY' ])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">Email Address</label>
                                <?= $form->field($model, 'email')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Email here.', 'id' => 'staffEmail' ])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">Mobile Number</label>
                                <?= $form->field($model, 'mobile_number')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Mobile Number here.', 'id' => 'staffMobileNumber' ])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">Phone Number</label>
                                <?= $form->field($model, 'phone_number')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Phone Number here.', 'id' => 'staffPhoneNumber' ])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">Preferred Language</label>
                                <?= $form->field($model, 'language_prefer')->dropdownList(['0' => '- SELECT PREFERRED LANGUAGE HERE -'] + $dataLanguage, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE PREFERRED LANGUAGE HERE', 'id' => 'staffPreferredLanguage' ])->label(false) ?>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6">
                        
                        <div style="margin-left: -100px;" class="row">
                            <div class="col-md-6">
                                <label class="form_label">Gender</label>
                                <?= $form->field($model, 'gender')->dropdownList(['0' => '- SELECT GENDER HERE -'] + $dataGender, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE GENDER HERE', 'id' => 'staffGender' ])->label(false) ?>
                            </div>
                        </div>

                        <div style="margin-left: -100px;" class="row">
                            <div class="col-md-6">
                                <label class="form_label">Nationality</label>
                                <?= $form->field($model, 'nationality_id')->dropdownList(['0' => '- SELECT NATIONALITY HERE -'] + $dataNationality, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE NATIONALITY HERE', 'id' => 'staffNationality' ])->label(false) ?>
                            </div>
                        </div>

                        <div style="margin-left: -100px;" class="row">
                            <div class="col-md-6">
                                <label class="form_label">Marital Status</label>
                                <?= $form->field($model, 'marital_status_id')->dropdownList(['0' => '- SELECT MARITAL-STATUS HERE -'] + $dataMaritalStatus, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE MARITAL-STATUS HERE', 'id' => 'staffMaritalStatus' ])->label(false) ?>
                            </div>
                        </div>

                        <div style="margin-left: -100px;" class="row">
                            <div class="col-md-6">
                                <label class="form_label">Race</label>
                                <?= $form->field($model, 'race_id')->dropdownList(['0' => '- SELECT RACE HERE -'] + $dataRace, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE RACE HERE', 'id' => 'staffRace' ])->label(false) ?>
                            </div>
                        </div>

                        <div style="margin-left: -100px;" class="row">
                            <div class="col-md-6">
                                <label class="form_label">Religion</label>
                                <?= $form->field($model, 'religion_id')->dropdownList(['0' => '- SELECT RELIGION HERE -'] + $dataReligion, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE RELIGION HERE', 'id' => 'staffReligion' ])->label(false) ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row columnAlignment">
                    <div class="col-md-9">
                        <label class="form_label">Remarks</label>
                        <?= $form->field($model, 'remarks')->textArea(['class' => 'form_input form-control', 'placeholder' => 'Write Remarks here.', 'id' => 'staffRemarks', 'rows' => 2 ])->label(false) ?>
                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane fade" id="staff_contactinfo" aria-labelledby="contactinfo-tab">
            <br/>

                <div class="row" >
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        
                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">Contact Person</label>
                                <?= $form->field($model, 'contact_person')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Contact Person here.', 'id' => 'staffContactPerson' ])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">Contact Number</label>
                                <?= $form->field($model, 'contact_number')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Contact Number here.', 'id' => 'staffContactNo' ])->label(false) ?>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6">

                        <div style="margin-left: -100px;" class="row">
                            <div class="col-md-6">
                                <label class="form_label">Relationship</label>
                                <?= $form->field($model, 'contact_person_relationship')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Relationship here.', 'id' => 'staffRelationship' ])->label(false) ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row columnAlignment">
                    <div class="col-md-8">
                        <label class="form_label">Address</label>
                        <?= $form->field($model, 'contact_person_address')->textArea(['class' => 'form_input form-control', 'placeholder' => 'Write Address here.', 'id' => 'staffContactAddress', 'rows' => 2 ])->label(false) ?>
                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane fade" id="staff_jobinfo" aria-labelledby="jobinfo-tab">
            <br/>

                <div class="row" >
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        
                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">Work Time(start)</label>
                                <?= $form->field($model, 'work_time_start')->textInput(['class' => 'form_input form-control', 'id' => 'work_time_start', 'placeholder' => '00:00' ])->label(false) ?>
                            </div>
                        </div>

                        <div class="row columnAlignment">
                            <div class="col-md-8">
                                <label class="form_label">Join Date</label>
                                <?= $form->field($model, 'join_date')->textInput(['class' => 'form_input form-control', 'id' => 'staffJoinDate', 'placeholder' => 'MM-DD-YYYY' ])->label(false) ?>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6">

                        <div style="margin-left: -100px;" class="row">
                            <div class="col-md-6">
                                <label class="form_label">Work Time(end)</label>
                                <?= $form->field($model, 'work_time_end')->textInput(['class' => 'form_input form-control', 'id' => 'work_time_end', 'placeholder' => '00:00' ])->label(false) ?>
                            </div>
                        </div>

                        <div style="margin-left: -100px;" class="row">
                            <div class="col-md-6">
                                <label class="form_label">Resignation/Termination Date</label>
                                <?= $form->field($model, 'resignation_termination_date')->textInput(['class' => 'form_input form-control', 'id' => 'staffRTReason', 'placeholder' => 'MM-DD-YYYY' ])->label(false) ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row columnAlignment">
                    <div class="col-md-8">
                        <label class="form_label">Resignation/Termination Reason</label>
                        <?= $form->field($model, 'resignation_termination_reason')->textArea(['class' => 'form_input form-control', 'placeholder' => 'Write Reason here.', 'id' => 'staffRTAddress', 'rows' => 2 ])->label(false) ?>
                    </div>
                </div>

            </div>

            <div role="tabpanel" class="tab-pane fade" id="staff_salaryinfo" aria-labelledby="salaryinfo-tab">
            <br/>

                <div class="row columnAlignment">
                    <div class="col-md-4">
                        <label class="form_label">Rate/Hour</label>
                        <?= $form->field($model, 'rate_per_hour')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Rate per Hour here.', 'id' => 'staffRate' ])->label(false) ?>
                    </div>

                </div>

                <div class="row columnAlignment">
                    <div class="col-md-4">
                        <label class="form_label">Basic Salary</label>
                        <?= $form->field($model, 'basic')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Basic Salary here.', 'id' => 'staffBasic' ])->label(false) ?>
                    </div>

                </div>

                <div class="row columnAlignment">
                    <div class="col-md-4">
                        <label class="form_label">Allowance</label>
                    <?= $form->field($model, 'allowance')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Allowance here.', 'id' => 'staffAllowance' ])->label(false) ?>
                    </div>

                </div>

                <div class="row columnAlignment">
                    <div class="col-md-4">
                        <label class="form_label">Non Tax-Allowance</label>
                    <?= $form->field($model, 'non_tax_allowance')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Non Tax-Allowance here.', 'id' => 'staffNonTaxAllowance' ])->label(false) ?>
                    </div>

                </div>

                <div class="row columnAlignment">
                    <div class="col-md-4">
                        <label class="form_label">Levy Supplement</label>
                    <?= $form->field($model, 'levy_supplement')->textInput(['class' => 'form_input form-control', 'id' => 'levySupplement', 'placeholder' => 'Write Staff Levy Supplement here.', 'readonly' => 'readonly'])->label(false) ?>
                    </div>

                </div>

            </div>

            <div role="tabpanel" class="tab-pane fade" id="staff_leave" aria-labelledby="leave-tab">
            e
            </div>

        </div>

    </div>

</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitStaffForm' : 'saveStaffForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/>









