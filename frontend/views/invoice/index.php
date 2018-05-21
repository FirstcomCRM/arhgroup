<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice';

?>

<div class="row form-container">

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-files-o"></i> Invoice List</h4></span>
    </div>
    <hr/>

</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-search-container">    
          
          <?php echo $this->render('_search', [
                                'model' => $searchModel, 
                                'date_start' => $date_start, 
                                'date_end' => $date_end
                            ]); ?>
    
    </div> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12">

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="no-link first tblalign_center" ><span class="nobr">#</span>
            <th class="tblalign_center" ><b>DATE ISSUE</b></th>
            <th class="tblalign_center" ><b>BRANCH</b></th>
            <th class="tblalign_center" ><b>INVOICE NUMBER</b></th>
            <th class="tblalign_center" ><b>PAID</b></th>
            <th class="no-link last tblalign_center" ><span class="nobr">VIEW INVOICE</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getCustomerInvoice) ): ?>
            <?php foreach( $getCustomerInvoice as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="first tblalign_center" ><?php echo $row['id'];  ?></td>
                    <td class="tblalign_center" ><b><?php echo date('m-d-Y', strtotime($row['date_issue']) );  ?></b></td>
                    <td class="tblalign_center" ><?php echo $row['name'];  ?></td>
                    <td class="tblalign_center" ><b><?php echo $row['invoice_no'];  ?></b></td>
                    <td class="tblalign_center" style="font-style: italic;" ><b><?php echo ( $row['paid'] == 1 )? 'Yes' : 'Not Yet';  ?></b></td>
                    <td class="last tblalign_center">
                        <a href="?r=invoice/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-search"></li> </a>
                    </td>
                </tr>
            <?php } ?> 
        <?php else: ?>
            <tr>
                <td><span>No Record Found.</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endif; ?> 
    </tbody>
    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/></div>

</div>


















