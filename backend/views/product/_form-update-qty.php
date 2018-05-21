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

// $datetime = date('Y-m-d h:i:s');
// $userId = Yii::$app->user->identity->id;
// $dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'supplier_name');
// $dataProduct = ArrayHelper::map(Product::find()->all(), 'id', 'product_name');
// $getSupplier = Supplier::find()->all();

?>

<div class="row form-container">

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-database"></i> Update Stocks</h4></span>
    </div>
    <hr/>

    <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
    <br/><br/>

    <div class="form-crud-container">
        
        <?php $form = ActiveForm::begin([ 'method' => 'POST', 'action' => '?r=product/update-stocks-quantity' ]); ?>

        <div class="row">

            <div class="col-md-12">

                <table id="tblStocks" class="table table-hover table-boardered" >
                    <thead>
                        <tr>
                            <td class="tblstockTh0"><i class="fa fa-dropbox"></i> PRODUCTS NAME</td>
                            <td class="tblstockTh"><i class="fa fa-codepen"></i> ADD STOCK/S</td>
                            <td class="tblstockTh"><i class="fa fa-bitbucket"></i> QUANTITY</td>
                        </tr>
                    </thead>
                    <?php foreach($data as $key => $value): ?>
                    <tr>
                        <td>
                            <label class="tblstockTd"><i class="fa fa-archive"></i> <?php echo $value['itemName']; ?></label>
                        </td>
                        <td>
                            &nbsp;
                            <input type="text" class="partsAddStock-<?php echo $value['itemId']; ?> form_input form-control" style="text-align: center;" onchange="partsQtyValue(<?php echo $value['itemId']; ?>)" placeholder="0" />
                        </td>
                        <td>
                            &nbsp;
                            <input type="text" readonly="readonly" style="text-align: center;" class="partsNewQuantity-<?php echo $value['itemId']; ?> form_input partsNewQty form-control" value="<?php echo $value['itemQty']; ?>" name="partsNewQty[]" />
                            <input type="hidden" class="partsOldQuantity-<?php echo $value['itemId']; ?>" value="<?php echo $value['itemQty']; ?>" name="partsOldQty[]" />
                            <input type="hidden" value="<?php echo $value['itemId']; ?>" id="<?php echo $value['itemId']; ?>" name="partsId[]" />
                            <input type="hidden" value="<?php echo $value['SupplierId']; ?>" id="<?php echo $value['SupplierId']; ?>" name="supplierId[]" />
                            <input type="hidden" value="<?php echo $value['costPrice']; ?>" id="<?php echo $value['costPrice']; ?>" name="costPrice[]" />
                            <input type="hidden" value="<?php echo $value['sellingPrice']; ?>" id="<?php echo $value['sellingPrice']; ?>" name="sellingPrice[]" />
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

    </div>   
 
 </div>

</div>
<br/>









