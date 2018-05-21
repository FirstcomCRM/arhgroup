<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monthly Stock Report';

?>

<div class="row form-container">

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-pie-chart"></i> Best Selling Product Report</h4></span>
    </div>
    <hr/>

</div>

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-search-container">    
      <?php echo $this->render('_search-best-selling-product',['date_start' => $date_start, 'date_end' => $date_end]); ?>
    </div> 
    
</div>
<br/>

<div class="col-md-12 col-sm-12 col-xs-12">
<br/>

    <table id="tbldesign" class="table table-striped table-boardered table-hover reportsTable responsive-utilities jambo_table">
        
        <thead>
            <tr class="headings">
                <th class="tblalign_center" ><b>INVOICE NUMBER</b></th>
                <th class="tblalign_center" ><b>CATEGORY</b></th>
                <th class="tblalign_center" ><b>SERVICE NAME / PRODUCT NAME</b></th>
                <th class="tblalign_center" ><b>QUANTITY</b></th>
                <th class="tblalign_center" ><b>UNIT PRICE</b></th>
                <th class="tblalign_center" ><b>LINE TOTAL</b></th>
            </tr>
        </thead>
        <tbody>
        	<?php if( !empty($getBestSellingParts) ): ?>
                <?php foreach( $getBestSellingParts as $row){ ?>
                    <tr >
                        <td class="tblalign_center" ><?php echo $row['invoice_no'];  ?></td>
                        <td class="tblalign_center" ><?php echo $row['category'];  ?></td>
                        <td class="tblalign_center" ><b><?php echo $row['product_name'];  ?></b></td>
                        <td class="tblalign_center" ><b><?php echo $row['quantity'];  ?></b></td>
                        <td  class="tblalign_center" >$ <?php echo number_format($row['selling_price'],2);  ?></td>
                        <td  class="tblalign_center" ><b>$ <?php echo number_format($row['subTotal'],2);  ?></b></td>
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

<div style="color:#fff">|</div>
<div ><hr/></div>

<div class="btnreportsAlign" >
    <p>
        <?php $form = ActiveForm::begin(['action' => '?r=reports/print-best-selling-product-report-excel', 'method' => 'post']); ?>
            <input type="hidden" id="date_start" value="<?= $date_start ?>" name="dateStart" />
            <input type="hidden" id="date_end" value="<?= $date_end ?>" name="dateEnd" />
         <button type="submit" class="form-btn btn btn-dark btn-lg" onclick="return excelPrintConfirmation()" >
            <i class="fa fa-download"></i> <b> Print to Excel </b>
         </button>
        <?php ActiveForm::end(); ?>
    </p>
    &nbsp;
</div>

</div>















