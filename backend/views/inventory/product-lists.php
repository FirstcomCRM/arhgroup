<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>  

<div class="row product-<?= $n ?>">
<hr/>
    <div class="col-md-3">
        <label class="form_label"><b> <i class="fa fa-cog"></i> Product Name </b></label>
        <input type="text" class="form_input form-control" id="product-<?= $n ?>-name" value="<?= strtoupper($productName) ?>" readonly />
        <input type="hidden" name="product_id[]" class="form_input form-control" id="product-<?= $n ?>-id" value="<?= $productId ?>" />
    </div>  

    <div class="col-md-3">
        <label class="form_label"><b> <i class="fa fa-cube"></i> Old Quantity </b></label>
        <input type="text" name="old_qty[]" class="form_input form-control" id="product-<?= $n ?>-oldquantity" value="<?= $oldQty ?>" readonly />
    </div>

    <div class="col-md-3">
        <label class="form_label"><b> <i class="fa fa-database"></i> New Quantity </b></label>
        <input type="text" name="new_qty[]" class="form_input form-control" id="product-<?= $n ?>-newquantity" value="<?= $newQty ?>" readonly />
    </div>
    
    <div class="col-md-3">
        <div style="margin-top: 25px; margin-left: -25px;">
            <a href="javascript:removeProductInList(<?= $n ?>)" class="form-btn btn btn-link"><i class="fa fa-trash"></i> Remove Product</a>
        </div>
    </div>

</div>