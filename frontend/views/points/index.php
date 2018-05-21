<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services List';

?>

<div class="row form-container">

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-money"></i> YOUR POINTS </h4></span>
    </div>
    <hr/>

</div>

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	    <div class="tile-stats">
	    	
	    	<br/><div class="icon"><br/>
	            <i class="fa fa-bell-o"></i>
	        </div>

	        <div class="count">
	            <?= $customerPoints ?>
	        </div>

	        <h3>TOTAL POINTS</h3><br/>

	    </div>
	</div>

 	<div class="col-md-12 col-sm-12 col-xs-12 viewDesign">
 	<hr/>

 	<h4><i class="fa fa-minus-circle"></i> Redeemed Points List </h4>
 	<?php if( !empty($getRedeemPoints) ): ?>
        	
            <table style="border: solid 1px #eee;" class="table table-hover table-striped">
                <?php foreach($getRedeemPoints as $rpRow): ?>
                    <tr>
                        <td><b>TRANSACTION #</b></td>
                        <td><?php echo $rpRow['id']; ?></td>
                        <td><b>INVOICE NUMBER</b></td>
                        <td><?php echo $rpRow['invoice_no']; ?></td>
                        <td><b>REDEEM POINTS</b></td>
                        <td><?php echo $rpRow['points_redeem']; ?></td>
                        <td><b>TRANSACTION DATE</b></td>
                        <td><?php echo date('M-d-Y', strtotime($rpRow['payment_date'])); ?></td>
                        <td><b>TRANSACTION TIME</b></td>
                        <td><?php echo $rpRow['payment_time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php else: ?>
            <div>
                &nbsp; <h5> <b>- No Record Found.</b> </h5>
            </div>

    <?php endif; ?>
    </div>

</div>

<div style="color:#fff">|<br/>|<br/></div>

</div>

















