<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use common\models\Customer;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';

?>

<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data'], 'id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row form-container">

<div>
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
            <h5 class="alert-heading"><i class="fa fa-info-circle"></i> <?= Yii::$app->session->getFlash('success'); ?></h5>
        </div>
    <?php endif; ?>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">

<div class="form-title-container">
    <span class="form-header"><h4><i class="fa fa-wrench"></i> Settings</h4></span>
</div>
<hr/>

<div class="row">
	 <div class="col-md-12 col-sm-12 col-xs-12">
	 	<h5><i class="fa fa-pencil-square-o"></i> Update Account Information</h5>
	 </div>
</div>
<br/>

<div class="row">	 
	 <div class="col-md-4">
	 	<label>User Image</label>
	 	<i class="settingsSubLabel">(jpeg and png image-file only)</i>
	 	<input type="file" name="User[photo]" id="photo" class="form_input " placeholder="Choose here." accept="jpg|jpeg|png" required="required" />
	 </div>
</div>
<br/>

<div class="row">
	 <div class="col-md-4">
	 	<label>Fullname</label>
	 	<input type="text" name="User[fullname]" id="fullname" class="form_input form-control" value="<?= strtoupper($model->fullname) ?>" placeholder="Change your Fullname here." required="required" />
	 </div>
</div>
<br/>

<div class="row">
	 <div class="col-md-4">
	 	<label>Email</label>
	 	<input type="text" name="User[email]" id="username" class="form_input form-control" value="<?= strtoupper($model->email) ?>" placeholder="Change your Email here." required="required" />
	 </div>
</div>
<br/>

<div class="row">
	 <div class="col-md-4">
	 	<label>Username</label>
	 	<input type="text" name="User[username]" id="username" class="form_input form-control" value="<?= strtoupper($model->username) ?>" placeholder="Change your Username here." required="required" />
	 </div>
</div>
<br/>

<div class="row">
	 <div class="col-md-4">
	 	<input type="checkbox" class="showPassword" id="showPassword" /><span class="hidePriceLabel" id="hidePriceLabel"> Change Password ?</span>
	 </div>
</div>

<diV id="passwordContainer">
<br/>

	<div class="row">
		 <div class="col-md-4">
		 	<label>Old Password</label>
		 	<input type="password" name="User[password]" id="old_password" class="form_input form-control" value="<?= $model->password ?>" placeholder="Enter your old-password here."  />
		 </div>
	</div>
	<br/>

	<div class="row">
	 	<div class="col-md-4">
		 	<label>New Password</label>
		 	<input type="password" name="newPassword" id="new_password" class="form_input form-control" value="" placeholder="Enter your new-password here." />
		 </div>
	 </div>
</diV>

<div class="row">
	 <div class="col-md-4">
	 <hr/>
	 	<div style="text-align: right;">
	            <?= Html::Button('<li class=\'fa fa-save\'></li> Save Changes', ['type' => 'submit', 'class' => 'form-btn btn btn-primary']) ?>
	    </div>
	 </div>
</div>
<br/>

</div>

</div>

<?php ActiveForm::end(); ?>