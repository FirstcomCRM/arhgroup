<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$totalCash = 0;
$totalCreditCard = 0;
$totalNets = 0;
$totalDaysCredit = 0;

$this->title = 'Monthly Sales Report';

?>

<div class="row form-container">

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-pie-chart"></i> Monthly Sales Report </h4></span>
    </div>
    <hr/>

</div>

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-search-container">    
      <?php echo $this->render('_search-monthly-sales',['date_start' => $date_start, 'date_end' => $date_end]); ?>
    </div> 
    
</div>
<br/>

<div class="col-md-12 col-sm-12 col-xs-12">
<br/>
    
    <h4>
        <b><i class="fa fa-feed"></i> Cash Payment</b>
    </h4>

    <table class="table table-boardered table-hover reportsTable">
        <thead class="reportsTableHeader">
            <tr class="headings">
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> INVOICE NUMBER</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> CUSTOMER NAME</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> VEHICLE NUMBER</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> NET TOTAL</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> INTEREST</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> POINTS REDEEM</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> DISCOUNT</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> AMOUNT PAID</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> DATE ISSUE</b></th>
            </tr>
        </thead>
        <tbody>
        	<?php if( !empty($getMonthlySalesCash) ): ?>
                <?php foreach( $getMonthlySalesCash as $row): ?>
                    <tr >
                        <td class="tblalign_center" ><?php echo $row['invoice_no'];  ?></td>
                        <td class="tblalign_center" ><?php echo $row['customerName'];  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['carplate'];  ?></td>
                        <td  class="tblalign_center" ><b>$ <?php echo number_format($row['net_with_interest'],2);  ?></b></td>
                        <td  class="tblalign_center" ><?php echo '.'.$row['interest'].'%';  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['points_redeem'];  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['discount_amount'];  ?></td>
                        <td  class="tblalign_center" ><b>$ <?php echo number_format($row['amount'],2);  ?></b></td>
                        <td  class="tblalign_center" ><?php echo date('m-d-Y', strtotime($row['date_issue']) );  ?></td>
                    </tr>
                <?php $totalCash += $row['amount']; ?>
                <?php endforeach; ?> 
            <?php else: ?>
                <tr>
                    <td><span>No Record Found.</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif; ?> 
        </tbody>
    </table>
    <div class="pull-right">
        <b>Total Cash Payment [ $ <?php echo number_format($totalCash,2); ?> ]</b>
    &nbsp;
    </div>
    <br/><br/>

    <h4>
        <b><i class="fa fa-feed"></i> Credit Card Payment</b>
    </h4>

    <table class="table table-boardered table-hover reportsTable">
        <thead class="reportsTableHeader">
            <tr class="headings">
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> INVOICE NUMBER</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> CUSTOMER NAME</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> VEHICLE NUMBER</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> NET TOTAL</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> INTEREST</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> POINTS REDEEM</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> DISCOUNT</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> AMOUNT PAID</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> DATE ISSUE</b></th>
            </tr>
        </thead>
        <tbody>
            <?php if( !empty($getMonthlySalesCreditCard) ): ?>
                <?php foreach( $getMonthlySalesCreditCard as $row): ?>
                    <tr >
                        <td class="tblalign_center" ><?php echo $row['invoice_no'];  ?></td>
                        <td class="tblalign_center" ><?php echo $row['customerName'];  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['carplate'];  ?></td>
                        <td  class="tblalign_center" ><b>$ <?php echo number_format($row['net_with_interest'],2);  ?></b></td>
                        <td  class="tblalign_center" ><?php echo '.'.$row['interest'].'%';  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['points_redeem'];  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['discount_amount'];  ?></td>
                        <td  class="tblalign_center" ><b>$ <?php echo number_format($row['amount'],2);  ?></b></td>
                        <td  class="tblalign_center" ><?php echo date('m-d-Y', strtotime($row['date_issue']) );  ?></td>
                    </tr>
                <?php $totalCreditCard += $row['amount']; ?>
                <?php endforeach; ?> 
            <?php else: ?>
                <tr>
                    <td><span>No Record Found.</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif; ?> 
        </tbody>
    </table>
    <div class="pull-right">
        <b>Total Credit Card Payment [ $ <?php echo number_format($totalCreditCard,2); ?> ]</b>
    &nbsp;
    </div>
    <br/><br/>

    <h4>
        <b><i class="fa fa-feed"></i> Nets Payment</b>
    </h4>

    <table class="table table-striped table-boardered table-hover reportsTable">     
        <thead class="reportsTableHeader">
            <tr class="headings">
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> INVOICE NUMBER</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> CUSTOMER NAME</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> VEHICLE NUMBER</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> NET TOTAL</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> INTEREST</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> POINTS REDEEM</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> DISCOUNT</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> AMOUNT PAID</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> DATE ISSUE</b></th>
            </tr>
        </thead>
        <tbody>
            <?php if( !empty($getMonthlySalesNets) ): ?>
                <?php foreach( $getMonthlySalesNets as $row): ?>
                    <tr >
                        <td class="tblalign_center" ><?php echo $row['invoice_no'];  ?></td>
                        <td class="tblalign_center" ><?php echo $row['customerName'];  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['carplate'];  ?></td>
                        <td  class="tblalign_center" ><b>$ <?php echo number_format($row['net_with_interest'],2);  ?></b></td>
                        <td  class="tblalign_center" ><?php echo '.'.$row['interest'].'%';  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['points_redeem'];  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['discount_amount'];  ?></td>
                        <td  class="tblalign_center" ><b>$ <?php echo number_format($row['amount'],2);  ?></b></td>
                        <td  class="tblalign_center" ><?php echo date('m-d-Y', strtotime($row['date_issue']) );  ?></td>
                    </tr>
                <?php $totalNets += $row['amount']; ?>
                <?php endforeach; ?> 
            <?php else: ?>
                <tr>
                    <td><span>No Record Found.</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif; ?> 
        </tbody>
    </table>
    <div class="pull-right">
        <b>Total Nets Payment [ $ <?php echo number_format($totalNets,2); ?> ]</b>
    &nbsp;
    </div>
    <br/><br/>

    <h4>
        <b><i class="fa fa-feed"></i> 30 Days Credit Payment</b>
    </h4>

    <table class="table table-striped table-boardered table-hover reportsTable">
        <thead class="reportsTableHeader">
            <tr class="headings">
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> INVOICE NUMBER</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> CUSTOMER NAME</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> VEHICLE NUMBER</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> NET TOTAL</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> INTEREST</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> POINTS REDEEM</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> DISCOUNT</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> AMOUNT PAID</b></th>
                <th class="tblalign_center" ><b><i class="fa fa-compass"></i> DATE ISSUE</b></th>
            </tr>
        </thead>
        <tbody>
            <?php if( !empty($getMonthlySalesDaysCredit) ): ?>
                <?php foreach( $getMonthlySalesDaysCredit as $row): ?>
                    <tr >
                        <td class="tblalign_center" ><?php echo $row['invoice_no'];  ?></td>
                        <td class="tblalign_center" ><?php echo $row['customerName'];  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['carplate'];  ?></td>
                        <td  class="tblalign_center" ><b>$ <?php echo number_format($row['net_with_interest'],2);  ?></b></td>
                        <td  class="tblalign_center" ><?php echo '.'.$row['interest'].'%';  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['points_redeem'];  ?></td>
                        <td  class="tblalign_center" ><?php echo $row['discount_amount'];  ?></td>
                        <td  class="tblalign_center" ><b>$ <?php echo number_format($row['amount'],2);  ?></b></td>
                        <td  class="tblalign_center" ><?php echo date('m-d-Y', strtotime($row['date_issue']) );  ?></td>
                    </tr>
                <?php $totalDaysCredit += $row['amount']; ?>
                <?php endforeach; ?> 
            <?php else: ?>
                <tr>
                    <td><span>No Record Found.</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif; ?> 
        </tbody>
    </table>
    <div class="pull-right">
        <b>Total 30 Days Credit Payment [ $ <?php echo number_format($totalDaysCredit,2); ?> ]</b>
    &nbsp;
    </div>

</div>

<div style="color:#fff">|</div>
<div ><hr/></div>

<div class="btnreportsAlign" >
    <p>
        <?php $form = ActiveForm::begin(['action' => '?r=reports/print-monthly-sales-report-excel', 'method' => 'post']); ?>
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

















