<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\PaymentType;
use common\models\PaymentStatus;

$dataPaymentType = PaymentType::find()->all();
$dataPaymentStatus = PaymentStatus::find()->all();

$this->title = 'View Quotation';

$datetime = date('M-d-Y') . ' ' . date('H:i:s');

$dateIssue = date('m-d-Y', strtotime($customerInfo['date_issue']) );

$n = 0;

?>

<div class="row form-container">
<br/>

<div class="col-md-6">
 
 <!-- Payment Section -->
 <div class="col-md-12" >
            
    <div class="x_title">
        <h2> <i class="fa fa-bank"></i> Payment Method. </h2>
        <ul class="nav navbar-right panel_toolbox"></ul>
        <div class="clearfix"></div>
    </div>
    <br/>
    <form id="payment_form" action="?r=invoice/submit-payment" method="post">
    <div class="row">
        <div class="col-md-7">

            <span class="pmLabel" ><i class="fa fa-question-circle"></i> PAYMENT METHOD </span>
            <br/>
            <select  name="paymentMethod" class="form_pm form-control" data-placeholder="CHOOSE PAYMENT TYPE HERE" id="getpaymentMethod" >
                <option value='0'>CHOOSE PAYMENT METHOD HERE.</option>   
                <option value='1'>SINGLE PAYMENT</option>             
                <option value='2'>MULTIPLE PAYMENT</option>
            </select>
        </div>

    </div>
    <br/>


    <div class="row">
        
    </div>



    <div class="paymentContainer" id="singleMethod" style="display:block">

        <div class="paymentContainerHeader" style="background-color:transparent; color:black">
            <div class="paymentContainerHeaderLabel" style="color:black; border-bottom:1px solid #eee">
                
                <div>
                <br/>
                    <span style="font-weight: 600;padding-left:10px"><i class="fa fa-mail-reply-all"></i> SINGLE PAYMENT METHOD.</span>
                </div>
            </div>

        </div>
        <br/>

        <div class="row transactionFormAlign" >
        
                <div  class="row transactionFormAlign">
                    <div class="col-md-8">
                        <span class="pmLabel"><i class="fa fa-bookmark"></i> Date & Time - </span>   
                        <br/>
                        <input type="text" value="<?= $datetime ?>" style="width: 90%;" class="form-control form_pmInput" name="datetime" id="sDateTime" readonly/>
                    </div>
                </div>
                <br/>

                <div class="row transactionFormAlign" >
                    <div class="col-md-8">
                        <span class="pmLabel" ><i class="fa fa-bookmark"></i> Mode of Payment - </span>   
                        <br/>
                        <select  name="Payment[payment_type]" style="width: 90%;" class="form_pm form-control select3_single" data-placeholder="CHOOSE PAYMENT TYPE HERE" id="sModePayment" >
                                <option value="0">- PLEASE SELECT PAYMENT TYPE HERE -</option>
                            <?php foreach($dataPaymentType as $ptRow): ?>
                                <option value="<?php echo $ptRow['id']; ?>" data-interest="<?=$ptRow['interest']=='' || $ptRow['interest']==0 ? '0':$ptRow['interest']?>"><?php echo $ptRow['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="sInterest" name="sInterest" value="0"/>
                    </div>
                </div>

                    <br/>
                    <!-- <div  class="row transactionFormAlign">
                        <div class="col-md-8">
                            <input type="checkbox" class="chkboxRedeemPoints" id="chkboxRedeemPoints" > <b> Redeem <i class="fa fa-product-hunt"></i>oints?</b>
                            <br/>
                            <input type="text" class="form_pm form-control" style="width: 90%;" id="sRedeemPoints" onchange="" name="Payment[points_redeem]" placeholder="<?= $customerInfo['points'] ?> Points remaining." data-point="<?= $customerInfo['points'] ?>"/>
                        </div>
                    </div>
                <br/>

                <div class="s_point_to_price_row">
                <div  class="row transactionFormAlign">
                    <div class="col-md-8">
                        <span class="pmLabel" ><i class="fa fa-bookmark"></i> Point to Price - </span>
                        <br/>
                        <input type="text" style="width: 90%;" class="form_pm form-control" name="sPoint_to_price" id="sPoint_to_price" value="0.00" placeholder="Enter Amount here." readonly/>
                    </div>
                </div>
                <br/>
                </div> -->
                <div  class="row transactionFormAlign">
                    <div class="col-md-8">
                        <span class="pmLabel" ><i class="fa fa-bookmark"></i> Interest% - </span>
                        <br/>
                        <input type="text" style="width: 90%;" class="form_pm form-control" id="sInterestAmount" value="0" readonly/>
                    </div>
                </div>
                <br/>

                <div  class="row transactionFormAlign">
                    <div class="col-md-8">
                        <span class="pmLabel" ><i class="fa fa-bookmark"></i> Amount Pay - </span>
                        <br/>
                        <input type="text" style="width: 90%;" class="form_pm form-control" id="sAmount" value="<?= number_format($customerInfo['balance_amount'],2) ?>" placeholder="Enter Amount here." data-amount="<?= number_format($customerInfo['balance_amount'],2) ?>" readonly/>
                    </div>
                </div>
                <br/>

                <div  class="row transactionFormAlign">
                    <div class="col-md-8">
                        <span class="pmLabel" ><i class="fa fa-bookmark"></i> Interest Amount - </span>
                        <br/>
                        <input type="text" name="interest_charge" style="width: 90%;" class="form_pm form-control" id="sInterestCharge" value="0.00" readonly/>
                    </div>
                </div>
                <br/>

                <div  class="row transactionFormAlign">
                    <div class="col-md-8">
                        <span class="pmLabel" ><i class="fa fa-bookmark"></i> Total Amount - </span>
                        <br/>
                        <input type="text" name="Payment[amount]" style="width: 90%;" class="form_pm form-control" id="sTotalAmount" value="<?= number_format($customerInfo['balance_amount'],2) ?>" placeholder="Enter Amount here." data-amount="<?= number_format($customerInfo['balance_amount'],2) ?>" readonly/>
                    </div>
                </div>
                <br/>

                <div  class="row transactionFormAlign">
                <br/>
                    <div class="col-md-11">
                        <span class="pmLabel" ><i class="fa fa-bookmark"></i> Remarks - </span>
                        <br/>
                        <textarea cols="3" rows="2" name="Payment[remarks]" class="form_pmTxtArea form-control" placeholder="Write Remarks here." id="sRemarks" ></textarea>
                    </div>
                </div>

        </div>
        <hr/>

        <div>
            <input type="hidden" name="Payment[invoice_id]" class="form_pm form-control" value="<?= $customerInfo['id'] ?>" id="sInvoiceId" />
            <input type="hidden" name="Payment[invoice_no]" class="form_pm form-control" value="<?= $customerInfo['invoice_no'] ?>" id="sInvoiceNo" />
            <input type="hidden" name="Payment[customer_id]" class="form_pm form-control" id="sCustomerId" value="<?= $customerInfo['customer_id'] ?>"/>
            <input type="hidden" name="Payment[payment_date]" class="form_pm form-control" value="<?php echo date('Y-m-d'); ?>" id="sPaymentDate" />
            <input type="hidden" name="Payment[payment_time]" class="form_pm form-control" value="<?php echo date('H:i:s'); ?>" id="sPaymentTime" />
            <input type="hidden" name="grandtotal" class="form_pm form-control" value="<?= $customerInfo['grand_total'] ?>" id="sGrandTotal" />
            <input type="hidden" name="gst" class="form_pm form-control" value="<?= $customerInfo['gst'] ?>" id="sGst" />
            <input type="hidden" name="net" class="form_pm form-control" value="<?= $customerInfo['net'] ?>" id="sNet" />
            <input type="hidden" name="balance_amount" class="form_pm form-control" value="<?= $customerInfo['balance_amount'] ?>" id="sBalance_amount" />
        </div>

        <div class="row">

        <div class="col-md-12">
            <div style="text-align: right;">        
            <?= Html::submitButton('<li class=\'fa fa-history\'></li> Submit Payment' , ['class' =>'form-btn btn btn-lg btn-primary', 'id' => 'submitSinglePayment', 'style'=>'margin-right:15px']) ?>
            </div>
        </div>

        </div>
        <br/>

    </div>

    <div class="paymentContainer" id="multipleMethod">

        <div class="paymentContainerHeader">
            <div class="paymentContainerHeaderLabel" style="border-bottom:1px solid #eee">
                
                <div>
                <br/>
                    <span style="font-weight: 600;padding-left:10px"><i class="fa fa-mail-reply-all"></i> MULTIPLE PAYMENT METHOD.</span>
                </div>
            </div>

        </div>
        <br/>

        <div class="row transactionFormAlign" >
    
            <div  class="row transactionFormAlign">
                <div class="col-md-8">
                    <span class="pmLabel"><i class="fa fa-building"></i> Date & Time - </span>   
                    <br/>
                    <input type="text" value="<?= $datetime ?>" style="width: 90%;" class="form-control form_pmInput" name="datetime" id="mDateTime" readonly/>
                </div>
            </div>
            <br/>

            <div class="row transactionFormAlign" >
                <div class="col-md-8">
                    <span class="pmLabel" ><i class="fa fa-building"></i> Mode of Payment - </span>   
                    <br/>
                    <select  name="Payment[mPayment_type]" style="width: 90%;" class="form_pm form-control select3_single" data-placeholder="CHOOSE PAYMENT TYPE HERE" id="mPayment_type">
                            <option value="0">- PLEASE SELECT PAYMENT TYPE HERE -</option>
                        <?php foreach($dataPaymentType as $ptRow): ?>
                            <option value="<?php echo $ptRow['id']; ?>" data-interest="<?=$ptRow['interest']=='' || $ptRow['interest']==0 ? '0':$ptRow['interest']?>"><?php echo $ptRow['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" id="mInterest" name="mInterest" value="0"/>
                </div>
            </div>

            
                <!-- <br/>  
                <div  class="row transactionFormAlign">
                    <div class="col-md-8">
                        <input type="checkbox" class="mChkboxRedeemPoints" id="mChkboxRedeemPoints" > <b> Redeem <i class="fa fa-product-hunt"></i>oints?</b>
                        <br/>
                        <input type="text" style="width: 90%;" class="form_pm form-control" id="mRedeemPoints" name="Payment[mPoints_redeem]" placeholder="<?= $customerInfo['points'] ?> Points remaining." />
                    </div>
                </div> -->
            <br/>

            <div  class="row transactionFormAlign">
                <div class="col-md-8">
                    <span class="pmLabel" ><i class="fa fa-bookmark"></i> Interest% - </span>
                    <br/>
                    <input type="text" style="width: 90%;" class="form_pm form-control" id="mInterestAmount" value="0" readonly/>
                </div>
            </div>
            <br/>

            <div  class="row transactionFormAlign">
                <div class="col-md-8">
                    <span class="pmLabel"><i class="fa fa-building"></i> Amount Pay - </span>   
                    <br/>
                    <input type="text" style="width: 90%;" class="form_pm form-control" id="mAmount" value="0.00" placeholder = "Enter Amount here." data-amount="<?= $customerInfo['balance_amount'] ?>"/>
                </div>
            </div>
            
            <br/>

            <div  class="row transactionFormAlign">
                <div class="col-md-8">
                    <span class="pmLabel" ><i class="fa fa-bookmark"></i> Interest Amount - </span>
                    <br/>
                    <input type="text" name="mInterestAmount" style="width: 90%;" class="form_pm form-control" id="mInterestCharge" value="0.00" readonly/>
                </div>
            </div>
            <br/>

            <div  class="row transactionFormAlign">
                <div class="col-md-8">
                    <span class="pmLabel"><i class="fa fa-building"></i> Total Amount - </span>   
                    <br/>
                    <input type="text" name="Payment[mAmount]" style="width: 90%;" class="form_pm form-control" id="mTotalAmount" value="0.00" placeholder = "Enter Amount here." data-amount="<?= $customerInfo['balance_amount'] ?>" readonly/>
                </div>
            </div>
            
            <br/>

            
            <div  class="row transactionFormAlign">
            <br/>
                <div class="col-md-11">
                    <span class="pmLabel" ><i class="fa fa-building"></i> Remarks - </span>
                    <br/>
                    <textarea cols="3" rows="2" name="Payment[mRemarks]" class="form_pmTxtArea form-control" id="mRemarks" placeholder="Write Remarks here."></textarea>
                </div>
            </div>
            <br/>

            <div  class="row transactionFormAlign">
                <div class="col-md-12">
                    <button type="button" class="form-btn btn btn-default pull-right" onclick="newPayment()"><span class="pmLabel" > - Add Payment <i class="fa fa-shopping-cart"></i></span></button>
                </div>
            </div>

            <div  class="row transactionFormAlign">
            <br/>
                <div class="col-md-12">
                    <table id="selecteditems" class="table table-boardered">
                        <thead>
                            <tr class="qpreviewth">
                                <th class="servicespartsContainerHeader"> Mode Of Payment </th>
                                <!-- <th class="servicespartsContainerHeader"> Points Redeem </th> -->
                                <th class="servicespartsContainerHeader"> Amount Paid </th>
                                <th class="servicespartsContainerHeader"> Remarks </th>
                                <th class="servicespartsContainerHeader"> Action </th>
                            </tr>
                        </thead>
                        <tbody class="added-payment-lists">
                        </tbody>
                    </table>
                </div>
            </div>     
        </div>
        <hr/>

        <div>
            <input type="hidden" id="n" value="0">
            <input type="hidden" name="Payment[mInvoice_id]" id="mInvoice_id" class="form_pm form-control" value="<?= $customerInfo['id'] ?>" />
            <input type="hidden" name="Payment[mInvoice_no]" id="mInvoice_no" class="form_pm form-control" value="<?= $customerInfo['invoice_no'] ?>" />
            <input type="hidden" name="Payment[mCustomer_id]" id="mCustomer_id" class="form_pm form-control" value="<?= $customerInfo['customer_id'] ?>" />
            <input type="hidden" name="Payment[mPayment_date]" id="mPayment_date" class="form_pm form-control" value="<?php echo date('Y-m-d'); ?>" />
            <input type="hidden" name="Payment[mPayment_time]" id="mPayment_time" class="form_pm form-control" value="<?php echo date('H:i:s'); ?>" />
            <input type="hidden" name="mGrandtotal" class="form_pm form-control" value="<?= $customerInfo['grand_total'] ?>" id="mGrandtotal" />
            <input type="hidden" name="mGst" class="form_pm form-control" value="<?= $customerInfo['gst'] ?>" id="mGst" />
            <input type="hidden" name="mNet" class="form_pm form-control" value="<?= $customerInfo['net'] ?>" id="mNet" />
            <input type="hidden" name="balance_amount" class="form_pm form-control" value="<?= $customerInfo['balance_amount'] ?>" id="mBalance_amount" />
        </div>

        <div class="row">

        <div class="col-md-12">
            <div style="text-align: right;">        
            <?= Html::submitButton('<li class=\'fa fa-history\'></li> Submit Payment' , ['class' =>'form-btn btn btn-primary btn-lg', 'id' => 'submitMultiplePayment', 'style'=>'margin-right:15px']) ?>
            </div>
        </div>

        </div>
        <br/>

    </div>
    </form>
 </div>

 <?php if( !empty($paymentInformation) ): ?>
 <div class="col-md-12">
 <br/><br/>
 
 <div class="x_title">
    <h2> <i class="fa fa-book"></i> Payment History. </h2>
    <ul class="nav navbar-right panel_toolbox"></ul>
    <div class="clearfix"></div>
 </div>
 <br/>

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
                        <label> PAYMENT </label>
                    </th>
                    <th class="paymentLabel" >
                        <label> INTEREST </label>
                    </th>
                    <th class="paymentLabel" >
                        <label> PAYMENT DATE </label>
                    </th>
                    <th class="paymentLabel" >
                        <label> AMOUNT PAY </label>
                    </th>
                    <th class="paymentLabel" >
                         <label> REDEEM POINTS </label>
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
                        <lable><?php echo date('M-d-Y', strtotime($paymentRow['payment_date'])) ?></lable>
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

 </div>
 <?php endif; ?> 

</div>

<div class="col-md-6">

 <!-- Invoice Section -->
 <div class="col-md-12">

    <div class="x_panel invoicePaymentViewContainer">

        <div class="x_title">
            <h2> Invoice #<?= $customerInfo['id'] ?></h2>
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
                    <h3><b><i class="fa fa-handshake-o"></i> FULLY PAID! </b></h3>
                </div>
            </div>
        <?php elseif( $customerInfo['paid'] == 2 ): ?>
            <div class="row pull-right">    
                <div class="col-md-12 invoice-col">
                <br/>
                    <h3><b><i class="fa fa-handshake-o"></i> PARTIALLY PAID! </b></h3>
                </div>
            </div>
        <?php else: ?>
            <div class="row pull-right">    
                <div class="col-md-12 invoice-col">
                <br/>
                    <h3><b><i class="fa fa-handshake-o"></i> UNPAID! </b></h3>
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
                            <?php foreach($invoice_detail as $key=>$item) { ?>
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
            <br>
                <p class="lead remarksamountdueHeader"><i class="fa fa-money"></i> Points Redeemed.</p>
                <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                    - <?= $customerInfo['points_redeem'] ?>
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
                                <th style="width:50%;" class="amountdueTh" >Point-to-Price </th>
                                <td class="amountdueTd" >$ <?= number_format($redeem_price,2) ?></td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >GST(7.00%) </th>
                                <td class="amountdueTd" > <?= number_format($customerInfo['gst'],2) ?></td>
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
            <br/>
            <!-- /.row -->

                <a href="?r=invoice/print-invoice&id=<?= $customerInfo['id'] ?>&invoice_no=<?= $customerInfo['invoice_no'] ?>"><button class="form-btn btn btn-success btn-lg pull-right" ><i class="fa fa-print"></i> Print Invoice </button></a>
        </section>

        </div>

    </div>
    <br/><br/>

 </div>

</div>

</div>