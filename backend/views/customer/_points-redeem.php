<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Redeem Points';

?>

<div class="row form-container">
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">
    
 <div class="form-title-container">
    <span class="form-header"><h4><i class="fa fa-users"></i> View Redeem Points</h4></span>
 </div>      
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
    </div>
 </div>    
 <br/>

<?php if(!empty($getCarPoints)): ?>
<?php foreach($getCarPoints as $pointsRow): ?>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="tile-stats">
        <br/><div class="icon"><br/>
            <i class="fa fa-bell-o"></i>
        </div>

        <div class="count">
            <?= $pointsRow['points'] ?>
        </div>

        <h3><?= $pointsRow['carplate'] ?></h3><br/>
    </div>
</div>


<div class="col-md-12 col-sm-12 col-xs-12">
<hr/>

    <div class="tbl-container viewDesign">  
        <h4><i class="fa fa-minus-circle"></i> Redeemed Points List </h4>
        
        
            <table style="border: solid 1px #eee;" class="table table-hover table-striped">
                
                    <tr>
                        <td><b>TRANSACTION #</b></td>
                        <td>123456</td>
                        <td><b>INVOICE NUMBER</b></td>
                        <td>INV123456</td>
                        <td><b>REDEEM POINTS</b></td>
                        <td>123</td>
                        <td><b>TRANSACTION DATE</b></td>
                        <td>03-08-2017</td>
                        <td><b>TRANSACTION TIME</b></td>
                        <td>18:00:00</td>
                    </tr>
                
            </table>

            <div>
                &nbsp; <h5> <b>-No Record Found.</b> </h5>
            </div>

    </div>   

<hr/>
</div>
<?php endforeach; ?>
<?php endif;?>

</div>