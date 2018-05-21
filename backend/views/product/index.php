<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use common\models\Product;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';

?>

<div class="row form-container">

<div>
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
            <h5 class="alert-heading"><i class="fa fa-info-circle"></i> <?= Yii::$app->session->getFlash('success'); ?></h5>
        </div>
    <?php endif; ?>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-cogs"></i> Parts Maintenance</h4></span>
    </div>
    <hr/>

    <div class="form-search-container">    
      <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>   
 
 </div>

</div>

<div style="text-align: right;" class="other-btns-container">
<br/>

    <p>
        <a href="?r=product/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New Product </b>
        </a>

        <a href="?r=supplier/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-truck"></i> <b> New Supplier </b>
        </a>

        <a href="?r=product/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>

        <a href="?r=product/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Print to PDF </b>
        </a>
    </p>
</div>

<?php $form = ActiveForm::begin(['action' => '?r=product/edit-qty', 'method' => 'POST', 'class' => 'form-inline']); ?>

<div class="row table-container">

<div class="col-md-12 col-sm-12 col-xs-12">
<br/>
    <?= Html::Button('<li class=\'fa fa-check-square\'></li> Select All', ['class' => 'form-btn btn btn-info', 'id' => 'btnChkBox']); ?>
    <?= Html::Button('<li class=\'fa fa-square\'></li> Unselect All', ['class' => 'btnUnChkBox form-btn btn btn-danger hidden', 'id' => 'btnUnChkBox']); ?>
    <?= Html::submitButton('<li class=\'fa fa-check-square\'></li> Update Parts Quantity', ['class' => 'form-btn btn btn-dark', 'id' => 'btnChkBoxs']); ?>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
<br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" >
                <span style="font-size: 16px;" class="fa fa-check-square-o"></span>
            </th>
            <th class="tblalign_center" >
                <?php for($x = 1; $x <= 3; $x++): ?>
                    <i class="fa fa-cog"></i>
                <?php endfor; ?>
            </th>
            <th class="tblalign_center" > PARTS CATEGORY </th>
            <th class="tblalign_center" > PARTS NAME </th>
            <th class="tblalign_center" > QUANTITY </th>
            <th class="no-link last tblalign_center"><span class="nobr">RECORD ACTION</span></th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getProduct)): ?>
            <?php foreach( $getProduct as $row): ?>
                <tr class="even_odd pointer">
                    <td class="tblalign_center" >
                        <input type="checkbox" class="partsChkbox" name="partsChkbox[]" value="<?php echo $row['id'] . '|' . $row['product_name'] . '|' . $row['quantity'] . '|' . $row['supplier_id'] . '|' . $row['cost_price'] . '|' . $row['selling_price'];  ?>" >
                    </td>
                    <td class="tblalign_center" >
                        <img src="assets/products/<?php echo $row['product_image']; ?>" id="productImgIndex" alt="<?php echo $row['product_image']; ?>" class="img-square "></img>
                    </td>
                    <td class="tblalign_center" ><?php echo $row['category'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['product_name'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['quantity'];  ?></td>
                    <td class="last tblalign_center">
                        <a href="?r=product/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-eye"></li> </a> |
                        <a href="?r=product/update&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit Record" ><li class="fa fa-pencil-square"></li> </a> | 
                        <a href="#" id="<?php echo $row['id']; ?>" class="deductStocksQty" data-toggle="tooltip" data-placement="top" title="Change Quantity" ><li class="fa fa-database"></li> </a> |
                        <a href="?r=product/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()" data-toggle="tooltip" data-placement="top" title="Delete Record" ><li class="fa fa-trash"></li> </a> 
                    </td>
                </tr>
            <?php endforeach; ?> 
        <?php else: ?>
            <tr>
                <td><span>No Record Found.</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endif; ?>
    </tbody>
    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/></div>

</div>

<?php ActiveForm::end(); ?>

<div class="modal fade" id="modal-launcher-inventory" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-database"></i> <b>Change Quantity</b> </h5>
            </div>

            <div class="modal-body">

                <form id="i-modal-form" class="i-modal-form" method="POST">
                    
                    <div style="font-size:11px;" id="product_information" class="product_information"></div>
                    <input type="hidden" id="productId" class="productId" />
                    <input type="hidden" id="oldQty" class="oldQty" />
                    <input type="hidden" id="newQty" class="newQty" />

                </form>

            </div>

            <div class="modal-footer">
                <button type="button" id="modal-submit-i" class="form-btn btn btn-primary"><i class="fa fa-save"></i> Submit</button>
            </div>

        </div>
    </div>
</div>


