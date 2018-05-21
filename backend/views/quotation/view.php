<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;
use common\models\Invoice;

$dateIssue = date('m-d-Y', strtotime($customerInfo['date_issue']) );

$this->title = 'View Quotation';

?>

<div class="row ">

<div class="col-md-12">
<br/>

    <div class="x_panel quotationViewContainer">

        <div class="x_title">
            <h2> <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?> </h2>
            <ul class="nav navbar-right panel_toolbox">
                
            </ul>
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <br/><br/><br/>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>
        </div>

    <div class="x_content">

    <section class="content invoice">

    <!-- payment status info row -->
    <?php if( $customerInfo['invoice'] == 1 ): ?>
        <div class="row pull-right">    
            <div class="col-md-12 invoice-col">
            <br/>
                <h1><b><i class="fa fa-barcode"></i> INVOICE CREATED </b></h1>
            </div>
        </div>
    <?php endif; ?>
    <!-- /.row -->

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
                <small class="pull-left"><i class="fa fa-globe"></i> <?=$customerInfo['quotation_code'] ?></small>
                <small class="pull-right"><i class="fa fa-calendar-o"></i> Date Issue: <?= $dateIssue ?></small>
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
                            <th class="servicespartsContainerHeader"> Description </th>
                            <th class="servicespartsContainerHeader"> Qty </th>
                            <th class="servicespartsContainerHeader"> Unit Price </th>
                            <th class="servicespartsContainerHeader"> Line Total w/o GST </th>
                        </tr>
                    </thead>
                    <tbody>     
                        <?php foreach($quotationDetail as $key=>$item) { ?>
                            <tr>
                                <td class="servicespartsLists" >
                                    <?php if($item['task']==1):?>
                                        <a href="#" style="color: red;" data-toggle="tooltip" data-placement="top" title="Pending Service" >
                                            <?php echo '*' .$item['service_part_id']; ?>
                                         </a>
                                    <?php else: ?>
                                        <?= $item['type'] == 1 ? $item['product_name'] : $item['service_part_id']; ?>
                                    <?php endif;?>
                                </td>
                                <td class="servicespartsLists"><?= $item['quantity']; ?></td>
                                <td class="servicespartsLists"><?=substr($item['selling_price'],0,1)=='-' ? '($ '.substr($item['selling_price'],1).')':'$ '.$item['selling_price']?></td>
                                <td class="servicespartsLists"><?=substr($item['subTotal'],0,1)=='-' ? '($ '.substr($item['subTotal'],1).')':'$ '.$item['subTotal']?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->

        <!-- Remarks and Amount Due Info row -->
        <div id="paymentMethod" class="row remarksamountdueWrapper">
            <div class="col-xs-6">
            <br>
                <p class="lead remarksamountdueHeader"><i class="fa fa-commenting"></i> Remarks.</p>
                <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                    - <?= $customerInfo['remarks'] ?>
                </p>
            <!-- <br>
                <p class="lead remarksamountdueHeader"><i class="fa fa-commenting-o"></i> Discount Remarks.</p>
                <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                    - <?= $customerInfo['discount_remarks'] ?>
                </p> -->
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
                            <!-- <tr>
                                <th class="amountdueTh" >Discount Amount </th>
                                <td class="amountdueTd" >$ <?= number_format($customerInfo['discount_amount'],2) ?></td>
                            </tr> -->
                            <tr>
                                <th class="amountdueTh" >Nett Total </th>
                                <td class="amountdueTd" >$ <?= number_format($customerInfo['net'],2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- button container -->
        <br/><hr/>
        <div class="row no-print">
            <div class="col-xs-12">
                <?php if( $customerInfo['invoice'] == 0 ): ?>
                    <a href="?r=quotation/update&id=<?= $customerInfo['id'] ?>"><button class="form-btn btn btn-warning btn-lg pull-left"><i class="fa fa-edit"></i> Edit Job-Sheet </button></a>
                <?php endif; ?>

                    <a onclick="return confirm('Are you sure, you want to delete quotation?')" href="?r=quotation/delete-column&id=<?= $customerInfo['id'] ?>"><button class="form-btn btn btn-danger btn-lg pull-left"><i class="fa fa-trash"></i> Delete Job-Sheet </button></a>

                <?php if( $customerInfo['invoice'] == 0 ): ?>
                    <a href="?r=quotation/insert-invoice&id=<?= $customerInfo['id'] ?>"><button class="form-btn btn btn-info btn-lg pull-right"><i class="fa fa-pencil-square-o"></i> Generate Invoice</button></a>
                <?php endif; ?>

                <a href="?r=quotation/preview&id=<?php echo $customerInfo['id']; ?>"><button class="form-btn btn btn-success btn-lg pull-right" ><i class="fa fa-print"></i> Print Job-Sheet</button></a>
            </div>
        </div>
        <br/><br/>
        <!-- /.row -->
        
    </section>

    </div>

    </div>

</div>

</div>