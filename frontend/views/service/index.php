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
        <span class="form-header"><h4><i class="fa fa-battery-quarter"></i> AVAILABLE SERVICES LIST</h4></span>
    </div>
    <hr/>

</div>

<div class="col-md-12 col-sm-12 col-xs-12">
<br/>

    <table id="tbldesign" class="table table-striped table-boardered table-hover reportsTable responsive-utilities jambo_table">
        
        <thead>
            <tr class="headings">
            	<th class="tblalign_center" ><b>#</b></th>
                <th class="tblalign_center" ><b>SERVICE CATEGORY</b></th>
                <th class="tblalign_center" ><b>SERVICE NAME</b></th>
                <th class="tblalign_center" ><b>DESCRIPTION</b></th>
            </tr>
        </thead>
        <tbody>
        	<?php if( !empty($getServicesList) ): ?>
                <?php foreach( $getServicesList as $row){ ?>
                    <tr >
                    	<td class="tblalign_center" ><?php echo $row['id'];  ?></td>
                        <td class="tblalign_center" ><?php echo $row['name'];  ?></td>
                        <td class="tblalign_center" ><b><?php echo $row['service_name'];  ?></b></td>
                        <td class="tblalign_center" ><?php echo $row['description'];  ?></td>
                    </tr>
                <?php } ?> 
            <?php else: ?>
                <tr>
                    <td><span>No Record Found.</span></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif; ?> 
        </tbody>

    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/></div>

</div>
















