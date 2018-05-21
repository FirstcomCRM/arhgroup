<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Race;

$dataForType = array('0' => '- SELECT CUSTOMER TYPE HERE -', '1' => '- FOR COMPANY', '2' => '- FOR PERSON');
$dataRace = ArrayHelper::map(Race::find()->all(),'id', 'name');

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */


$member_list = array('0' => 'No', '1' => 'Yes');
$passwordCode = substr(uniqid('', true), -8);

?>

<?php $form = ActiveForm::begin(['id' => 'arh-form']); ?>

<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3">
        <label class="form_label"><li class="fa fa-user-o"></li> CHOOSE TYPE HERE</label>
        <?= $form->field($model, 'type')->dropDownList($dataForType, ['style' => 'width:100%;', 'class' => 'form_input select2_single', 'id' => 'forType', 'data-placeholder' => 'CHOOSE CUSTOMER TYPE HERE'])->label(false) ?>
    </div>
</div>
<br/>

<div id="companyInformation">

    <div class="row">
        <div class="search-label-container">
            &nbsp;
            <span class="search-label"><li class="fa fa-bank"></li> Customer Company Information.</span>
        </div>
        <br/>

        <div class="col-md-3">
            <label class="form_label">COMPANY NAME</label>
            <?= $form->field($model, 'company_name')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Company name here.', 'id' => 'companyName' ])->label(false) ?>
        </div>

        <div class="col-md-6">
            <label class="form_label">ADDRESS</label>
            <textarea name="company_address" rows="2" class="form_input form-control" placeholder="Write Company address here." id="companyAddress" ></textarea>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-md-3">
            <label class="form_label">UEN NO.</label>
            <input type="text" name="uen_no" class="form_input form-control" placeholder="Write UEN number here." id="companyUenNo" />
        </div>

        <div class="col-md-3">
            <label class="form_label">CONTACT PERSON</label>
            <input type="text" name="contact_person" class="form_input form-control" placeholder="Write Contact person here." id="companyContactPerson" />
        </div>

        <div class="col-md-3">
            <label class="form_label">E-MAIL ADDRESS</label>
            <input type="text" name="company_email" class="form_input form-control" placeholder="Write Email address here." id="companyEmail"  />
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-md-3">
            <label class="form_label">PHONE NUMBER</label>
            <input type="text" name="company_hanphone" class="form_input form-control" placeholder="Write Phone number here." id="companyPhoneNumber" />
        </div>

        <div class="col-md-3">
            <label class="form_label">OFFICE NUMBER</label>
            <input type="text" name="company_officeno" class="form_input form-control" placeholder="Write Office number here." id="companyOfficeNumber" />
        </div>

        <div class="col-md-3">
            <label class="form_label">FAX NUMBER</label>
            <input type="text" name="company_faxno" class="form_input form-control" placeholder="Write your Fax number here." id="companyFaxNumber" />
        </div>
    </div>
    <br/>

</div>

<div id="customerInformation">

    <div class="row">
        <div class="search-label-container">
            &nbsp;
            <span class="search-label"><li class="fa fa-address-card"></li> Customer Personal Information.</span>
        </div>
        <br/>

        <div class="col-md-3">
            <label class="form_label">FULLNAME</label>
            <?= $form->field($model, 'fullname')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Customer fullname here.', 'id' => 'customerName' ])->label(false) ?>
        </div>

        <div class="col-md-6">
            <label class="form_label">ADDRESS</label>
            <textarea name="person_address" rows="2" class="form_input form-control" placeholder="Write Customer address here." id="customerAddress" ></textarea>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-md-3">
            <label class="form_label">RACE</label>
            <?= $form->field($model, 'race_id')->dropDownList(['0' => '- PLEASE SELECT RACE HERE -'] + $dataRace, ['style' => 'width:100%;', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE RACE HERE', 'id' => 'customerRace' ])->label(false) ?>
        </div>

        <div class="col-md-3">
            <label class="form_label">NRIC</label>
            <input type="text" name="nric" class="form_input form-control" placeholder="Write NRIC here." id="customerNric" />
        </div>

        <div class="col-md-3">
            <label class="form_label">E-MAIL ADDRESS</label>
            <input type="text" name="person_email" class="form_input form-control" placeholder="Write Email address here." id="customerEmail"  />
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-md-3">
            <label class="form_label">PHONE NUMBER</label>
            <input type="text" name="person_hanphone" class="form_input form-control" placeholder="Write Phone number here." id="customerPhoneNumber" />
        </div>

        <div class="col-md-3">
            <label class="form_label">OFFICE NUMBER</label>
            <input type="text" name="person_officeno" class="form_input form-control" placeholder="Write Office number here." id="customerOficeNumber" />
        </div>
        <div class="col-md-3">
            <label class="form_label">FAX NUMBER</label>
            <input type="text" name="company_faxno" class="form_input form-control" placeholder="Write your Fax number here." id="companyFaxNumberCustomer
            " />
        </div>
    </div>
    <br/>

</div>


<div class="row">
<br/>
    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-truck"></li> Car Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">CAR PLATE</label>
        <?= $form->field($carModel, 'carplate')->textInput(['class' => 'form_input form-control', 'id' => 'carPlate', 'placeholder' => 'Write Car Plate here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">CAR MODEL</label>
        <?= $form->field($carModel, 'model')->textInput(['class' => 'form_input form-control', 'id' => 'carModel', 'placeholder' => 'Write Car Model here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label  class="form_label">CAR MAKE</label>
                <?= $form->field($carModel, 'make')->textInput(['class' => 'form_input form-control', 'id' => 'carMake', 'placeholder' => 'Write Car Make here.'])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label">CHASIS</label>
        <?= $form->field($carModel, 'chasis')->textInput(['class' => 'form_input form-control', 'id' => 'chasis', 'placeholder' => 'Write Car Chasis here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label  class="form_label">ENGINE NO.</label>
                <?= $form->field($carModel, 'engine_no')->textInput(['class' => 'form_input form-control', 'id' => 'engineNo', 'placeholder' => 'Write Engine Number here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label  class="form_label">YEAR MANUFACTURE</label>
                <?= $form->field($carModel, 'year_mfg')->textInput(['class' => 'form_input form-control', 'id' => 'yearMfg', 'placeholder' => 'Write Year Manufacture here.'])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label  class="form_label">REWARD POINTS</label>
                <?= $form->field($carModel, 'make')->textInput(['class' => 'form_input form-control', 'id' => 'rewardPoints', 'placeholder' => 'Write your reward points here.', 'type' => 'number'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label  class="form_label">JOIN DATE</label>
            <?= $form->field($carModel, 'join_date')->textInput(['class' => 'form_input form-control', 'id' => 'joinDate', 'placeholder' => 'Join Date.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label  class="form_label">EXPIRE DATE</label>
            <?= $form->field($carModel, 'member_expiry')->textInput(['class' => 'form_input form-control', 'id' => 'expirationDate', 'placeholder' => 'Expire Date.'])->label(false) ?>
    </div>

    <div>
        <input type="hidden" id="n" class="n" value="0" />
    </div>
</div>

<br>

<div class="row">
  <div class="col-md-3">
    <label  class="form_label">MEMBER</label>
      <?php echo  $form->field($model, 'is_member')->dropDownList(['3' => '- SELECT MEMBER TYPE HERE -', '1' => 'Yes', '0' => 'No'],['style' => 'width:100%;', 'class' => 'form_input select2_single', 'id' => 'isMember', 'data-placeholder' => 'CHOOSE MEMBER TYPE HERE'])->label(false) ?>
  </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="pull-right">
            <button type="button" class="form-btn btn btn-info" id="btnAddCar" ><i class="fa fa-ambulance"></i> Add car in List</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="insert-item-in-list" id="insert-item-in-list"></div><hr/>
    </div>
</div>


<br/>

<div class="row">
    <div class="col-md-6">
        <label  class="form_label">REMARKS</label>
         <textarea name="Customer[remarks]" style="font-size: 11.5px;" placeholder="Write your remarks here." id="message"  class="qtxtarea form-control" data-parsley-trigger="keyup" data-parsley-minlength="10" data-parsley-maxlength="300" data-parsley-minlength-message="You need to enter at least a 10 caracters long comment." data-parsley-validation-threshold="10"></textarea>
    </div>

    <div>
        <?= $form->field($model, 'password')->hiddenInput(['value' => $passwordCode, 'id' => 'password'])->label(false) ?>
    </div>
    <br/>
</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitCustomerForm' : 'saveCustomerForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>
