<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Race;

$dataForType = array('0' => '- PLEASE SELECT CUSTOMER TYPE HERE -', '1' => '- FOR COMPANY', '2' => '- FOR PERSON');
$dataRace = ArrayHelper::map(Race::find()->all(),'id', 'name');

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */


$member_list = array('0' => 'No', '1' => 'Yes');
$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
$passwordCode = substr(uniqid('', true), -8);

$company_name = ($result['type'] == 1)? $result['company_name'] : '';
$company_address = ($result['type'] == 1)? $result['address'] : '';
$uen_no = ($result['type'] == 1)? $result['uen_no'] : '';
$contact_person = ($result['type'] == 1)? $result['fullname'] : '';
$company_email = ($result['type'] == 1)? $result['email'] : '';
$company_hanphoneno = ($result['type'] == 1)? $result['hanphone_no'] : '';
$company_officeno = ($result['type'] == 1)? $result['office_no'] : '';
$companyFaxNumber = ($result['type'] == 1)? $result['fax_number'] : '';

$fullname = ($result['type'] == 2)? $result['fullname'] : '';
$address = ($result['type'] == 2)? $result['address'] : '';
$nric = ($result['type'] == 2)? $result['nric'] : '';
$race = ($result['type'] == 2)? $result['race_id'] : '';
$email = ($result['type'] == 2)? $result['email'] : '';
$hanphoneno = ($result['type'] == 2)? $result['hanphone_no'] : '';
$officeno = ($result['type'] == 2)? $result['office_no'] : '';
$customerFaxNumber = ($result['type'] == 2)? $result['fax_number'] : '';

?>

<?php $form = ActiveForm::begin(['id' => 'arh-form']); ?>

<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3">
        <label class="form_label"><li class="fa fa-user-o"></li> CHOOSE TYPE HERE</label>
        <?= $form->field($model, 'type')->dropDownList($dataForType, ['style' => 'width:100%;', 'class' => 'form_input select2_single', 'id' => 'updateForType', 'value' => $result['type'], 'data-placeholder' => 'CHOOSE CUSTOMER TYPE HERE'])->label(false) ?>
    </div>
</div>
<br/>

<div id="update_companyInformation" <?php if($result['type'] == 2): ?> hidden <?php endif; ?> >
    
    <div class="row">
        <div class="search-label-container">
            &nbsp;
            <span class="search-label"><li class="fa fa-bank"></li> Customer Company Information.</span>
        </div>
        <br/>

        <div class="col-md-3">
            <label class="form_label">COMPANY NAME</label>
            <?= $form->field($model, 'company_name')->textInput(['class' => 'form_input form-control', 'value' => strtoupper($company_name), 'placeholder' => 'Write Company name here.', 'id' => 'companyName' ])->label(false) ?>
        </div>
        
        <div class="col-md-6">
            <label class="form_label">ADDRESS</label>
            <textarea name="company_address" rows="1" class="form_input form-control" placeholder="Write Company address here." id="companyAddress" ><?= strtoupper($company_address) ?></textarea>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-md-3">
            <label class="form_label">UEN NO.</label>
            <input type="text" name="uen_no" class="form_input form-control" value="<?= strtoupper($uen_no) ?>" placeholder="Write UEN number here." id="companyUenNo" />
        </div>

        <div class="col-md-3">
            <label class="form_label">CONTACT PERSON</label>
            <input type="text" name="contact_person" class="form_input form-control" value="<?= strtoupper($contact_person) ?>" placeholder="Write Contact person here." id="companyContactPerson" />
        </div>

        <div class="col-md-3">
            <label class="form_label">E-MAIL ADDRESS</label>
            <input type="text" name="company_email" class="form_input form-control" value="<?= strtoupper($company_email) ?>" placeholder="Write Email address here." id="companyEmail" />
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-md-3">
            <label class="form_label">PHONE NUMBER</label>
            <input type="text" name="company_hanphone" class="form_input form-control" value="<?= $company_hanphoneno ?>" placeholder="Write Phone number here." id="companyPhoneNumber" />
        </div>

        <div class="col-md-3">
            <label class="form_label">OFFICE NUMBER</label>
            <input type="text" name="company_officeno" class="form_input form-control" value="<?= $company_officeno
             ?>" placeholder="Write Office number here." id="companyOfficeNumber" />
        </div>

        <div class="col-md-3">
            <label class="form_label">FAX NUMBER</label>
            <input type="text" name="company_faxno" class="form_input form-control" value="<?= $companyFaxNumber ?>" placeholder="Write Fax number here." id="companyFaxNumber" />
        </div>
    </div>
    <br/>

</div>

<div id="update_customerInformation" <?php if($result['type'] == 1): ?> hidden <?php endif; ?> >
    
    <div class="row">
        <div class="search-label-container">
            &nbsp;
            <span class="search-label"><li class="fa fa-address-card"></li> Customer Personal Information.</span>
        </div>
        <br/>

        <div class="col-md-3">
            <label class="form_label">FULLNAME</label>
            <?= $form->field($model, 'fullname')->textInput(['class' => 'form_input form-control', 'value' => strtoupper($fullname), 'placeholder' => 'Write Customer fullname here.', 'id' => 'customerName' ])->label(false) ?>
        </div>
        
        <div class="col-md-6">
            <label class="form_label">ADDRESS</label>
            <textarea name="person_address" rows="1" class="form_input form-control" placeholder="Write Customer address here." id="customerAddress" ><?= strtoupper($address) ?></textarea>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-md-3">
            <label class="form_label">RACE</label>
            <?= $form->field($model, 'race_id')->dropDownList($dataRace, ['style' => 'width:100%;', 'class' => 'form_input select2_single', 'value' => $race, 'data-placeholder' => 'CHOOSE RACE HERE', 'id' => 'customerRace' ])->label(false) ?>
        </div>

        <div class="col-md-3">
            <label class="form_label">NRIC</label>
            <input type="text" name="nric" class="form_input form-control" value="<?= strtoupper($nric) ?>" placeholder="Write NRIC here." id="customerNric" />
        </div>

        <div class="col-md-3">
            <label class="form_label">E-MAIL ADDRESS</label>
            <input type="text" name="person_email" class="form_input form-control" value="<?= strtoupper($email) ?>" placeholder="Write Email address here." id="customerEmail"  />
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-md-3">
            <label class="form_label">PHONE NUMBER</label>
            <input type="text" name="person_hanphone" class="form_input form-control" value="<?= $hanphoneno ?>" placeholder="Write Phone number here." id="customerPhoneNumber" />
        </div>

        <div class="col-md-3">
            <label class="form_label">OFFICE NUMBER</label>
            <input type="text" name="person_officeno" class="form_input form-control" value="<?= $officeno ?>" placeholder="Write Office number here." id="customerOficeNumber" />
        </div>

        <div class="col-md-3">
            <label class="form_label">FAX NUMBER</label>
            <input type="text" name="person_faxno" class="form_input form-control" value="<?= $customerFaxNumber ?>" placeholder="Write Fax number here." id="customerFaxNumber" />
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
                <?= $form->field($carModel, 'make')->textInput(['class' => 'form_input form-control', 'id' => 'rewardPoints', 'placeholder' => 'Write reward points here.','type' => 'number'])->label(false) ?>
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
        <input type="hidden" id="n" class="n" value="<?= $lastId ?>" />
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
<?php foreach($carResult as $carRow): ?>
    <div class="col-md-9">
    <hr/>

        <div class="car-item-<?= $carRow['id'] ?> row">

            <div class="col-md-12">     
                <span class="edit-car-button-<?= $carRow['id'] ?> edit-button">
                    - <a href="javascript:editSelectedCarItem(<?= $carRow['id'] ?>)" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>
                </span>
                <span class="save-car-button-<?= $carRow['id'] ?> save-button hidden">
                   - <a href="javascript:saveSelectedCarItem(<?= $carRow['id'] ?>)" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>
                </span>
                &nbsp;
                <span class="remove-car-button-<?= $carRow['id'] ?> remove-button">
                    <a href="javascript:removeSelectedCarItem(<?= $carRow['id'] ?>)" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a> -
                </span> 
            </div>
        </div>

        <div class="car-item-<?= $carRow['id'] ?> row">
            <div class="col-md-4">     
                <div class="quoSPLabel"> <b><span><i class="fa fa-credit-card-alt"></i> Vehicle Number </span></b> </div>
                <input type="text" id="car-item-carplate-<?= $carRow['id'] ?>" name="carplate[]" class="vehicleNumber form_quoSP form-control" value="<?= strtoupper($carRow['carplate']) ?>" readonly />
                <br/>
            </div>

            <div class="col-md-4">     
                <div class="quoSPLabel"> <b><span><i class="fa fa-taxi"></i> Car Model </span></b> </div>
                <input type="text" id="car-item-carmodel-<?= $carRow['id'] ?>" name="carmodel[]" class="carModel form_quoSP form-control" value="<?= strtoupper($carRow['model']) ?>" readonly />
                <br/>
            </div>

            <div class="col-md-4">     
                <div class="quoSPLabel"> <b><span><i class="fa fa-google-wallet"></i> Car Make </span></b> </div>
                <input type="text" id="car-item-carmake-<?= $carRow['id'] ?>" name="carmake[]" class="carMake form_quoSP form-control" value="<?= strtoupper($carRow['make']) ?>" readonly />
                <br/>
            </div>
        </div>

        <div class="car-item-<?= $carRow['id'] ?> row">
            <div class="col-md-4">     
                <div class="quoSPLabel"> <b><span><i class="fa fa-chrome"></i> Chasis </span></b> </div>
                <input type="text" id="car-item-chasis-<?= $carRow['id'] ?>" name="chasis[]" class="chasis form_quoSP form-control" value="<?= strtoupper($carRow['chasis']) ?>" readonly />
                <br/>
            </div>

            <div class="col-md-4">     
                <div class="quoSPLabel"> <b><span><i class="fa fa-codepen"></i> Engine No. </span></b> </div>
                <input type="text" id="car-item-engineno-<?= $carRow['id'] ?>" name="engineno[]" class="engineNo form_quoSP form-control" value="<?= strtoupper($carRow['engine_no']) ?>" readonly />
                <br/>
            </div>

            <div class="col-md-4">     
                <div class="quoSPLabel"> <b><span><i class="fa fa-calendar-minus-o"></i> Year Mfg </span></b> </div>
                <input type="text" id="car-item-yearmfg-<?= $carRow['id'] ?>" name="yearmfg[]" class="yearMfg form_quoSP form-control" value="<?= $carRow['year_mfg'] ?>" readonly />
                <br/>
            </div>
        </div>

        <div class="car-item-<?= $carRow['id'] ?> row">
            <div class="col-md-4">     
                <div class="quoSPLabel"> <b><span><i class="fa fa-money"></i> Reward Points </span></b> </div>
                <input type="text" id="car-item-rewardpoints-<?= $carRow['id'] ?>" name="rewardpoints[]" class="rewardPoints form_quoSP form-control" value="<?= $carRow['points'] ?>" readonly />
            </div>
            <div class="col-md-4">
              <div class="quoSPLabel"> <b><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Join Date </span></b> </div>
              <?php
                if (!is_null($carRow['join_date'] )) {
                  $jDate = date('d-m-Y', strtotime($carRow['join_date']) );
                }else{
                  $jDate = '';
                }
               ?>
              <input type="text" id="car-item-joindate-<?= $carRow['id'] ?>" name="joindate[]" class="datepickers joindate form_quoSP form-control" value="<?= $jDate ?>" readonly style="pointer-events: none" />
            </div>
            <div class="col-md-4">
                <div class="quoSPLabel"> <b><span><i class="fa fa-calendar-times-o" aria-hidden="true"></i> Expire Date </span></b> </div>
                <?php
                  if (!is_null($carRow['member_expiry'] )) {
                    $mDate = date('d-m-Y', strtotime($carRow['member_expiry']) );
                  }else{
                    $mDate = '';
                  }
                 ?>
                <input type="text" id="car-item-expiredate-<?= $carRow['id'] ?>" name="expiredate[]" class="datepickers expiredate form_quoSP form-control" value="<?= $mDate ?>" readonly style="pointer-events: none" />
            </div>

            <input type="hidden" name="carid[]" value="<?= $carRow['id'] ?>" class="carId"/>
        </div>

        <br>
        <div class="car-item-<?= $carRow['id'] ?> row">
          <div class="col-md-4">
              <div class="quoSPLabel"> <b><span><i class="fa fa-calendar-times-o" aria-hidden="true"></i> Member </span></b> </div>
              <select class="form_input form_control form_quoSP member" name="member[]" style="width:100%; height:30px;pointer-events:none" id="car-item-member-<?= $carRow['id'] ?>" >
                <option value="3" <?php if ($carRow['is_member'] == 3) echo 'selected' ?>>- SELECT MEMBER TYPE HERE -</option>
                <option value="1" <?php if ($carRow['is_member'] == 1) echo 'selected' ?>>Yes</option>
                <option value="0" <?php if ($carRow['is_member'] == 0) echo 'selected' ?>>No</option>
              </select>
          </div>
        </div>

    </div>
    
    <!-- for car_info ID -->
    <?= $form->field($model, 'id')->hiddenInput(['class' => 'form_input form-control', 'id' => 'carInfoId', 'value' => $carRow['id'] ])->label(false) ?>
<?php endforeach; ?>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="insert-item-in-list" id="insert-item-in-list"></div><hr/>
    </div>
</div>

<div class="row">
<br/>
    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-comment"></li> Other Information.</span>
    </div>


    <?= $form->field($model, 'id')->hiddenInput(['class' => 'form_input form-control', 'id' => 'id', 'value' => $result['id'] ])->label(false) ?>


    <?= $form->field($model, 'password')->hiddenInput(['class' => 'form_input form-control', 'id' => 'password', 'value' => $result['password'] ])->label(false) ?>

</div>
<br/>

<div class="row">
    <div class="col-md-6">
        <label  class="form_label">REMARKS</label>
         <textarea name="Customer[remarks]" style="font-size: 11.5px;" placeholder="Write your remarks here." id="message"  class="qtxtarea form-control" data-parsley-trigger="keyup" data-parsley-minlength="10" data-parsley-maxlength="300" data-parsley-minlength-message="You need to enter at least a 10 caracters long comment." data-parsley-validation-threshold="10"><?= strtoupper($result['remarks']) ?></textarea>    
    </div>   
     <br/>
</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button('<li class=\'fa fa-save\'></li> Edit Record', ['class' => 'form-btn btn btn-primary', 'id' => 'saveCustomerForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>


