<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>

<div class="car-item-<?= $n ?> row">
<hr/>
    <div class="col-md-12">     
        <span class="edit-car-button-<?= $n ?> edit-button">
            - <a href="javascript:editSelectedCarItem(<?= $n ?>)" class="selectedBtns" ><i class="fa fa-edit"></i> Edit</a>
        </span>
        <span class="save-car-button-<?= $n ?> save-button hidden">
           - <a href="javascript:saveSelectedCarItem(<?= $n ?>)" class="selectedBtns" ><i class="fa fa-save"></i> Save</a>
        </span>
        &nbsp;
        <span class="remove-car-button-<?= $n ?> remove-button">
            <a href="javascript:removeSelectedCarItem(<?= $n ?>)" class="selectedBtns" ><i class="fa fa-trash"></i> Remove</a> -
        </span> 
    </div>
</div>

<div class="car-item-<?= $n ?> row">
    <div class="col-md-4">     
        <div class="quoSPLabel"> <b><span><i class="fa fa-credit-card-alt"></i> Vehicle Number </span></b> </div>
        <input type="text" id="car-item-carplate-<?= $n ?>" name="carplate[]" class="vehicleNumber form_quoSP form-control" value="<?= strtoupper($car_plate) ?>" readonly />
        <br/>
    </div>

    <div class="col-md-4">     
        <div class="quoSPLabel"> <b><span><i class="fa fa-taxi"></i> Car Model </span></b> </div>
        <input type="text" id="car-item-carmodel-<?= $n ?>" name="carmodel[]" class="carModel form_quoSP form-control" value="<?= strtoupper($car_model) ?>" readonly />
        <br/>
    </div>

    <div class="col-md-4">     
        <div class="quoSPLabel"> <b><span><i class="fa fa-google-wallet"></i> Car Make </span></b> </div>
        <input type="text" id="car-item-carmake-<?= $n ?>" name="carmake[]" class="carMake form_quoSP form-control" value="<?= strtoupper($car_make) ?>" readonly />
        <br/>
    </div>
</div>

<div class="car-item-<?= $n ?> row">
    <div class="col-md-4">     
        <div class="quoSPLabel"> <b><span><i class="fa fa-chrome"></i> Chasis </span></b> </div>
        <input type="text" id="car-item-chasis-<?= $n ?>" name="chasis[]" class="chasis form_quoSP form-control" value="<?= strtoupper($chasis) ?>" readonly />
        <br/>
    </div>

    <div class="col-md-4">     
        <div class="quoSPLabel"> <b><span><i class="fa fa-codepen"></i> Engine No. </span></b> </div>
        <input type="text" id="car-item-engineno-<?= $n ?>" name="engineno[]" class="engineNo form_quoSP form-control" value="<?= strtoupper($engine_no) ?>" readonly />
        <br/>
    </div>

    <div class="col-md-4">     
        <div class="quoSPLabel"> <b><span><i class="fa fa-calendar-minus-o"></i> Year Mfg </span></b> </div>
        <input type="text" id="car-item-yearmfg-<?= $n ?>" name="yearmfg[]" class="yearMfg form_quoSP form-control" value="<?= $year_mfg ?>" readonly />
        <br/>
    </div>
</div>

<div class="car-item-<?= $n ?> row">
    <div class="col-md-4">     
        <div class="quoSPLabel"> <b><span><i class="fa fa-money"></i> Reward Points </span></b> </div>
        <input type="text" id="car-item-rewardpoints-<?= $n ?>" name="rewardpoints[]" class="rewardPoints form_quoSP form-control" value="<?= $reward_points ?>" readonly />
    </div>
    <div class="col-md-4">
        <div class="quoSPLabel"> <b><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Join Date </span></b> </div>
        <input type="text" id="car-item-joindate-<?= $n ?>" name="joindate[]" class="datepickers joindate form_quoSP form-control" value="<?= $join_date ?>" readonly style="pointer-events: none" />
    </div>

    <div class="col-md-4">
        <div class="quoSPLabel"> <b><span><i class="fa fa-calendar-times-o" aria-hidden="true"></i> Expire Date </span></b> </div>
        <input type="text" id="car-item-expiredate-<?= $n ?>" name="expiredate[]" class="datepickers expiredate form_quoSP form-control" value="<?= $expire_date ?>" readonly style="pointer-events: none" />
    </div>

</div>
<br>

<div class="car-item-<?= $n ?> row">

    <div class="col-md-4">
        <div class="quoSPLabel"> <b><span><i class="fa fa-calendar-times-o" aria-hidden="true"></i> Member </span></b> </div>
        <select class="form_input form_quoSP form_control select2_single member" name="member[]" style="width:100%; height:30px;pointer-events: none" id="car-item-member-<?= $n ?>">
          <option value="3" <?php if ($member == 3) echo 'selected' ?>>- SELECT MEMBER TYPE HERE -</option>
          <option value="1" <?php if ($member == 1) echo 'selected' ?>>Yes</option>
          <option value="0" <?php if ($member == 0) echo 'selected' ?>>No</option>
        </select>
    </div>

</div>

<input type="hidden" name="carid[]" value="" class="carId"/>
