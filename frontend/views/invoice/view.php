<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$dateIssue = date('m-d-Y', strtotime($customerInfo['date_issue']) );

$this->title = 'View Quotation';

?>

<div class="row ">
<div class="col-md-12">
<br/>

<div class="x_panel invoiceViewContainer">

    <div class="x_title">
        <h2> Invoice Details.</h2>
        <ul class="nav navbar-right panel_toolbox"></ul>
        <div class="clearfix"></div>
    </div>

<div class="x_content">
<section class="content invoice">

    <!-- branch info row -->
    <div class="row">
        
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
            <small class="pull-left"><i class="fa fa-globe"></i> <?=$customerInfo['invoice_no'] ?></small>
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
                <b>Customer Name:</b> <?= $customerInfo['fullname'] ?>
                <br><b>Address:</b> <?= $customerInfo['customerAddress'] ?>
                <br><b>Phone:</b> <?= $customerInfo['hanphone_no'] ?> / <b>Office #</b> <?= $customerInfo['office_no'] ?>
                <br><b>CarPlate:</b> <?= $customerInfo['carplate'] ?>
                <br><b>Model:</b> <?= $customerInfo['carplate'] ?>
                <br><b>Mileage:</b> <?= $customerInfo['mileage'] ?>
            </address>
        </div>
    </div>
    <br/>
    <!-- /.row -->

    <!-- Services and Parts Info row -->
    <div id="selectedServicesParts" class="row">
        <div class="col-xs-12 table">
            <table id="selecteditems" class="table table-boaredered">
                <thead>
                    <tr class="qpreviewth">
                        <th class="servicespartsContainerHeader" > Description </th>
                        <th class="servicespartsContainerHeader" > Qty </th>
                        <th class="servicespartsContainerHeader" > Unit Price </th>
                        <th class="servicespartsContainerHeader" > Line Total w/o GST </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($services as $sRow): ?>
                        <tr>
                            <td class="servicespartsLists" ><?php echo $sRow['service_name']; ?></td>
                            <td class="servicespartsLists" ><?php echo $sRow['quantity']; ?></td>
                            <td class="servicespartsLists" >$ <?php echo number_format($sRow['selling_price'],2); ?></td>
                            <td class="servicespartsLists" >$ <?php echo number_format($sRow['subTotal'],2); ?></td>
                        </tr>
                    <?php endforeach; ?>  
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
    <div id="paymentMethod" class="row remarksamountdueWrapper">
        <div class="col-xs-6">
        <br>
            <p class="lead remarksamountdueHeader"><i class="fa fa-comments"></i> Remarks.</p>
            <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                - <?= $customerInfo['remarks'] ?>
            </p>
        </div>
    
        <div class="col-xs-6 amountdueContainer">
        <br/>
            <p class="lead remarksamountdueHeader"><i class="fa fa-calculator"></i> Amount Due.</p>
            <div class="table-responsive">
                <table class="table amountdueTbl">
                    <tbody>
                        <tr>
                            <th style="width:50%;" class="amountdueTh" >Gross Total :</th>
                            <td class="amountdueTd" >$ <?= number_format($customerInfo['grand_total'],2) ?></td>
                        </tr>
                        <tr>
                            <th class="amountdueTh" >GST(7.00%) :</th>
                            <td class="amountdueTd" > <?= number_format($customerInfo['gst'],2) ?></td>
                        </tr>
                        <tr>
                            <th class="amountdueTh" >Nett Total :</th>
                            <td class="amountdueTd" >$ <?= number_format($customerInfo['net'],2) ?></td>
                        </tr>
                        <?php if($customerInfo['net'] <> $customerInfo['balance_amount']): ?>
                            <tr>
                            <th class="amountdueTh" > Balance Amount :</th>
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

</section>
</div>

</div>

</div>
</div>

    

            

  

    
