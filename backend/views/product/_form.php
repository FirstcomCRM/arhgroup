<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$dataCategory = ArrayHelper::map(Category::find()->where(['status' => 1])->all(), 'id', 'category');
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['status' => 1])->all(), 'id', 'supplier_name');

$productCode = 'PARTS' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5); 

?>

<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data'], 'id' => 'arh-form']); ?>

<div class="row">
    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Product Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-truck"></i> Supplier Name</label>
        <?= $form->field($model, 'supplier_id')->dropDownList(['0' => '- SELECT SUPPLIER HERE -'] + $dataSupplier,['style' => 'width:100%;', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE SUPPLIER HERE', 'id' => 'supplierId' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-street-view"></i> Product Category</label>
        <?= $form->field($model, 'category_id')->dropDownList(['0' => '- SELECT PARTS-CATEGORY HERE -'] + $dataCategory,['style' => 'width:100%;', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE PARTS-CATEGORY HERE', 'id' => 'productCategory' ])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-barcode"></i> Product Code</label>
        <?= $form->field($model, 'product_code')->textInput(['class' => 'form_input form-control', 'readonly' => 'readonly', 'value' => $productCode, 'id' => 'productCode' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-6">
        <label class="form_label"><i class="fa fa-tags"></i> Product Name</label>
        <?= $form->field($model, 'product_name')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Product name here.', 'id' => 'productName' ])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-bars"></i> Unit of Measure</label>
        <?= $form->field($model, 'unit_of_measure')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Unit of Measure here.', 'id' => 'productUom' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-cubes"></i> Quantity</label>
        <?= $form->field($model, 'quantity')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Quantity here.', 'id' => 'productQty' ])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-sort-amount-desc"></i> Re-Order Level</label>
        <?= $form->field($model, 'reorder_level')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Re-Order level here.', 'id' => 'productReorderLvl' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-gg-circle"></i> Cost Price</label>
        <?= $form->field($model, 'cost_price')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Cost price here.', 'id' => 'productCostPrice' ])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-percent"></i> Gst Price</label>
        <?= $form->field($model, 'gst_price')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Gst price here.', 'id' => 'productGstPrice' ])->label(false) ?>
    </div>
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-dollar"></i> Selling Price</label>
        <?= $form->field($model, 'selling_price')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Selling price here.', 'id' => 'productSellingPrice' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-user-secret"></i> Product Image</label>
        <?= $form->field($model, 'product_image')->fileInput(['accept' => 'jpg|jpeg|gif|png', 'id' => 'product_image' ])->label(false) ?>
    </div>
</div>
<hr/>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton('<li class=\'fa fa-save\'></li> Save New Record', ['class' => 'form-btn btn btn-primary', 'id' => 'submitProductForm' ]) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>

<?php ActiveForm::end(); ?>












