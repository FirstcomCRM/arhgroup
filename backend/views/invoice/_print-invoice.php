    <?php

    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model common\models\Customer */

    use common\models\Gst;
    use common\models\TermsAndConditions;
    use common\models\SearchBranch;
    use common\models\PaymentType;

    $searchBranch = new SearchBranch;

    $getTermsAndConditions = TermsAndConditions::find()->where(['status' => 1])->all();
    $payment_types = ArrayHelper::map(PaymentType::find()->where(['status' => 1])->all(), 'id', 'name');

    $getGst = Gst::find()->where(['branch_id' => $invoiceInfo['branch_id'] ])->one();

    $id = Yii::$app->request->get('id');

    $this->title = 'Print Invoice';
    $char = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
    

    ?>

    <!-- Print Buttons -->   
    <div class="row dont-print">
        <div class="col-xs-12">
            <div style="text-align: center">
                <button class="form-btn btn btn-info btn-xs print-buttons" id="print_invoice" onclick="invoicePrint()"><i class="fa fa-print"></i> Print </button>
           
                <button class="form-btn btn btn-danger btn-xs print-buttons" onclick="window.location='?r=invoice'"><i class="fa fa-close"></i> Close </button>
          
            </div>
        </div>
    </div>

    <br/>
    <?php $defaultInvoiceDetail = $invoiceDetail; ?>
    <?php foreach($payment as $k=>$pymt) { 
        $invoiceDetail = $defaultInvoiceDetail;
        $n = 1;
        $x = 0;
    ?>

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
                                        <b> <?= Html::encode($invoiceInfo['branch_name']) ?> </b> 
                                    </div>
                                    <div class="col-md-12 addressInfo">
                                        <?= nl2br(Html::encode($invoiceInfo['branch_address'])) ?>
                                        <br><br/>
                                    <b>Other Branches List</b>
                                        <?php 
                                            $get_other_branch = $searchBranch->getBranchExceptId($invoiceInfo['branch_id']);
                                            foreach ($get_other_branch as $gob) {
                                                echo "<br>";
                                                echo $gob['address'];
                                                echo "<br>";
                                            }
                                        ?>
                                        <br>
                                    </div>
                                    <div class="col-md-12 addressInfo email">
                                        <b>Helpline</b>: <?= Html::encode($invoiceInfo['branch_contact']) ?> &nbsp;&nbsp;<br/>
                                        <b>Fax</b>: <?= Html::encode($invoiceInfo['branch_fax']) ?> &nbsp;&nbsp;<br>
                                        <b>Email</b>: <?= Html::encode($invoiceInfo['branch_email']) ?><br/> 
                                        <b>Uen No</b>: <?= Html::encode($invoiceInfo['uen_no']) ?><br/>
                                        <b>Gst No</b>: <?= Html::encode($invoiceInfo['gst_no']) ?> 
                                    </div>
                                    <div class="col-md-12 addressInfo">
                                        <?php if($invoiceInfo['customer_type'] == 1): ?>
                                            <span class="company_name_row">
                                                <b>Name : </b> <?= Html::encode($invoiceInfo['company_name']) ?>
                                            </span>
                                            <span class="address_row">
                                                <b>Address : </b> <?= Html::encode($invoiceInfo['customer_address']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="company_name_row">
                                                <b>Name : </b> <?= Html::encode($invoiceInfo['fullname']) ?>&nbsp;&nbsp;&nbsp;
                                            </span>
                                            <span class="address_row">
                                                <b>Address : </b> <?= Html::encode($invoiceInfo['customer_address']) ?>
                                            </span>
                                        <?php endif; ?> 
                                    </div>
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
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['invoice_no']) ?><?=count($payment)>1 ? "-1".$char[$k]:""?></td>
                                </tr>    
                                <tr>
                                    <td class=" jobsheetinvoiceTerms"><b>Terms :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= $pymt['payment_type']==0 ? "": $payment_types[$pymt['payment_type']] ?></td>
                                </tr>    
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Date & Time In :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode(date('d M Y H:i:s', strtotime($invoiceInfo['come_in']))) ?></td>
                                </tr>    
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Date & Time Out :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode(date('d M Y H:i:s', strtotime($invoiceInfo['come_out']))) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Vehicle No. :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['carplate']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Make :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['make']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Model :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['model']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Company Tel. :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['office_no']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Home Tel. :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['hanphone_no']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Mobile :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['hanphone_no']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Mileage :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['mileage']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Balance Points :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['points']) ?></td>
                                </tr>   

                                <?php 
                                    $total_items = count($invoiceDetail);
                                    if ($total_items >=11  ) {    
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

        <tr><td>&nbsp;</td></tr>    
        <tr class="heading">
            <table class="headers">
                <tr>
                    <td class="servicespartsContainerHeader" id="invoiceorderNumberHeader" > S/No </td>   
                    <td class="servicespartsContainerHeader" id="invoiceorderDescriptionHeader" > Description </td>
                    <td class="servicespartsContainerHeader" id="invoiceorderUnitPriceHeader" > Unit Price</td>
                    <td class="servicespartsContainerHeader" id="invoiceorderQtyHeader" > Qty</td>
                    <td class="servicespartsContainerHeader" id="invoiceorderSubTotalHeader" > Line Total w/o GST</td>
                </tr>
            </table>
        </tr>

        <tr class="details">
            <table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
                <tbody>
                    <?php foreach( $invoiceDetail as $key=>$item ) { ?>
                    <?php 
                        if($item['type']==1)
                            $product_name = $item['product_name'];
                        else
                            $product_name = $item['service_part_id'];

                        if(substr($item['selling_price'],0,1)=='-'){
                            $selling_price = substr($item['selling_price'],1);
                            $selling_price = '($ '.number_format($selling_price, '2', '.', ',').')';

                            $line_total = substr($item['subTotal'],1);
                            $line_total = '($ '.number_format($line_total, 2, '.', ',').')';

                        }
                        else{
                            $selling_price = $item['selling_price'];
                            $selling_price = '$ '.number_format($selling_price, 2, '.', ',');

                            $line_total = $item['subTotal'];
                            $line_total = '$ '.number_format($line_total, 2, '.', ',');
                        }
                    ?>
                        <tr>
                            <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                            <td class="servicespartsLists" id="invoiceorderDescription" ><?= $product_name ?></td>
                            <td class="servicespartsLists price_row" id="invoiceorderUnitPrice" ><?=$selling_price?></td>
                            <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $item['quantity']; ?></td>
                            <td class="servicespartsLists price_row" id="invoiceorderSubTotal" ><?=$line_total?></td>

                        </tr>
                    <?php unset($invoiceDetail[$key]); ?>
                    <?php if($n == 11){ break; } ?>
                    <?php $n++; ?>
                    <?php } ?>

                    <?php if( $n < 11 ): ?>
                        <tr class="total_div">
                            <td colspan="4" align="right">Sub-total</td>
                            <td class="total_row">$ <?=number_format($invoiceInfo['grand_total'], '2', '.', ',')?></td>
                        </tr>
                        <tr class="total_div">
                            <td colspan="4" align="right">Redeem Points discount</td>
                            <td class="total_row">$ <?=$redeem_price=='' ? '0.00': $redeem_price?></td>
                        </tr>
                        <tr class="total_div">
                            <td colspan="4" align="right">GST(<?=$getGst==null ? '0': $getGst['gst']?>.00%)</td>
                            <td class="total_row">$ <?=number_format($invoiceInfo['gst'], '2', '.', ',')?></td>
                        </tr>
                        <tr class="total_div">
                            <td colspan="4" align="right">Nett Total</td>
                            <td class="total_row">$ <?=number_format($invoiceInfo['net'], '2', '.', ',')?></td>
                        </tr>
                        <tr class="total_div">
                            <td colspan="4" align="right">Paid <?=$pymt['payment_type']==0 ? "":"(".$payment_types[$pymt['payment_type']].")" ?></td>
                            <td class="total_row">$ <?=$pymt['payment_type']==0 ? "0.00":$pymt['net'] ?></td>
                        </tr>
                        <tr class="total_div">
                            <td colspan="4" align="right">Balance Due</td>
                            <td class="total_row">$ <?=number_format((substr($pymt['net_with_interest'],0,1)=='-' ? '0.00':$pymt['net_with_interest']), '2', '.', ',')?></td>
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>

        <?php if( $n < 11 ): ?>
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

        <?php endif; ?>

        </div>

    <?php if( $n >= 11 ): ?>
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
                                        <b> <?= Html::encode($invoiceInfo['branch_name']) ?> </b> 
                                    </div>
                                    <div class="col-md-12 addressInfo">
                                        <?= nl2br(Html::encode($invoiceInfo['branch_address'])) ?>
                                        <br><br/>
                                        <b>Other Branches List</b>
                                        <?php 
                                            $get_other_branch = $searchBranch->getBranchExceptId($invoiceInfo['branch_id']);
                                            foreach ($get_other_branch as $gob) {
                                                echo "<br>";
                                                echo $gob['address'];
                                                echo "<br>";
                                            }
                                        ?>
                                        <br>
                                    </div>
                                    <div class="col-md-12 addressInfo email">
                                        <b>Helpline</b>: <?= Html::encode($invoiceInfo['branch_contact']) ?> &nbsp;&nbsp;<br/>
                                        <b>Fax</b>: <?= Html::encode($invoiceInfo['branch_fax']) ?> &nbsp;&nbsp;<br>
                                        <b>Email</b>: <?= Html::encode($invoiceInfo['branch_email']) ?> 
                                    </div>
                                    <div class="col-md-12 addressInfo">
                                        <?php if($invoiceInfo['customer_type'] == 1): ?>
                                            <span class="company_name_row">
                                                <b>Name : </b> <?= Html::encode($invoiceInfo['company_name']) ?>
                                            </span>
                                            <span class="address_row">
                                                <b>Address : </b> <?= Html::encode($invoiceInfo['customer_address']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="company_name_row">
                                                <b>Name : </b> <?= Html::encode($invoiceInfo['fullname']) ?>&nbsp;&nbsp;&nbsp;
                                            </span>
                                            <span class="address_row">
                                                <b>Address : </b> <?= Html::encode($invoiceInfo['customer_address']) ?>
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
                         
                         <div class="col-md-12 jobsheetinvoiceHeaderAlign1"><b>INVOICE / CASH BILL</b></div>
                         <br/>

                            <table>
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Invoice No. :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['invoice_no']) ?><?=count($payment)>1 ? "-1".$char[$k]:""?></td>
                                </tr>    
                                <tr>
                                    <td class=" jobsheetinvoiceTerms"><b>Terms :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= $pymt['payment_type']==0 ? "": $payment_types[$pymt['payment_type']] ?></td>
                                </tr>    
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Date & Time In :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode(date('d M Y H:i:s', strtotime($invoiceInfo['come_in']))) ?></td>
                                </tr>    
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Date & Time Out :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode(date('d M Y H:i:s', strtotime($invoiceInfo['come_out']))) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Vehicle No. :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['carplate']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Make :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['make']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Model :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['model']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Company Tel. :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['office_no']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Home Tel. :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['hanphone_no']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Mobile :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['hanphone_no']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Mileage :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['mileage']) ?></td>
                                </tr>     
                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Balance Points :</b></td>
                                    <td class="jobsheetinvoiceNo"><?= Html::encode($invoiceInfo['points']) ?></td>
                                </tr>   

                                <tr>
                                    <td class=" jobsheetinvoiceNo"><b>Page No.</b></td>
                                    <td class="jobsheetinvoiceNo"> : 2</td>
                                </tr>  
                            </table>
       
                        </div>
                </td>
            </tr>
        </table>
    </td>
    </tr>

    <tr><td>&nbsp;</td></tr>
    <tr class="heading">
        <table class="headers">
            <tr>
                <td class="servicespartsContainerHeader" id="invoiceorderNumberHeader" > S/No </td>   
                <td class="servicespartsContainerHeader" id="invoiceorderDescriptionHeader" > Description </td>
                <td class="servicespartsContainerHeader" id="invoiceorderUnitPriceHeader" > Unit Price</td>
                <td class="servicespartsContainerHeader" id="invoiceorderQtyHeader" > Qty</td>
                <td class="servicespartsContainerHeader" id="invoiceorderSubTotalHeader" > Line Total w/o GST</td>
            </tr>
        </table>
    </tr>

    <tr class="details">
    <table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
        <tbody>
            <?php foreach( $invoiceDetail as $key=>$item ) { ?>
            <?php 
                if($item['type']==1)
                    $product_name = $item['product_name'];
                else
                    $product_name = $item['service_part_id'];

                if(substr($item['selling_price'],0,1)=='-'){
                    $selling_price = substr($item['selling_price'],1);
                    $selling_price = '($ '.number_format($selling_price, '2', '.', ',').')';

                    $line_total = substr($item['subTotal'],1);
                    $line_total = '($ '.number_format($line_total, 2, '.', ',').')';

                }
                else{
                    $selling_price = $item['selling_price'];
                    $selling_price = '$ '.number_format($selling_price, 2, '.', ',');

                    $line_total = $item['subTotal'];
                    $line_total = '$ '.number_format($line_total, 2, '.', ',');
                }
            ?>
                <tr>
                    <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                    <td class="servicespartsLists" id="invoiceorderDescription" ><?= $product_name ?></td>
                    <td class="servicespartsLists" id="invoiceorderUnitPrice" ><?=$selling_price ?></td>
                    <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $item['quantity']; ?></td>
                    <td class="servicespartsLists" id="invoiceorderSubTotal" ><?=$line_total?></td>
                </tr>
            <?php unset($invoiceDetail[$key]); ?>
            <?php if($n == 22){ break; } ?>
            <?php $n++; ?>
            <?php } ?>
                    <tr class="total_div">
                        <td colspan="4" align="right">Sub-total</td>
                        <td class="total_row">$ <?=number_format($invoiceInfo['grand_total'], '2', '.', ',')?></td>
                    </tr>
                    <tr class="total_div">
                        <td colspan="4" align="right">Redeem Points discount</td>
                        <td class="total_row">$ <?=$redeem_price=='' ? '0.00': $redeem_price?></td>
                    </tr>
                    <tr class="total_div">
                        <td colspan="4" align="right">GST(<?=$getGst==null ? '0': $getGst['gst']?>.00%)</td>
                        <td class="total_row">$ <?=number_format($invoiceInfo['gst'], '2', '.', ',')?></td>
                    </tr>
                    <tr class="total_div">
                        <td colspan="4" align="right">Nett Total</td>
                        <td class="total_row">$ <?=number_format($invoiceInfo['net'], '2', '.', ',')?></td>
                    </tr>
                    <tr class="total_div">
                        <td colspan="4" align="right">Paid <?=$pymt['payment_type']==0 ? "":"(".$payment_types[$pymt['payment_type']].")" ?></td>
                        <td class="total_row">$ <?=$pymt['payment_type']==0 ? "0.00":$pymt['net'] ?></td>
                    </tr>
                    <tr class="total_div">
                        <td colspan="4" align="right">Balance Due</td>
                        <td class="total_row">$ <?=number_format((substr($pymt['net_with_interest'],0,1)=='-' ? '0.00':$pymt['net_with_interest']), '2', '.', ',')?></td>
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
                
                </td>
            </tr>
        </tbody>
    </table>

    </tr>

    </table>

    </div>
    <?php endif; ?>
    <?php } ?>