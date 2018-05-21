<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Customer';

?>

<div class="row form-container">
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">

 <div class="form-title-container">
    <span class="form-header"><h4><i class="fa fa-users"></i> View Customer Information</h4></span>
 </div>
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>

        <?= Html::a( '<i class="fa fa-pencil-square"></i> Edit', '?r=customer/update&id=' . $model['id'], ['class' => 'form-btn btn btn-info']); ?>

        <?= Html::a( '<i class="fa fa-trash"></i> Delete', '?r=customer/delete-column&id=' . $model['id'], ['class' => 'form-btn btn btn-danger', 'onclick' => 'return deleteConfirmation()']); ?>
    </div>
 </div>
 <br/><br/><br/>

 <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="tbl-container viewDesign">

        <?php if( $model['type'] == '1' ): ?>
            <label>&nbsp;<i class="fa fa-bank"></i> Company Information</label>
        <?php else: ?>
            <label>&nbsp;<i class="fa fa-user-circle-o"></i> Personal Information</label>
        <?php endif; ?>

        <table class="table table-striped table-hover">
        <?php if(count($model) > 0 ): ?>
            <?php if( $model['type'] == '1' ): ?>
            <tr>
                <td><b>COMPANY NAME</b></td>
                <td><?= $model['company_name']; ?></td>
            </tr>
            <tr>
                <td><b>UEN NO.</b></td>
                <td><?= $model['uen_no']; ?></td>
            </tr>
            <tr>
                <td><b>CONTACT PERSON</b></td>
                <td><?= $model['fullname']; ?></td>
            </tr>
            <?php endif; ?>

            <?php if( $model['type'] == '2' ): ?>
            <tr>
                <td><b>FULLNAME</b></td>
                <td><?= $model['fullname']; ?></td>
            </tr>
            <tr>
                <td><b>NRIC</b></td>
                <td><?= $model['nric']; ?></td>
            </tr>
            <tr>
                <td><b>RACE</b></td>
                <td><?= $model['name']; ?></td>
            </tr>
            <?php endif; ?>

            <tr>
                <td><b>ADDRESS</b></td>
                <td><?= $model['address']; ?></td>
            </tr>
            <tr>
                <td><b>PHONE NUMBER</b></td>
                <td><?= $model['hanphone_no']; ?></td>
            </tr>
            <tr>
                <td><b>OFFICE NUMBER</b></td>
                <td><?= $model['office_no']; ?></td>
            </tr>
            <tr>
                <td><b>FAX NUMBER</b></td>
                <td><?= $model['fax_number']; ?></td>
            </tr>
            <tr>
                <td><b>EMAIL</b></td>
                <td><?= $model['email']; ?></td>
            </tr>

             <tr>
                <td><b>REMARKS</b></td>
                <td><?= $model['remarks']; ?></td>
            </tr>
            <tr>
                <td><b>BLACKLISTED</b></td>
                <td><?= ($model['is_blacklist'] == 1)? 'Yes' : 'No'; ?></td>
            </tr>
            <tr>
                <td><b>STATUS</b></td>
                <td><?= ($model['status'] == 1)? 'Active' : 'Inactive'; ?></td>
            </tr>
            <?php else: ?>
                <tr>
                    <td><b>NO RECORD FOUND</b></td>
                </tr>
            <?php endif; ?>
        </table>

        <label>&nbsp;<i class="fa fa-cab"></i> Vehicle Information</label>
        <table class="table table-striped table-hover">
            <tr>
                <td><b>VEHICLE NUMBER</b></td>
                <td><b>CAR MAKE</b></td>
                <td><b>CAR MODEL</b></td>
                <td><b>ENGINE NUMBER</b></td>
                <td><b>YEAR MFG</b></td>
                <td><b>CHASIS</b></td>
                <td><b>REWARD POINTS</b></td>
                <td><b>MEMBER-JOIN DATE</b></td>
                <td><b>MEMBER-EXPIRY DATE</b></td>
                <td><b>MEMBER</b></td>
            </tr>
            <?php if(count($carModel) > 0 ): ?>
                <?php foreach($carModel as $carRow): ?>
                <tr>
                    <td><?= $carRow['carplate']; ?></td>
                    <td><?= $carRow['make']; ?></td>
                    <td><?= $carRow['model']; ?></td>
                    <td><?= $carRow['engine_no']; ?></td>
                    <td><?= $carRow['year_mfg']; ?></td>
                    <td><?= $carRow['chasis']; ?></td>
                    <td><?= $carRow['points']; ?></td>
                    <td>
                      <?php
                      if (!is_null($carRow['join_date'])) {
                         echo date('d-M-Y', strtotime($carRow['join_date']) );
                      }else{
                        echo '';
                      }
                       ?>
                    </td>
                    <td>
                      <?php
                        if (!is_null($carRow['member_expiry']) ) {
                           echo date('d-M-Y', strtotime($carRow['member_expiry']) );
                        }else{
                          echo '';
                        }
                       ?>
                    </td>
                    <td>
                      <?php
                        if (!empty($carRow['is_member'])) {
                          echo ($carRow['is_member'] == 1)? 'Yes':'No' ;
                        }else{
                          echo  ($model['is_member'] == 1)? 'Yes' : 'No';
                        }
                       ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td><b>NO RECORD FOUND</b></td>
                <?php for($x = 1; $x <= 6; $x++ ){ ?>
                    <td></td>
                <?php } ?>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <br/>

 </div>

</div>
