<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$dateIssue = date('m-d-Y', strtotime($customerInfo['date_issue']) );

$this->title = 'View Invoice By Customer Search';

?>

<div class="row ">

<div class="col-md-12">
<br/>

    <div class="x_panel invoiceViewContainer">

        <div class="x_title">
            <h2> <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?> </h2>
            <ul class="nav navbar-right panel_toolbox"></ul>
            <div class="clearfix"></div>
        </div>

    <div class="x_content">

    <section class="content invoice">

    <!-- payment status info row -->
    <?php if( $customerInfo['paid'] == 1 ): ?>
        <div class="row pull-right">    
            <div class="col-md-12 invoice-col">
            <br/>
                <h1><b><i class="fa fa-handshake-o"></i> FULLY PAID! </b></h1>
            </div>
        </div>
    <?php elseif( $customerInfo['paid'] == 2 ): ?>
        <div class="row pull-right">    
            <div class="col-md-12 invoice-col">
            <br/>
                <h1><b><i class="fa fa-handshake-o"></i> PARTIALLY PAID! </b></h1>
            </div>
        </div>
    <?php else: ?>
        <div class="row pull-right">    
            <div class="col-md-12 invoice-col">
            <br/>
                <h1><b><i class="fa fa-handshake-o"></i> UNPAID! </b></h1>
            </div>
        </div>
    <?php endif; ?>
    <!-- /.row -->
    
        <!-- branch info row -->
        <div style="margin-top: -30px;" class="row">    
            <div class="col-md-12 invoice-col">
            <br/>
                <address class="branchRowContainer">
                    <h4><b><i class="fa fa-car"></i> <?= strtoupper($customerInfo['name']) ?></b></h4>
                    <?= $customerInfo['address'] ?>
                    <br><b>Contact #:</b>  <?= $customerInfo['branchNumber'] ?>
                    <br><b>Prepared By:</b> <?= $customerInfo['salesPerson'] ?>
                </address>
            </div>
        </div>
        <!-- /.row -->

        <!-- code and date row -->
        <div class="row">
            <div class="col-xs-12 invoice-header">
                <h3>
                <small class="pull-left"><i class="fa fa-globe"></i> Invoice: <?=$customerInfo['invoice_no'] ?></small>
                <small class="pull-right"><i class="fa fa-calendar"></i> Date Issue: <?= $dateIssue ?></small>
                </h3>
            </div>
        </div>
        <br/>
        <!-- /.row -->

        <!-- customer info row -->
        <div class="row invoice-info customerRowWrapper">
            
            <div class="col-sm-12 invoice-col">
            <br/>
                <address class="customerRowContainer" >
                    <?php if($customerInfo['type'] == 1): ?>
                        <b>Company Name:</b> <?= $customerInfo['company_name'] ?>
                        <br><b>UEN No.:</b> <?= $customerInfo['uen_no'] ?>
                        <br><b>Contact Person:</b> <?= $customerInfo['fullname'] ?>
                    <?php else: ?>
                        <b>Customer Name:</b> <?= $customerInfo['fullname'] ?>
                        <br><b>NRIC:</b> <?= $customerInfo['nric'] ?>
                        <br><b>Race:</b> <?= $customerInfo['raceName'] ?>
                    <?php endif; ?>
                    <br><b>Address:</b> <?= $customerInfo['customerAddress'] ?>
                    <br><b>Phone:</b> <?= $customerInfo['hanphone_no'] ?> / <b>Office #</b> <?= $customerInfo['office_no'] ?>
                    <br><b>CarPlate:</b> <?= $customerInfo['carplate'] ?>
                    <br><b>Make:</b> <?= $customerInfo['make'] ?> 
                    <br><b>Model:</b> <?= $customerInfo['model'] ?>
                    <br><b>Chasis:</b> <?= $customerInfo['chasis'] ?>
                    <br><b>Year MFG.:</b> <?= $customerInfo['year_mfg'] ?>
                    <br><b>Reward Points:</b> <?= $customerInfo['points'] ?>
                    <br><b>Mileage:</b> <?= $customerInfo['mileage'] ?>
                </address>
            </div>
        </div>
        <br/>
        <!-- /.row -->
        
        <!-- Services and Parts Info row -->
        <div id="selectedServicesParts" class="row">
            <div class="col-xs-12 table">
                <table id="selecteditems" class="table table-boardered">
                    <thead>
                        <tr class="qpreviewth">
                            <th class="servicespartsContainerHeader" > Description </th>
                            <th class="servicespartsContainerHeader" > Qty </th>
                            <th class="servicespartsContainerHeader" > Unit Price </th>
                            <th class="servicespartsContainerHeader" > Line Total w/o GST </th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php foreach($parts as $pRow): ?>
                            <tr>
                                <td class="servicespartsLists" ><?php echo $pRow['product_name']; ?></td>
                                <td class="servicespartsLists" ><?php echo $pRow['quantity']; ?></td>
                                <td class="servicespartsLists" >$ <?php echo number_format($pRow['selling_price'],2); ?></td>
                                <td class="servicespartsLists" >$ <?php echo number_format($pRow['subTotal'],2); ?></td>
                            </tr>
                        <?php endforeach; ?> 
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->
        
        <!-- Remarks and Amount Due Info row -->
        <div id="paymentMethod" class="row remarksamountdueWrapper" >
            <div class="col-xs-6">
            <br>
                <p class="lead remarksamountdueHeader"><i class="fa fa-commenting"></i> Remarks.</p>
                <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                    - <?= $customerInfo['remarks'] ?>
                </p>
            <br><br/>
                <p class="lead remarksamountdueHeader"><i class="fa fa-commenting-o"></i> Discount Remarks.</p>
                <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                    - <?= $customerInfo['discount_remarks'] ?>
                </p>
            </div>
        
            <div class="col-xs-6 amountdueContainer">
            <br/>
                <p class="lead remarksamountdueHeader"><i class="fa fa-calculator"></i> Amount Due.</p>
                <div class="table-responsive">
                    <table class="table amountdueTbl">
                        <tbody>
                            <tr>
                                <th style="width:50%;" class="amountdueTh" >Sub-Total </th>
                                <td class="amountdueTd" >$ <?= number_format($customerInfo['grand_total'],2) ?></td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >GST(7.00%) </th>
                                <td class="amountdueTd" > <?= number_format($customerInfo['gst'],2) ?></td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >Discount Amount </th>
                                <td class="amountdueTd" >$ <?= number_format($customerInfo['discount_amount'],2) ?></td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >Nett Total </th>
                                <td class="amountdueTd" >$ <?= number_format($customerInfo['net'],2) ?></td>
                            </tr>
                            <?php if($customerInfo['net'] <> $customerInfo['balance_amount']): ?>
                                <tr>
                                <th class="amountdueTh" > Balance Amount </th>
                                <td class="amountdueTd" >
                                    <a href="#" class="balanceAmount" data-toggle="tooltip" data-placement="top" title="deducted with previous payment/s" >
                                        $ <?= number_format($customerInfo['balance_amount'],2) ?>
                                    </a>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- button container -->
        <hr/>
        <div class="row no-print">
            <div class="col-xs-12">

                <?php if( $customerInfo['paid'] <> 1 ): ?>
                    <a href="?r=invoice/payment-method&id=<?= $customerInfo['id'] ?>"><button class="form-btn btn btn-info btn-lg pull-right" > Proceed to Payment <i class="fa fa-chevron-circle-right"></i></button></a>
                <?php endif; ?>
                
                <?php if( $customerInfo['paid_type'] == 1 ): ?>
                    <a href="?r=invoice/print-invoice&id=<?= $customerInfo['id'] ?>&invoice_no=<?= $customerInfo['invoice_no'] ?>"><button class="form-btn btn btn-success btn-lg pull-right" ><i class="fa fa-print"></i> Print Invoice </button></a>
                <?php elseif( $customerInfo['paid_type'] == 2 ): ?>
                    <a href="?r=invoice/print-multiple-invoice&id=<?= $customerInfo['id'] ?>&invoice_no=<?= $customerInfo['invoice_no'] ?>"><button class="form-btn btn btn-success btn-lg pull-right" ><i class="fa fa-print"></i> Print Invoice </button></a>
                <?php else: ?>
                    <a href="?r=invoice/print-invoice-not-paid&id=<?= $customerInfo['id'] ?>&invoice_no=<?= $customerInfo['invoice_no'] ?>"><button class="form-btn btn btn-success btn-lg pull-right" ><i class="fa fa-print"></i> Print Invoice </button></a>
                <?php endif; ?>
            </div>
        </div>

        <!-- /.row -->
        <?php if( !empty($paymentInformation) ): ?>
            <div class="paymentContainer" >
                <div class="paymentinfoContainer">
                    <div class="paymentContainerHeaderLabel">
                        <div>
                        <br/>
                            <span style="font-weight: 600;"><i class="fa fa-balance-scale"></i> CUSTOMER PAYMENT HISTORY </span>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row transactionFormAlign" >
                    <div class="col-md-12">

                    <!-- start accordion -->
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

                    <?php foreach($paymentInformation as $paymentRow): ?>
                    <?php $n++; ?>
                    <div class="panel">
                        <a class="panel-heading" role="tab" id="<?php echo $paymentRow['id'] ?>" data-toggle="collapse" data-parent="#accordion" href="#collapseOne-<?php echo $paymentRow['id'] ?>" aria-expanded="true" aria-controls="<?php echo $paymentRow['id'] ?>">
                            <h4 class="panel-title">
                                <lable class="paymentinfoLabel"><?php echo $n.'.)'; ?></lable>
                                <label class="paymentLabelHeader"><i class="fa fa-bank"></i> INVOICE #</label>
                                <lable class="paymentinfoLabel"> <?php echo $paymentRow['invoice_no']; ?></lable> 
                                <i class="fa fa-toggle-on pull-right"></i>
                            </h4>
                        </a>
                        <div id="collapseOne-<?php echo $paymentRow['id'] ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $paymentRow['id'] ?>">
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="paymentLabel" >
                                                <label><i class="fa fa-sort"></i> MODE OF PAYMENT</label>
                                            </th>
                                            <th class="paymentLabel" >
                                                <label><i class="fa fa-sort"></i> AMOUNT INTEREST</label>
                                            </th>
                                            <th class="paymentLabel" >
                                                <label><i class="fa fa-sort"></i> PAYMENT DATE</label>
                                            </th>
                                            <th class="paymentLabel" >
                                                <label><i class="fa fa-sort"></i> PAYMENT TIME</label>
                                            </th>
                                            <th class="paymentLabel" >
                                                <label><i class="fa fa-sort"></i> AMOUNT PAID </label>
                                            </th>
                                            <th class="paymentLabel" >
                                                 <label><i class="fa fa-sort"></i> POINTS REDEEM</label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                        <tr>
                                            <td class="paymentSubLabel" >
                                                <lable><?php echo strtoupper($paymentRow['paymentTypeName']); ?></lable>
                                            </td>
                                            <td class="paymentSubLabel" >
                                                <lable><?php echo $paymentRow['interest']; ?></lable>
                                            </td>
                                            <td class="paymentSubLabel" >
                                                <lable><?php echo date('M-d-Y', strtotime($paymentRow['payment_date'])); ?></lable>
                                            </td>
                                            <td class="paymentSubLabel" >
                                                <lable><?php echo date('H:i:s', strtotime($paymentRow['payment_time'])); ?></lable>
                                            </td>
                                            <td class="paymentSubLabel" >
                                                <lable>$<?php echo number_format($paymentRow['amount'],2); ?></lable>
                                            </td>
                                            <td class="paymentSubLabel" >
                                                <lable><?php echo $paymentRow['points_redeem']; ?></lable> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                    </div>
                    <br/>
                    <!-- end of accordion -->

                    </div>
                </div>

            </div>
        <?php endif; ?>

    </section>
    <br/>
    
    </div>
    

    </div>

</div>

</div>