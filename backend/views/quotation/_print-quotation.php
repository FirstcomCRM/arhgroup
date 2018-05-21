<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;
use common\models\Invoice;
use common\models\TermsAndConditions;
use common\models\SearchBranch;

$getBranchExceptId = new SearchBranch;

$getGst = Gst::find()->where(['branch_id' => $customerInfo['BranchId'] ])->one();

$getInvoice = Invoice::find()->where(['quotation_code' => $customerInfo['quotation_code'] ])->one();
$getTermsAndConditions = TermsAndConditions::find()->where(['status' => 1])->all();

$this->title = 'Print Job-Sheet';

$n = 0;
$x = 0;

?>
    
<!-- Print Buttons -->   
<div class="row dont-print">
    <div class="col-xs-12">
        <div style="text-align: center">
            <button class="form-btn btn btn-info btn-xs print-buttons" id="print_quotation" onclick="quotationPrint()"><i class="fa fa-print"></i> Print </button>
       
            <button class="form-btn btn btn-danger btn-xs print-buttons" onclick="window.location='?r=quotation'"><i class="fa fa-close"></i> Close </button>
      
        </div>
    </div>
</div>

<br/>
<div class="invoice-box page">
<table cellpadding="0" cellspacing="0">

<tr class="top">
<td colspan="2">
    <table>
        <tr>
            <td class="title"  style="width: 58%">
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
                                    <br><br/>
                                    <b>Other Branches List</b>
                                    <?php 
                                        $getBranchAddress = $getBranchExceptId->getBranchExceptId($customerInfo['BranchId']);
                                        foreach ($getBranchAddress as $gba) {
                                            echo '<br>';
                                            echo $gba['address'];
                                            echo '<br>';
                                        }
                                    ?>
                                    <br/>
                                </div>
                                <div class="col-md-12 addressInfo email">
                                    <b>Helpline</b>: <?= Html::encode($customerInfo['branchNumber']) ?> &nbsp;&nbsp;<br/><b>Fax</b>: <?= Html::encode($customerInfo['fax']) ?> &nbsp;&nbsp;<br>
                                    <b>Email</b>: <?= Html::encode($customerInfo['brEmail']) ?><br/>
                                    <b>Uen No</b>: <?= Html::encode($customerInfo['branch_uen_no']) ?><br/>
                                    <b>Gst No</b>: <?= Html::encode($customerInfo['branch_gst_no']) ?> 
                                </div>
                                <div class="col-md-12 addressInfo">
                                <?php if($customerInfo['type'] == 1): ?>
                                    <span class="company_name_row">
                                        <b>Name : </b> <?= Html::encode($customerInfo['company_name']) ?>
                                    </span>
                                    <span class="address_row">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="company_name_row">
                                        <b>Name : </b> <?= Html::encode($customerInfo['fullname']) ?>&nbsp;&nbsp;&nbsp;
                                    </span>
                                    <span class="address_row">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </span>
                                <?php endif; ?> 
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>            
            <td>
                    <div class="row jobsheetinvoiceLabel" >
                     
                     <div class="col-md-12 jobsheetinvoiceHeaderAlign">JOB SHEET</div>
                     <br/>

                        <table>
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Jobsheet No.</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['quotation_code']) ?></td>
                            </tr>    
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Terms</b></td>
                                <td class="jobsheetinvoiceNo"> :  N/A </td>
                            </tr>    
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Date & Time In</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_in']))) ?></td>
                            </tr>    
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Date & Time Out</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_out']))) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Vehicle No.</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['carplate']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Make</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['make']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Model</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['model']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Company Tel.</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['office_no']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Home Tel.</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['hanphone_no']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Mobile</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['hanphone_no']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Mileage</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['mileage']) ?></td>
                            </tr>     
                            <tr>
                                <td class=" jobsheetinvoiceNo"><b>Balance Points</b></td>
                                <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['points']) ?></td>
                            </tr>    

                            <?php 
                                if ($quotationDetail >=11 ) {    
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
    <table>
        <tr>
            <td class="dont-print"><input type="checkbox" class="showPrices" id="showPrices" /><span class="hidePriceLabel" id="hidePriceLabel"> Hide Prices ?</span></td>
        </tr>
    </table>
        <table class="headers quoOrderHeader">
            <tr>
                <td class="servicespartsContainerHeader" id="receiptorderNumberHeader" > S/No </td>                   
                <td class="servicespartsContainerHeader" id="receiptorderDescriptionHeader" > Description </td>
                <td class="servicespartsContainerHeader" id="receiptorderQtyHeader" > Qty</td>
                <td class="servicespartsContainerHeader quoSubtotalHeader" id="receiptorderSubtotalHeader" > Line Total w/o GST</td>
            </tr>
        </table>
    </tr>

    <tr class="details">
        <table border="1" class="receiptorderTable quoOrderContent" cellspacing ="0" cellpadding ="0" >
            <tbody>
                    <?php foreach( $quotationDetail as $key=>$item ) { ?>
                    <?php $n++; ?>
                        <tr>
                            <td class="servicespartsLists" id="orderNumbers" ><?php echo $n; ?></td>
                            <td class="servicespartsLists" id="orderDescriptions" ><?= $item['type']==1 ? $item['product_name'] : $item['service_part_id']; ?></td>
                            <td class="servicespartsLists" id="orderQtys" ><?php echo $item['quantity']; ?></td>
                            <td class="servicespartsLists quoServiceSubtotal" id="orderSubtotals" ><?=substr($item['subTotal'],0,1)=='-' ? '($ '.substr($item['subTotal'],1).')':'$ '.$item['subTotal']?></td>
                        </tr>
                    <?php unset($quotationDetail[$key]); ?>
                    <?php } ?>
            </tbody>
        </table>
    </tr>

    <?php if( $n < 12 ): ?>
    <tr class="item">
        <table >
            <tbody>
                <tr>
                    <td><img src="assets/bootstrap/images/arh_receipt_carimages.png" class="carSize"></img></td>
                </tr>
            </tbody>
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
                </tr>
            </tbody>
        </table>
    </tr>

    <?php endif; ?>

    </table>

</div>

<?php if( $n >= 12 ): ?>

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
                                    <br><br/>
                                    <?php 
                                        $getBranchAddress = $getBranchExceptId->getBranchExceptId($customerInfo['BranchId']);
                                        foreach ($getBranchAddress as $gba) {
                                            echo '<br>';
                                            echo '<br>';
                                        }
                                    ?>
                                    <br/>
                                </div>
                                <div class="col-md-12 addressInfo email">
                                    <b>Helpline</b>: <?= Html::encode($customerInfo['branchNumber']) ?> &nbsp;&nbsp;<br/>Fax: <?= Html::encode($customerInfo['fax']) ?> &nbsp;&nbsp;<br>
                                    <b>Email</b>: <?= Html::encode($customerInfo['brEmail']) ?> 
                                </div>
                                <div class="col-md-12 addressInfo">
                                <?php if($customerInfo['type'] == 1): ?>
                                    <span class="company_name_row">
                                        <b>Name : </b> <?= Html::encode($customerInfo['company_name']) ?>
                                    </span>
                                    <span class="address_row">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="company_name_row" >
                                        <b>Name : </b> <?= Html::encode($customerInfo['fullname']) ?>&nbsp;&nbsp;&nbsp;
                                    </span>
                                    <span class="address_row">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </span>
                                <?php endif; ?> 
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            
            <td style="width: 50%">
                <div class="row jobsheetinvoiceLabel" >
                 
                    <div class="col-md-12 jobsheetinvoiceHeaderAlign"><b>JOB SHEET</b></div>
                    <table>
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Jobsheet No.</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['quotation_code']) ?></td>
                        </tr>    
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Terms</b></td>
                            <td class="jobsheetinvoiceNo"> :  N/A </td>
                        </tr>  
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Date & Time In</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_in']))) ?></td>
                        </tr>    
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Date & Time Out</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_out']))) ?></td>
                        </tr>     
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Vehicle No.</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['carplate']) ?></td>
                        </tr>     
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Make</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['make']) ?></td>
                        </tr>     
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Model</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['model']) ?></td>
                        </tr>     
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Company Tel.</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['office_no']) ?></td>
                        </tr>     
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Home Tel.</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['hanphone_no']) ?></td>
                        </tr>     
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Mobile</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['hanphone_no']) ?></td>
                        </tr>     
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Mileage</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['mileage']) ?></td>
                        </tr>     
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Balance Points</b></td>
                            <td class="jobsheetinvoiceNo"> : <?= Html::encode($customerInfo['points']) ?></td>
                        </tr>   

                        <?php 
                            
                            if (isset($pageNo)) {   
                        ?>
                        <tr>
                            <td class=" jobsheetinvoiceNo"><b>Page No.</b></td>
                            <td class="jobsheetinvoiceNo"> : 2</td>
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

    <tr><td>&nbsp;</td></tr>
    <tr class="heading">
            <table class="headers quoOrderHeader">
                <tr>
                    <td class="servicespartsContainerHeader" id="receiptorderNumberHeader" > S/No </td>                   
                    <td class="servicespartsContainerHeader" id="receiptorderDescriptionHeader" > Description </td>
                    <td class="servicespartsContainerHeader" id="receiptorderQtyHeader" > Qty</td>
                    <td class="servicespartsContainerHeader quoSubtotalHeader" id="receiptorderSubtotalHeader" > Line Total w/o GST</td>
                </tr>
            </table>
    </tr>

    <tr class="details">
        <table border="1" class="receiptorderTable quoOrderContent" cellspacing ="0" cellpadding ="0" >
            <tbody>
                    <?php foreach( $quotationDetail as $key=>$item ) { ?>
                    <?php $n++; ?>
                        <tr>
                            <td class="servicespartsLists" id="orderNumbers" ><?php echo $n; ?></td>
                            <td class="servicespartsLists" id="orderDescriptions" ><?= $item['type']==1 ? $item['product_name'] : $item['service_part_id']; ?></td>
                            <td class="servicespartsLists" id="orderQtys" ><?php echo $item['quantity']; ?></td>
                            <td class="servicespartsLists quoServiceSubtotal" id="orderSubtotals" ><?=substr($item['subTotal'],0,1)=='-' ? '($ '.substr($item['subTotal'],1).')':'$ '.$item['subTotal']?></td>
                        </tr>
                    <?php unset($quotationDetail[$key]); ?>
                    <?php } ?>
            </tbody>
        </table>
    </tr>

    <tr class="item">
        <table >
            <tbody>
            <tr>
                <td>&nbsp;</td>
            </tr>
                <tr>
                    <td><img src="assets/bootstrap/images/arh_receipt_carimages.png" class="carSize"></img></td>
                </tr>
            </tbody>
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
                </tr>
            </tbody>
        </table>
    </tr>

    </table>

</div>

<?php endif; ?>