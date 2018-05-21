<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Product;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'supplier_name');
$dataProduct = ArrayHelper::map(Product::find()->all(), 'id', 'product_name');
$getSupplier = Supplier::find()->all();

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'method' => 'POST', 'action' => '?r=stocks/update', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="col-md-12">

        <table id="tblStocks" class="table table-hover table-boardered" >
        	<thead>
        		<tr>
        			<td class="tblstockTh0"><i class="fa fa-fire"></i> PRODUCTS NAME</td>
        			<td class="tblstockTh"><i class="fa fa-pencil"></i> ADDED STOCKS</td>
        			<td class="tblstockTh"><i class="fa fa-plus-circle"></i> QUANTITY</td>
        		</tr>
        	</thead>
        	<?php foreach($data as $key => $value): ?>
        	<tr>
        		<td>
        			<label class="tblstockTd"><i class="fa fa-cog"></i> <?php echo $value['itemName']; ?></label>
        		</td>
        		<td>
        			&nbsp;
        			<input type="text" class="form_input qtyValue form-control" style="text-align: center;" value="" id="<?php echo $value['itemId']; ?>" placeholder="0" />
        		</td>
        		<td>
        			&nbsp;
        			<input type="hidden" value="<?php echo $value['itemId']; ?>" id="<?php echo $value['itemId']; ?>" name="inventoryId[]" />
        			<input type="hidden" value="<?php echo $value['ProductId']; ?>" id="<?php echo $value['ProductId']; ?>" name="ProductId[]" />
        			<input type="hidden" value="<?php echo $value['SupplierId']; ?>" id="<?php echo $value['SupplierId']; ?>" name="SupplierId[]" />
        			<input type="hidden" value="<?php echo $value['costPrice']; ?>" id="<?php echo $value['costPrice']; ?>" name="costPrice[]" />
        			<input type="hidden" value="<?php echo $value['sellingPrice']; ?>" id="<?php echo $value['sellingPrice']; ?>" name="sellingPrice[]" />
        			<input type="text" readonly="readonly" style="text-align: center;" class="form_input qtyStock form-control" value="<?php echo $value['itemQty']; ?>" id="<?php echo $value['itemId']; ?>" name="qtyStock[]" />
        		</td>
        	</tr>
        	<?php endforeach; ?>	
        </table>

    </div>
   
</div>
<hr/>

<div class="row">

    <div class="col-md-12">
    	<div >
        	<button type="submit" class="form-btn btn btn-info" > <i class="fa fa-save"></i> Save Parts Quantity </button>
        	<?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    	</div>
    </div>

</div>
<br/>

<?php ActiveForm::end(); ?>







