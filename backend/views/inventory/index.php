<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchInventory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventories';

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
        <span class="form-header"><h4><i class="fa fa-area-chart"></i> Parts Inventory</h4></span>
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
            <i class="fa fa-chain"></i> <b> New Product </b>
        </a>

        <a href="?r=supplier/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-truck"></i> <b> New Supplier </b>
        </a>

        <a href="?r=inventory/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>

        <a href="?r=inventory/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Print to PDF </b>
        </a>
    </p>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/>

    <table class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" > INVENTORY TYPE </th>
            <th class="tblalign_center" > PRODUCT NAME </th>
            <th class="tblalign_center" > QUANTITY </th>
            <th class="tblalign_center" > NEW QUANTITY </th>
            <th class="tblalign_center" > PRODUCT QUANTITY PURCHASED </th>
            <th class="tblalign_center" > INVOICE NO. </th>
            <th class="tblalign_center" > TRANSACTION DATE </th
        </tr>
    </thead>

    <tbody>
        <?php if(!empty($getParts)): ?>
            <?php foreach( $getParts as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="tblalign_center" >
                        <?php 
                            if($row['type'] == 1){
                                echo 'Stock-In';

                            }elseif($row['type'] == 2){
                                echo 'Stock-Out';
                            
                            }else{
                                echo 'Stock-Adjustment';

                            }
                        ?>
                    </td>
                    <td class="tblalign_center" ><?php echo $row['product_name'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['old_quantity'];  ?></td>
                    <td  class="tblalign_center" ><?php echo ($row['new_quantity'] == $row['old_quantity'])? 0 : $row['new_quantity']; ?></td>
                    <td  class="tblalign_center" ><?php echo ($row['type'] == 2)? $row['qty_purchased'] : 'N/A'; ?></td>
                    <td  class="tblalign_center" ><?php echo ($row['invoice_no'])? $row['invoice_no']: 'N/A';  ?></td>
                    <td  class="tblalign_center" >
                        <?php 
                            if($row['type'] == 1){
                                echo date('d-M-Y', strtotime($row['datetime_imported']));

                            }elseif($row['type'] == 2){
                                echo date('d-M-Y', strtotime($row['datetime_purchased']));
                            
                            }else{
                                echo date('d-M-Y', strtotime($row['created_at']));

                            }
                        ?>
                    </td>
                </tr>
            <?php } ?> 
        <?php else: ?>
            <tr>
                <td><span>No Record Found.</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endif; ?> 
    </tbody>
    </table>

    <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
    ?>
 
</div>

<div style="color:#fff">|<br/></div>

</div>