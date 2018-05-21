<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';

?>

<div style="margin-top: 50px;">

<!-- Quotation List -->
<div class="row dashboardContentContainer">
<br/>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-qrcode"></i> Job-Sheet List 
                        <small class="searchCustomerLabel">( Non-Invoice with Pending Services )</small>
                    </h4>
                </div>
            </div>

            <?php if( !empty($getPendingQuotationServices) ): ?>
                <table class="table table-boardered table-striped pendingTable">
                    <thead>
                        <tr class="headings">
                            <td class="tblalign_center" ><b> Date Issue </b></td>
                            <td class="tblalign_center" ><b> Jobsheet # </b></td>
                            <td class="tblalign_center" ><b> Description </b></td>
                            <td class="tblalign_center" ><b> Qty </b></td>
                            <td class="tblalign_center" ><b> Unit Price </b></td>
                            <td class="tblalign_center" ><b> Line Total w/o GST </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $getPendingQuotationServices as $qRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($qRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><b><?php echo $qRow['quotation_code']; ?></b></td>
                                <td class="tblalign_center" ><b><?php echo $qRow['service_name']; ?></b></td>
                                <td class="tblalign_center" ><?php echo $qRow['quantity']; ?></td>
                                <td class="tblalign_center" >$ <?php echo number_format($qRow['selling_price'],2); ?></td>
                                <td class="tblalign_center" >$ <?php echo number_format($qRow['subTotal'],2); ?></td>
                            </tr>
                        <?php endforeach; ?>     
                    </tbody>
                </table>
            <?php else: ?>
                <div>
                    <span class="pendingNoRecordDashboard"> - No Record Found. <span>
                </div>
                <br/>
            <?php endif; ?>

        </div>
    </div>
</div>
<br/>

<!-- Invoice List -->
<div class="row dashboardContentContainer">
<br/>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-barcode"></i> Invoice List 
                        <small class="searchCustomerLabel">( Pending Services with Invoice )</small>
                    </h4>
                </div>
            </div>

            <?php if( !empty($getPendingInvoiceServices) ): ?>
                <table class="table table-boardered table-striped pendingTable">
                    <thead>
                        <tr class="headings">
                            <td class="tblalign_center" ><b> Date Issue </b></td>
                            <td class="tblalign_center" ><b> Invoice # </b></td>
                            <td class="tblalign_center" ><b> Description </b></td>
                            <td class="tblalign_center" ><b> Qty </b></td>
                            <td class="tblalign_center" ><b> Unit Price </b></td>
                            <td class="tblalign_center" ><b> Line Total w/o GST </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $getPendingInvoiceServices as $iRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($iRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><b><?php echo $iRow['invoice_no']; ?></b></td>
                                <td class="tblalign_center" ><b><?php echo $iRow['service_name']; ?></b></td>
                                <td class="tblalign_center" ><?php echo $iRow['quantity']; ?></td>
                                <td class="tblalign_center" >$ <?php echo number_format($iRow['selling_price'],2); ?></td>
                                <td class="tblalign_center" >$ <?php echo number_format($iRow['subTotal'],2); ?></td>
                            </tr>
                        <?php endforeach; ?>     
                    </tbody>
                </table>
            <?php else: ?>
                <div>
                    <span class="pendingNoRecordDashboard"> - No Record Found. <span>
                </div>
                <br/>
            <?php endif; ?>

        </div>
    </div>
</div>