<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
    $backUrl = 'quotation/index';
}

use common\models\Currency;
use common\models\Customer;
use common\models\Part;
use common\models\WorkOrder;

/* @var $this yii\web\View */
/* @var $model common\models\Quotation */
/* @var $form yii\widgets\ActiveForm */

/*plugins*/
use kartik\file\FileInput;

if($model->quotation_code==NULL)
{
    $yrNow = date('Y');
    $monthNow = date('m');
    $quotationCode = 'JS' . $yrNow  . $monthNow . sprintf('%003d', $quotationId);
    $quotationCodeValue = $quotationCode;

    $model->quotation_code = $quotationCodeValue;
}
?>


<?php 
if($model->id=='')
    $form = ActiveForm::begin(['id' => 'create_quotation_form']); 
else
    $form = ActiveForm::begin(['id' => 'edit_quotation_form']); 

?>
<div class="row transactionform-container">

<div>
    </div>

 <div class="form-crud-container">

<div class="col-md-12 col-sm-12 col-xs-12">
 
<div class="form-title-container">
    <span class="form-header"><h4><i class="fa fa-pencil-square-o"></i> <?=$model->id=='' ? 'Create': 'Edit'?> Job-Sheet</h4></span>
</div>
<hr>

<a class="form-btn btn btn-default" href="?r=quotation"><i class="fa fa-backward"></i> Back to previous page</a><br><br>

</div>


<div class="col-md-12">
<div id="result_message" class="text-left"></div>
    <div class="col-md-12 col-sm-12 col-xs-12 quotationHeader">       
        <div>
            <span class="quotationHeaderLabel"> <li class="fa fa-info"></li> Customer Information </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-lg-6" style="margin-top:20px">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4"><label class="customer-label"><i class="fa fa-barcode"></i>&nbsp;Job-sheet Code</label></div>
                        <div class="col-lg-7">
                            <?= $form->field($model, 'quotation_code')->textInput(['class' => 'form_input form-control', 'id' => 'quotationCode' ])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4"><label class="customer-label"><i class="fa fa-globe"></i>&nbsp;Branch</label></div>
                        <div class="col-lg-7 required-field-block">
                            <select id="branch_id" name="Quotation[branch_id]" class="form-control select3_single select-branch">
                                <option value="0" data-gst="0">- SELECT BRANCH HERE -</option>
                                <?php foreach( $branch as $index=>$item ):?>
                                        <option value="<?=$index?>" data-gst="<?=$item['gst']==null ? '0':$item['gst']?>" <?=$model->branch_id==$index ? 'selected':''?>><?=$item['name']?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" id="gst_charges" name="gst_charges" value="<?=$model->id!='' ? $branch[$model->branch_id]['gst']: 0?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4"><label class="customer-label"><i class="fa fa-user"></i>&nbsp;Sales Person</label></div>
                        <div class="col-lg-7 required-field-block">
                        <?php 
                            if($model->user_id=='')
                                $model->user_id = Yii::$app->user->identity->id;
                        ?>
                            <?= $form->field($model, 'user_id')->dropDownList(array('0' => '- SELECT SALES PERSON HERE -') + $user, ['class'=>'form-control form_input select3_single','id' => 'branchType' , 'data-placeholder' => '- SELECT SALES PERSON HERE -'])->label(false); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4"><label class="customer-label"><i class="fa fa-dashboard"></i>&nbsp;Mileage</label></div>
                        <div class="col-lg-7">
                            <?= $form->field($model, 'mileage')->textInput(['class' => 'form_input form-control', 'placeholder' => 'ENTER MILEAGE HERE', 'id' => 'mileage' ])->label(false) ?>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="c-text-1" value="">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4"><label class="customer-label"><i class="fa fa-car"></i>&nbsp;Car Plate</label></div>
                        <div class="col-lg-7 required-field-block">
                            <?= $form->field($model, 'customer_id')->dropDownList(array('0' => '- SELECT Car Plate HERE -') + $customer, ['class'=>'form-control form_input select3_single getCustomerInfo','id' => 'getCustomerInfo' , 'data-placeholder' => '- SELECT CUSTOMER HERE -'])->label(false); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6" style="margin-top:20px">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4"><label class="customer-label"><i class="fa fa-calendar"></i>&nbsp;Date Issue</label></div>
                        <div class="col-lg-7">
                        <?php 
                            if($model->id=='')
                                $model->date_issue = date('d-m-Y');
                        ?>
                            <?= $form->field($model, 'date_issue')->textInput(['class' => 'form_input form-control', 'id' => 'expiry_date' ])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4"><label class="customer-label"><i class="fa fa-calendar-plus-o"></i>&nbsp;Date Come-In</label></div>
                        <div class="col-lg-7">
                            <?= $form->field($model, 'come_in')->textInput(['class' => 'form_input form-control', 'id' => ($model->id=='' ? 'datetimepicker_comein':'update_datetimepicker_comein'), 'value'=>date('d-m-Y H:i:s', strtotime($model->come_in))])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4"><label class="customer-label"><i class="fa fa-calendar-minus-o"></i>&nbsp;Date Come-Out</label></div>
                        <div class="col-lg-7">
                            <?= $form->field($model, 'come_out')->textInput(['class' => 'form_input form-control', 'id' => ($model->id=='' ? 'datetimepicker_comeout':'update_datetimepicker_comeout') ])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4"><label class="customer-label"><i class="fa fa-comment"></i>&nbsp;Remark</label></div>
                        <div class="col-lg-7">
                            <textarea name="Quotation[remarks]" style="font-size: 11.5px;" placeholder="Write your remarks here." id="message"  class="form-control"><?=$model->remarks!='' ? $model->remarks:''?></textarea> 
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="col-md-11">
            <!-- <h4><i class="fa fa-info-circle"></i>&nbsp;Customer Information</h4> -->
                <div id="customer-information">
                    
                </div>
                <br/><br/>
            </div>
            <br/>
            <div class="col-md-12 col-sm-12 col-xs-12 quotationHeader">       
                <div>
                    <span class="quotationHeaderLabel"> <li class="fa fa-chain-broken"></li>  Services or Products Information  </span>
                </div>
            </div>
            <!-- <div class="col-md-12" style="margin-top:20px">
                <h4><i class="fa fa-chain-broken"></i> Services or Products Information</h4>
            </div> -->
            <br/><br/><br/>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-lg-6 col-md-12 col-xs-12" style="margin:10px 0px">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4"><label>Product Category</label></div>
                                    <div class="col-lg-7">
                                        <select class="select2_multiple form-control" id="partsCategory" onchange="quoGetPartsList()" data-placeholder="CHOOSE PARTS CATEGORY HERE"  >
                                            <option value="0">- SELECT PARTS-CATEGORY HERE -</option>
                                            <?php foreach($category as $rowCategory): ?>
                                                <option value="<?php echo $rowCategory['id']; ?>"><?php echo $rowCategory['category']; ?></option>
                                            <?php endforeach; ?>    
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-12 col-xs-12 quotationHeader">
                            <div class="col-md-6 col-xs-6 table-th"><i class="fa fa-cogs"></i>&nbsp;Product</div>
                            <div class="col-md-2 col-xs-2 table-th"><i class="fa fa-database"></i>&nbsp;Quantity</div>
                            <div class="col-md-1 col-xs-1 table-th"><i class="fa fa-usd"></i>&nbsp;Unit Price</div>
                            <div class="col-md-2 col-xs-2 table-th"><i class="fa fa-money"></i>&nbsp;Subtotal</div>
                            <div class="col-md-1 col-xs-1 table-th"><i class="fa fa-save"></i>&nbsp;Action</div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12" style="margin-top:20px">
                        <div class="col-md-6 col-xs-6"><select id="services_parts" class="select2_single form-control" onchange="quoSelectParts()"><option value="0">Select Product</option></select></div>
                        <div class="col-md-2 col-xs-2"><input class="form-control input-sm" id="quantity" name="quantity" value="" placeholder="Quantity" onchange="quoUpdatePartsSubTotal()"><span id="available_quantity"></span></div>
                        <div class="col-md-1 col-xs-1"><input class="form-control input-sm" id="unit_price" name="unit_price" value="" placeholder="Unit Price" onchange="quoUpdatePartsSubTotal()"></div>
                        <div class="col-md-2 col-xs-2"><input class="form-control input-sm" id="line_total" name="line_total" value="" placeholder="Subtotal" disabled></div>
                        <div class="col-md-1 col-xs-1"><a href="javascript:void(0);" id="product-add" onclick="addProductRow()"><i class="fa fa-plus ico quotation-plus-icon"></i></a></div>
                        <input type="hidden" name="itemParts[]" value=""/>
                        <input type="hidden" name="inventoryId[]" value=""/>
                        <br/><br/><br/>
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-12 col-xs-12 quotationHeader">
                            <div class="col-md-3 col-xs-3 table-th"><i class="fa fa-money"></i>&nbsp;Service Price</div>
                            <div class="col-md-7 col-xs-7 table-th"><i class="fa fa-commenting-o"></i>&nbsp;Service Description</div>
                            <div class="col-md-2 col-xs-2 table-th"><i class="fa fa-save"></i>&nbsp;Action</div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12" style="margin-top:20px">
                        <div class="col-md-3 col-xs-3">
                            <input class="form-control input-sm" id="service_price" name="service_price" value="" placeholder="Enter Service Price here." onchange="CheckDecimal('service_price')">
                        </div>
                        <div class="col-md-7 col-xs-7">
                            <textarea id="service_description" rows="1" style="font-size:11px;" name="service_description" class=" form-control" placeholder="WRITE SERVICE DESCRIPTION HERE."></textarea>
                        </div>
                        <div class="col-md-2 col-xs-2"><a href="javascript:void(0)" onclick="addServiceRow()"><i class="fa fa-plus ico quotation-plus-icon"></i></a></div>
                        <br/><br/><br/>
                    </div>
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-12 col-xs-12 quotationHeader">
                            <div class="col-md-3 col-xs-3 table-th"><i class="fa fa-minus-circle"></i>&nbsp;Discount Amount</div>
                            <div class="col-md-7 col-xs-7 table-th"><i class="fa fa-commenting"></i>&nbsp;Discount Remarks</div>
                            <div class="col-md-2 col-xs-2 table-th"><i class="fa fa-save"></i>&nbsp;Action</div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12" style="margin-top:20px">
                        <div class="col-md-3 col-xs-3">
                            <input class="form-control input-sm" id="discount_price" name="discount_price" value="" placeholder="Discount Price" onchange="CheckDecimal('discount_price')">
                        </div>
                        <div class="col-md-7 col-xs-7">
                            <textarea id="discount_description" rows="1" style="font-size:11px;" name="discount_description" class=" form-control" placeholder="WRITE REMARKS HERE."></textarea>
                        </div>
                        <div class="col-md-2 col-xs-2"><a href="javascript:void(0)" onclick="addDiscountRow()"><i class="fa fa-plus ico quotation-plus-icon"></i></a></div>
                        <br/><br/><br/>
                    </div>
            </div>
            <div class="col-md-12" style="margin-top:20px">
                <h4><i class="fa fa-shopping-cart"></i> Selected Services or Parts</h4>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="col-md-12 col-xs-12 quotationHeader">
                    <div class="col-md-3 col-xs-3 table-th">Item</div>
                    <div class="col-md-2 col-xs-2 table-th">Quantity</div>
                    <div class="col-md-2 col-xs-2 table-th">Unit Price</div>
                    <div class="col-md-2 col-xs-2 table-th">Line Total</div>
                    <div class="col-md-3 col-xs-3 table-th">Action</div>
                </div>
            </div>
            <div id="added_list" class="col-md-12 col-xs-12" style="margin-top:10px">
                <?php 
                    if($model->id!='') { 
                        foreach($quotation_detail as $key=>$value) { 
                ?>
                            <div class="col-md-12 col-xs-12 row_list">
                                <div class="col-md-3 col-xs-3"><?=is_numeric($value['service_part_id']) ? $value['product_name']:$value['service_part_id']?></div>
                                <div class="col-md-2 col-xs-2"><?=$value['quantity']?></div>
                                <div class="col-md-2 col-xs-2"><?=substr($value['selling_price'],0,1)=='-' ? '('.substr($value['selling_price'],1).')':$value['selling_price']?></div>
                                <div class="col-md-2 col-xs-2"><?=substr($value['subTotal'],0,1)=='-' ? '('.substr($value['subTotal'],1).')':$value['subTotal']?></div>
                                <?php if($value['type']==0){ ?>
                                    <b> <input type="checkbox" name="QuotationDetail[task][]" id="task" class="task" value="1" <?= $value['task']==1 ? 'checked':'' ?>> Pending Service ?&nbsp;&nbsp;|</b>
                                    <span class="remove-button">
                                        <a href="javascript:void(0)" onclick="removeRowList(this)">&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
                                    </span>
                                    <input type="hidden" name="service_part_id[]" class="item" value="<?=$value['service_part_id']?>" data-line-total="<?=$value['subTotal']?>" data-plus-minus="+"/>
                                <?php }else if($value['type']==1){ ?>
                                    <span class="remove-button">
                                        <a href="javascript:void(0)" onclick="removeRowList(this)">&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
                                    </span>
                                    <input type="hidden" name="service_part_id[]" class="item product_<?=$value['service_part_id']?>" value="<?=$value['service_part_id']?>" data-line-total="<?=$value['subTotal']?>" data-plus-minus="+"/>
                                <?php }else{ ?>
                                    <span class="remove-button">
                                        <a href="javascript:void(0)" onclick="removeRowList(this)">&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
                                    </span>
                                    <input type="hidden" name="service_part_id[]" class="item" value="<?=$value['service_part_id']?>" data-line-total="<?=substr($value['subTotal'],1)?>" data-plus-minus="-"/>
                                <?php } ?>
                                <input type="hidden" name="type[]" value="<?=$value['type']?>"/>
                                <input type="hidden" name="quantity[]" value="<?=$value['quantity']?>"/>
                                <input type="hidden" name="price[]" value="<?=$value['type']==2 ? substr($value['selling_price'],1): $value['selling_price']?>"/>
                                <input type="hidden" name="task[]" class="pending_task" value="<?=$value['task']?>"/>
                                <input type="hidden" name="item_id[]" value="<?=$value['id']?>"/>
                                <hr style="border-bottom: 1px solid #eee;"/>
                            </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </div>
        <br/>
        <div class="row" style="margin-top:30px">
            <div class="col-md-offset-8 col-md-2 col-xs-1 text-right" style="padding-top:10px">Sub-Total</div>
            <div class="col-md-2 col-xs-2">
            <?php 
                if($model->grand_total=='')
                    $model->grand_total = '0.00';
                else
                    $model->grand_total = number_format($model->grand_total, 2, '.', ',');

            ?>
                <?= $form->field($model, 'grand_total')->textInput(['class' => 'form-control grandTotal', 'id' => 'grandTotal', 'readonly'=>true])->label(false) ?>
            </div>
            <div class="clearfix">&nbsp;</div>
        </div>
        <div class="row">
            <div class="col-md-offset-8 col-md-2 col-xs-1 text-right" style="padding-top:10px">GST(7%)</div>
            <div class="col-md-2 col-xs-2">
                <?php 
                    if($model->gst=='')
                        $model->gst = '0.00';
                    else
                        $model->gst = number_format($model->gst, 2, '.', ',');
                ?>
                <?= $form->field($model, 'gst')->textInput(['class' => 'form-control grandTotal', 'id' => 'gstResult', 'readonly'=>true])->label(false) ?>
            </div>
            <div class="clearfix">&nbsp;</div>
        </div>
        <div class="row">
            <div class="col-md-offset-8 col-md-2 col-xs-1 text-right" style="padding-top:10px">Nett Total</div>
            <div class="col-md-2 col-xs-2">
                <?php 
                    if($model->net=='')
                        $model->net = '0.00';
                    else
                        $model->net = number_format($model->net, 2, '.', ',');
                ?>
                <?= $form->field($model, 'net')->textInput(['class' => 'form-control grandTotal', 'id' => 'netTotal', 'readonly'=>true])->label(false) ?>
            </div>
            <div class="clearfix">&nbsp;</div>
        </div>
        <br/><br/><br/>
    </div>
</div>
    </div>
</div>
<div class="col-md-12">
<hr>
    <div style="text-align: right;">        
        <button type="submit" id="submitQuotation" class="form-btn btn btn-dark btn-lg" onclick="return confirm('Are you sure, you want to submit?')"><li class="fa fa-save"></li> <?=$model->id=='' ? 'Submit':'Edit'?> Job-Sheet</button>
    </div>
<br>
</div>
<?php ActiveForm::end(); ?>
