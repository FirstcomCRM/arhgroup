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
        <?= $form->field($model, 'supplier_id')->dropDownList(['0' => '- PLEASE SELECT SUPPLIER HERE -'] + $dataSupplier,['style' => 'width:100%;', 'class' => 'form_input select2_single', 'value' => $model->supplier_id, 'data-placeholder' => 'CHOOSE SUPPLIER HERE'])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-street-view"></i> Product Category</label>
        <?= $form->field($model, 'category_id')->dropDownList(['0' => '- PLEASE SELECT PARTS-CATEGORY HERE -'] + $dataCategory,['style' => 'width:100%;', 'class' => 'form_input select2_single', 'value' => $model->category_id, 'data-placeholder' => 'CHOOSE PARTS-CATEGORY HERE'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-barcode"></i> Product Code</label>
        <?= $form->field($model, 'product_code')->textInput(['class' => 'form_input form-control', 'readonly' => 'readonly' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-6">
        <label class="form_label"><i class="fa fa-tags"></i> Product Name</label>
        <?= $form->field($model, 'product_name')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Product name here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-bars"></i> Unit of Measure</label>
        <?= $form->field($model, 'unit_of_measure')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Unit of Measure here.'])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-cubes"></i> Quantity</label>
        <?= $form->field($model, 'quantity')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Quantity here.'])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-sort-amount-desc"></i> Re-Order Level</label>
        <?= $form->field($model, 'reorder_level')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Re-Order level here.'])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-gg-circle"></i> Cost Price</label>
        <?= $form->field($model, 'cost_price')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Cost price here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-percent"></i> Gst Price</label>
        <?= $form->field($model, 'gst_price')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Gst price here.'])->label(false) ?>
    </div>
    <div class="col-md-3">
        <label class="form_label"><i class="fa fa-dollar"></i> Selling Price</label>
        <?= $form->field($model, 'selling_price')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Selling price here.'])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
     <div class="col-md-3">
        <label class="form_label">Product Image</label>
        <br/>
        <img src="assets/products/<?php echo $model->product_image; ?>" id="productImg" alt="<?php echo $model->product_image; ?>" class="img-square "></img>
        <hr/>
        <?= $form->field($model, 'product_image')->fileInput(['value' => $model->product_image, 'accept' => 'jpg|jpeg|gif|png'])->label(false) ?>
    </div>
</div>
<hr/>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>

<?php ActiveForm::end(); ?>












