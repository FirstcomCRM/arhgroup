<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;
use common\models\TermsAndConditions;
use common\models\SearchBranch;

$searchBranch = new SearchBranch;
$getTermsAndConditions = TermsAndConditions::find()->where(['status' => 1])->all();
$id = Yii::$app->request->get('id');

$this->title = 'Print Invoice';

$n = 0;
$x = 0;

?>


<!-- Print Buttons -->   
<div class="row dont-print">
    <div class="col-xs-12">
        <div style="text-align: center">
            <button class="form-btn btn btn-info btn-xs print-buttons" id="print_invoice" onclick="multipleInvoicePrint()"><i class="fa fa-print"></i> Print </button>
       
            <button class="form-btn btn btn-danger btn-xs print-buttons close_invoice_print" id="close_invoice_print"><i class="fa fa-close"></i> Close </button>
      
        </div>
    </div>
</div>
<br/>
<?php foreach( $getInvoice as $customerInfo): ?>


<div class="invoice-box page">
<table cellpadding="0" cellspacing="0">

<tr class="top">
<td colspan="2">
    <table>
        <tr>
            <td class="title" style="width: 58%">
                <div style="text-align: left">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="images/dashboard/logo.png" class="jiReceiptLogo">
                        </div>
                        <div style="width: 60%;"  class="col-md-8">
                            <div class="row branchcustomerContainer" >
                                <div class="col-md-12 branchName">
                                    <b> <?= Html::encode($customerInfo['name']) ?> </b> 
                                </div>
                                <div class="col-md-12 addressInfo">
                                    <?= nl2br(Html::encode($customerInfo['address'])) ?>
                                     <br>
                                    <?php 
                                        $get_other_branch = $searchBranch->getBranchExceptId($customerInfo['BranchId']);
                                        foreach ($get_other_branch as $gob) {
                                            echo "<br>";
                                            echo $gob['address'];
                                            echo "<br>";
                                        }
                                    ?>
                                    <br>
                                </div>
                                <div class="col-md-12 addressInfo email">
                                    Helpline: <?= Html::encode($customerInfo['branchNumber']) ?> &nbsp;&nbsp;Fax: <?= Html::encode($customerInfo['fax']) ?> &nbsp;&nbsp;<br>
                                    Email: <?= Html::encode($customerInfo['brEmail']) ?> 
                                </div>
                            </div>
                            <div class="row customerInfoContainer" >
                                <?php if($customerInfo['type'] == 1): ?>
                                    <div class="col-md-12 customerName">
                                        <b>Name : </b> <?= Html::encode($customerInfo['company_name']) ?>
                                    </div>
                                    <div class="col-md-12 customerAddressInfo">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12 customerName">
                                        <b>Name : </b> <?= Html::encode($customerInfo['fullname']) ?>
                                    </div>
                                    <div class="col-md-12 customerAddressInfo">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </div>
                                <?php endif; ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            
            <td style="">
                    <div class="row jobsheetinvoiceLabel" >
                     
                     <div class="col-md-12 jobsheetinvoiceHeaderAlign1"><b>INVOICE / CASH BILL</b></div>
                     <br/>

                        <table>
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Invoice No. :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['invoice_no']) ?></td>
                            </tr>    
                            <tr>
                                <td class=" jobsheetinvoiceTerms"><b>Terms :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['paymenttypeName']) ?></td>
                            </tr>    
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Date & Time In :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_in']))) ?></td>
                            </tr>    
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Date & Time Out :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_out']))) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Vehicle No. :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['carplate']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Make :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['make']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Model :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['model']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Company Tel. :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['office_no']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Home Tel. :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['hanphone_no']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Mobile :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['hanphone_no']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Mileage :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['mileage']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Balance Points :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['points']) ?></td>
                            </tr>   

                            <?php 
                                $countParts = count($parts);
                                $countServices = count($services);
                                if ($countParts + $countServices >=8 ) {    
                                    $pageNo = 2;
                            ?>
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Page No.</b></td>
                                <td class="jobsheetinvoiceNo"> : 1</td>
                            </tr>     

                            <?php                         
                                } /* page no. */
                            ?>  
                        </table>
   
   
                    </div>
            </td>
        </tr>
    </table>
</td>
</tr>

    <tr class="heading">
        <table class="headers">
            <tr>
                <td class="servicespartsContainerHeader" id="invoiceorderNumberHeader" > S/No </td>   
                <td class="servicespartsContainerHeader" id="invoiceorderDescriptionHeader" > Description </td>
                <td class="servicespartsContainerHeader" id="invoiceorderUnitPriceHeader" > Unit Price</td>
                <td class="servicespartsContainerHeader" id="invoiceorderQtyHeader" > Qty</td>
                <td class="servicespartsContainerHeader" id="invoiceorderDiscountHeader" > Member Discount</td>
                <td class="servicespartsContainerHeader" id="invoiceorderAddDiscountHeader" > Additional Discount</td>
                <td class="servicespartsContainerHeader" id="invoiceorderSubTotalHeader" > Line Total w/o GST</td>
            </tr>
        </table>
    </tr>

    <tr class="details">
        <table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
            <tbody>
                <?php foreach($parts as $pkey => $pRow): ?>
                    <?php $n++; ?>
                    <tr>
                        <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                        <td class="servicespartsLists" id="invoiceorderDescription" ><?php echo $pRow['product_name']; ?></td>
                        <td class="servicespartsLists" id="invoiceorderUnitPrice" >$ <?php echo number_format($pRow['selling_price'],2); ?></td>
                        <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $pRow['quantity']; ?></td>
                        <td class="servicespartsLists" id="invoiceorderDiscount" >-</td>
                        <td class="servicespartsLists" id="invoiceorderAddDiscount" >-</td>
                        <td class="servicespartsLists" id="invoiceorderSubTotal" >$ <?php echo number_format($pRow['subTotal'],2); ?></td>
                    </tr>
                    <?php unset($parts[$pkey]); ?>
                    <?php if($n == 11){ break; } ?>
                <?php endforeach; ?>
                <?php foreach($services as $key => $sRow): ?>
                    <?php $n++; ?>
                    <tr>
                        <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                        <td class="servicespartsLists" id="invoiceorderDescription" ><?php echo $sRow['service_part_id']; ?></td>
                        <td class="servicespartsLists" id="invoiceorderUnitPrice" >$ <?php echo number_format($sRow['selling_price'],2); ?></td>
                        <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $sRow['quantity']; ?></td>
                        <td class="servicespartsLists" id="invoiceorderDiscount" >-</td>
                        <td class="servicespartsLists" id="invoiceorderAddDiscount" >-</td>
                        <td class="servicespartsLists" id="invoiceorderSubTotal" >$ <?php echo number_format($sRow['subTotal'],2); ?></td>
                    </tr>
                    <?php unset($services[$key]); ?>
                    <?php if($n == 11){ break; } ?>
                <?php endforeach; ?>  
            </tbody>
        </table>
        <?php if( $n < 8 ): ?>
        <table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
            <?php 
                $discount_amount = 0;
                $redeemedpoints_discount = 0;
                if (isset($customerInfo['points_redeem'])) {
                     $redeemedpoints_discount = $customerInfo['points_redeem'] / 20;
                }
            ?> 

            <?php  if ($customerInfo['discount_amount'] != 0) { ?>
            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" colspan="2" ><b>Remarks: <?php echo $customerInfo['discount_remarks']; ?></b></td>
            </tr>
            <?php } ?>

            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Sub-total</b></td>
                    <?php 
                        $subtotal_without_discount = $customerInfo['grand_total'] ;
                    ?>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($subtotal_without_discount+$redeemedpoints_discount,2)  ; ?></b></td>
            </tr>

            <?php if ($customerInfo['discount_amount'] != 0) { ?>
            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Discount</b></td>
              <?php 
                    $discount_amount = $customerInfo['discount_amount'];
                ?>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b>($ <?php echo number_format($discount_amount,2)  ; ?>)</b></td>
            </tr>
            <?php } ?>
            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Redeem Points discount</b></td>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b>($ <?php echo $redeemedpoints_discount; ?>)</b></td>
            </tr>

            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Sub-Total with Discount</b></td>
                <?php 
                    $subtotal_with_deductions =  $subtotal_without_discount - $discount_amount  ;
                ?>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($subtotal_with_deductions,2) ?></b></td>
            </tr>

            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>GST(7.00%)</b></td>
               <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo number_format($customerInfo['gst'],2); ?>
                </b></td>
 
            </tr>
            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Nett Total</b></td>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($customerInfo['net'],2); ?></b></td>

            </tr>
        </table>
    </tr>

    <tr class="item">
        <small style="font-size: 12px;"><b>Terms and Conditions</b></small>
        <br/>

        <ol class="ol-terms">   
        <?php foreach($getTermsAndConditions as $tcRow): ?>
            <?php $x++; ?>
            <li class="termsandconditionsLists" ><?php echo $tcRow['descriptions']; ?></li>
        <?php endforeach; ?>  
        </ol>
    </tr>

    <tr><br/><br/></tr>

    <tr class="item">
      
        <table >
            <tbody>
                <tr>
                    <td class="attendedSideContainer" >
                    <hr class="hrLine" />
                    <h5 class="receiptbottomInfo" >Attended by</h5>
                    </td>

                    <td class="dateSideContainer" >
                    <hr class="hrLine" />
                    <h5 class="receiptbottomInfo" >Date</h5>
                    </td>

                    <td class="customerSideContainer">
                    <hr class="hrLine" />
                    <h5 class="receiptbottomInfo" >Name, NRIC & Signature & Company Shop</h5>
                    </td>

                    
                    </td>
                </tr>
            </tbody>
        </table>
   
    </tr>

</table>
<?php endif; ?>

</div>

<?php if( $n >= 8 ): ?>
<div class="invoice-box page">

<table cellpadding="0" cellspacing="0">

<tr class="top">
<td colspan="2">
    <table>
        <tr>
            <td class="title" style="width: 53%">
                <div style="text-align: left">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="images/dashboard/logo.png" class="jiReceiptLogo">
                        </div>
                        <div style="width: 60%;"  class="col-md-8">
                            <div class="row branchcustomerContainer" >
                                <div class="col-md-12 branchName">
                                    <b> <?= Html::encode($customerInfo['name']) ?> </b> 
                                </div>
                                <div class="col-md-12 addressInfo">
                                    <?= nl2br(Html::encode($customerInfo['address'])) ?>
                                    <br>
                                    <?php 
                                        $get_other_branch = $searchBranch->getBranchExceptId($customerInfo['BranchId']);
                                        foreach ($get_other_branch as $gob) {
                                            echo "<br>";
                                            echo $gob['address'];
                                            echo "<br>";
                                        }
                                    ?>
                                    <br>
                                </div>
                                <div class="col-md-12 addressInfo email">
                                    Helpline: <?= Html::encode($customerInfo['branchNumber']) ?> &nbsp;&nbsp;Fax: <?= Html::encode($customerInfo['fax']) ?> &nbsp;&nbsp;<br>
                                    Email: <?= Html::encode($customerInfo['brEmail']) ?> 
                                </div>
                            </div>
                            <div class="row customerInfoContainer" >
                                <?php if($customerInfo['type'] == 1): ?>
                                    <div class="col-md-12 customerName">
                                        <b>Name : </b> <?= Html::encode($customerInfo['company_name']) ?>
                                    </div>
                                    <div class="col-md-12 customerAddressInfo">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12 customerName">
                                        <b>Name : </b> <?= Html::encode($customerInfo['fullname']) ?>
                                    </div>
                                    <div class="col-md-12 customerAddressInfo">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </div>
                                <?php endif; ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            
            <td style="width: 47%">
                    <div class="row jobsheetinvoiceLabel" >
                     
                     <div class="col-md-12 jobsheetinvoiceHeaderAlign1"><b>INVOICE / CASH BILL</b></div>
                     <br/>
                        <table>
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Invoice No. :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['invoice_no']) ?></td>
                            </tr>    
                            <tr>
                                <td class=" jobsheetinvoiceTerms"><b>Terms :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['paymenttypeName']) ?></td>
                            </tr>    
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Date & Time In :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_in']))) ?></td>
                            </tr>    
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Date & Time Out :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_out']))) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Vehicle No. :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['carplate']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Make :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['make']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Model :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['model']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Company Tel. :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['office_no']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Home Tel. :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['hanphone_no']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Mobile :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['hanphone_no']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Mileage :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['mileage']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Balance Points :</b></td>
                                <td class="jobsheetinvoiceNo"><?= Html::encode($customerInfo['points']) ?></td>
                            </tr>   

                            <?php 
                                $countParts = count($parts);
                                $countServices = count($services);
                                if ($countParts + $countServices >=8 ) {    
                                    $pageNo = 2;
                            ?>
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Page No.</b></td>
                                <td class="jobsheetinvoiceNo"> : 1</td>
                            </tr>     

                            <?php                         
                                } /* page no. */
                            ?>  
                        </table>
   
   
                    </div>
            </td>
        </tr>
    </table>
</td>
</tr>

<tr class="heading">
    <table class="headers">
        <tr>
            <td class="servicespartsContainerHeader" id="invoiceorderNumberHeader" > S/No </td>   
            <td class="servicespartsContainerHeader" id="invoiceorderDescriptionHeader" > Description </td>
            <td class="servicespartsContainerHeader" id="invoiceorderUnitPriceHeader" > Unit Price</td>
            <td class="servicespartsContainerHeader" id="invoiceorderQtyHeader" > Qty</td>
            <td class="servicespartsContainerHeader" id="invoiceorderDiscountHeader" > Member Discount</td>
            <td class="servicespartsContainerHeader" id="invoiceorderAddDiscountHeader" > Additional Discount</td>
            <td class="servicespartsContainerHeader" id="invoiceorderSubTotalHeader" > Line Total w/o GST</td>
        </tr>
    </table>
</tr>

<tr class="details">
<table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
    <tbody>
        <?php foreach($parts as $pRow): ?>
            <?php $n++; ?>
            <tr>
                <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                <td class="servicespartsLists" id="invoiceorderDescription" ><?php echo $pRow['product_name']; ?></td>
                <td class="servicespartsLists" id="invoiceorderUnitPrice" >$ <?php echo number_format($pRow['selling_price'],2); ?></td>
                <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $pRow['quantity']; ?></td>
                <td class="servicespartsLists" id="invoiceorderDiscount" >-</td>
                <td class="servicespartsLists" id="invoiceorderAddDiscount" >-</td>
                <td class="servicespartsLists" id="invoiceorderSubTotal" >$ <?php echo number_format($pRow['subTotal'],2); ?></td>
            </tr>
        <?php endforeach; ?>
        <?php foreach($services as $key => $sRow): ?>
            <?php $n++; ?>
            <tr>
                <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                <td class="servicespartsLists" id="invoiceorderDescription" ><?php echo $sRow['service_part_id']; ?></td>
                <td class="servicespartsLists" id="invoiceorderUnitPrice" >$ <?php echo number_format($sRow['selling_price'],2); ?></td>
                <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $sRow['quantity']; ?></td>
                <td class="servicespartsLists" id="invoiceorderDiscount" >-</td>
                <td class="servicespartsLists" id="invoiceorderAddDiscount" >-</td>
                <td class="servicespartsLists" id="invoiceorderSubTotal" >$ <?php echo number_format($sRow['subTotal'],2); ?></td>
            </tr>
        <?php endforeach; ?>  
    </tbody>
</table>

<table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
<!--     <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Sub-Total</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($customerInfo['grand_total'],2) ?></b></td>
    </tr> -->
    
    <?php  if ($customerInfo['discount_amount'] != 0) { ?>
    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" colspan="2" ><b>Remarks: <?php echo $customerInfo['discount_remarks']; ?></b></td>
    </tr>

    <?php } ?>

    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Sub-total</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo number_format($subtotal_without_discount,2); ?></b></td>
    </tr>

    <?php if ($customerInfo['discount_amount'] != 0) { ?>
    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Discount</b></td>
        <?php
            $discount_amount = $customerInfo['discount_amount'];
        ?>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo number_format($discount_amount,2); ?></b></td>
    </tr>
    <?php } ?>

    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Redeem Points discount</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo $redeemedpoints_discount; ?></b></td>
    </tr>
    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Sub-Total</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($customerInfo['grand_total'],2) ?></b></td>

    </tr>
    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>GST(7.00%)</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo number_format($customerInfo['gst'],2); ?>
        </b></td>
    </tr>
    <tr>s
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Nett Total</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($customerInfo['net'],2); ?></b></td>
    </tr>
</table>
</tr>

<tr class="item">
    <small style="font-size: 12px;"><b>Terms and Conditions</b></small>
    <br/>
        <ol class="ol-terms">
        <?php foreach($getTermsAndConditions as $tcRow): ?>
            <?php $x++; ?>
            <li class="termsandconditionsLists" ><?php echo $tcRow['descriptions']; ?></li>
        <?php endforeach; ?>  
        </ol>
</tr>

<tr><br/><br/></tr>

<tr class="item">

<table >
    <tbody>
        <tr>
            <td class="attendedSideContainer" >
            <hr class="hrLine" />
            <h5 class="receiptbottomInfo" >Attended by</h5>
            </td>

            <td class="dateSideContainer" >
            <hr class="hrLine" />
            <h5 class="receiptbottomInfo" >Date</h5>
            </td>

            <td class="customerSideContainer">
            <hr class="hrLine" />
            <h5 class="receiptbottomInfo" >Name, NRIC & Signature & Company Shop</h5>
            </td>
            
            </td>
        </tr>
    </tbody>
</table>

</tr>

</table>

</div>
<?php endif; ?>

<?php endforeach; ?>
