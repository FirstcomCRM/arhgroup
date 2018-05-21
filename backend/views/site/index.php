<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';

$roleId = Yii::$app->user->identity->role_id;

?>

<div style="margin-top: 50px;">

<?php
 // if( $roleId == 1 || $roleId == 2 ):
  ?>
<!-- Search Customer -->
<div class="row dashboardContentContainer">
<br/>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-vcard"></i> Customer List 
                        <small class="searchCustomerLabel">(<b>Search by:</b> Customer Name / Carplate / Product Name )</small>
                    </h4>
                </div>
            </div>

            <div class="x_content">
                <?php $form = ActiveForm::begin(['action' => '?', 'method' => 'post']); ?>
                    <div style="width: 75%;" class="input-group">
                        <input type="text" name="customerSearchkeyword" id="customerSearchBox" class="form-control" value="<?= $keywordValue ?>" placeholder="Enter keyword here." />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i> Search!</button> 
                        </span>
                    </div>
                <?php ActiveForm::end(); ?>

                <?php if( !empty($getCustomerInvoiceBySearch) ): ?>
                    
                    <div class="table-responsive">

                    <table class="table table-boardered table-striped pendingTable datatable">
                        <thead>
                            <tr class="headings">
                                <td class="tblalign_center" ><b><i class="fa fa-barcode"></i> INVOICE NUMBER </b></td>
                                <td class="tblalign_center" ><b><i class="fa fa-calendar-o"></i> DATE ISSUE </b></td>
                                <td class="tblalign_center" ><b><i class="fa fa-user"></i> SALES PERSON </b></td>
                                <td class="tblalign_center" ><b><i class="fa fa-users"></i> CUSTOMER NAME </b></td>
                                <td class="tblalign_center" ><b><i class="fa fa-cc-stripe"></i> MODEL </b></td>
                                <td class="tblalign_center" ><b><i class="fa fa-cc-stripe"></i> CAR PLATE </b></td>
                                <td class="tblalign_center" ><b><i class="fa fa-chrome"></i> PRODUCT </b></td>
                                <td class="tblalign_center" ><b><i class="fa fa-chrome"></i> SERVICE </b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $getCustomerInvoiceBySearch as $custiRow): ?>
                                <tr>
                                    <td class="tblalign_center link" ><a href="?r=invoice/view&id=<?php echo $custiRow['id']; ?>&invoiceNo=<?php echo $custiRow['invoice_no']; ?>" target="_blank"><?php echo $custiRow['invoice_no']; ?></a></td>
                                    <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($custiRow['date_issue']) ); ?></td>
                                    <td class="tblalign_center" ><?php echo $custiRow['salesPerson']; ?></td>
                                    <td class="tblalign_center" ><?php echo ($custiRow['type'] == 1)? $custiRow['company_name']: $custiRow['fullname']; ?></td>
                                    <td class="tblalign_center" ><?php echo $custiRow['model']; ?></td>
                                    <td class="tblalign_center" ><?php echo $custiRow['carplate']; ?></td>
                                    <td class="tblalign_center" ><?php echo $custiRow['product_name']; ?></td>
                                    <td class="tblalign_center" ><?php echo $custiRow['service_part_id']; ?></td>
                                    
                                </tr>
                            <?php endforeach; ?>    
                        </tbody>
                    </table>
                    
                    </div>

                <?php else: ?>
                    <div>
                        <span class="pendingNoRecordDashboard"> - No Search Found. <span>
                    </div>
                    <br/>
                <?php endif; ?>
            </div>

        </div>
    </div>  
</div>
<br/>

<?php //endif; ?>

<?php //if( $roleId == 1 || $roleId == 2 ): ?>
<!-- Search Customer -->
<div class="row dashboardContentContainer">
<br/>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-money"></i> Outstanding Payments 
                        <small class="searchCustomerLabel">(invoice with outstanding balance)</small>
                    </h4>
                </div>
            </div>

            <?php if( !empty($oustandingpaymentsInvoice) ): ?>
                <div class="table-responsive">
                <table class="table table-boardered table-striped pendingTable">
                    <thead>
                        <tr class="headings">
                            <td class="tblalign_center" ><b><i class="fa fa-calendar-minus-o"></i> DATE ISSUE </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-barcode"></i> INVOICE NUMBER </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-users"></i> CUSTOMER NAME </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-globe"></i> BRANCH NAME </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-user"></i> SALES PERSON </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-search"></i> CHECK INVOICE </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $oustandingpaymentsInvoice as $opRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($opRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><?php echo $opRow['invoice_no']; ?></td>
                                <td class="tblalign_center" ><?php echo ($opRow['type'] == 1)? $opRow['company_name']: $opRow['fullname']; ?></td>
                                <td class="tblalign_center" ><?php echo $opRow['branchName']; ?></td>
                                <td class="tblalign_center" ><?php echo $opRow['salesPerson']; ?></td>
                                <td class="tblalign_center" >
                                 <a href="?r=invoice/view&id=<?php echo $opRow['id']; ?>&invoiceNo=<?php echo $opRow['invoice_no']; ?>" >
                                    <b>View</b>
                                 </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>     
                    </tbody>
                </table>
                
                </div>
            <?php else: ?>
                <div>
                    <span class="pendingNoRecordDashboard"> - No Record Found. <span>
                </div>
                <br/>
            <?php endif; ?>

        </div>
    </div>
</div>
<br/>

<?php //endif; ?>

<?php if( $roleId == 1 || $roleId == 2 ): ?>
<!-- Pending Invoice -->
<div class="row dashboardContentContainer">
<br/>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-street-view"></i> Pending Services
                        <small class="searchCustomerLabel">(Pending Services with Invoice)</small>
                    </h4>
                </div>
            </div>

            <?php if( !empty($pendingInvoiceServices) ): ?>
                <div class="table-responsive">
                <table class="table table-boardered table-striped pendingTable">
                    <thead>
                        <tr class="headings">
                            <td class="tblalign_center" ><b><i class="fa fa-calendar-check-o"></i> DATE ISSUE </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-barcode"></i> INVOICE NUMBER </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-users"></i> CUSTOMER NAME </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-battery-full"></i> SERVICE NAME </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-money"></i> SELLING PRICE </b></td>
                            <td class="tblalign_center" ><b><i class="fa fa-search"></i> CHECK INVOICE </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $pendingInvoiceServices as $iRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($iRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><?php echo $iRow['invoice_no']; ?></td>
                                <td class="tblalign_center" ><?php echo ($iRow['type'] == 1)? $iRow['company_name']: $iRow['fullname']; ?></td>
                                <td class="tblalign_center" ><?php echo $iRow['service_part_id']; ?></td>
                                <td class="tblalign_center" >$ <?php echo number_format($iRow['subTotal'],2); ?></td>
                                <td class="tblalign_center" >
                                 <a href="?r=invoice/view-by-pending-services&id=<?php echo $iRow['invoiceId']; ?>&invoiceNo=<?php echo $iRow['invoice_no']; ?>" >
                                    <b>View</b>
                                 </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>     
                    </tbody>
                </table>
                
                </div>
            <?php else: ?>
                <div>
                    <span class="pendingNoRecordDashboard"> - No Record Found. <span>
                </div>
                <br/>
            <?php endif; ?>

        </div>
    </div>
</div>
<br/>

<?php endif; ?>

<?php if( $roleId == 1 || $roleId == 2 ): ?>
<!-- Pending Invoice -->
<div class="row dashboardContentContainer">
<br/>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-bar-chart"></i> Daily Sales
                        <small class="searchCustomerLabel"></small>
                    </h4>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <br/>
                    <canvas id="canvas" height="500" width="600"></canvas>
                </div>
                
                <div class="col-md-6">
                <br/>
                
                    <div class="row">
                        <div class="col-md-11 revenuesDashboard">
                            <div class="revenuesContainer">
                                <h5><b>TOTAL SALES</b></h5>
                                <hr/>
                                <?php if( !empty($getTotalDailySales) ): ?>
                                  <?= Html::encode('$ '.number_format($getTotalDailySales,2)) ?>
                                <?php else: ?>  
                                   0
                                <?php endif; ?>
                            </div>
                            <br/>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-11 revenuesDashboard">
                            <div class="revenuesContainer">
                                <h5><b>CASH PAYMENT</b></h5>
                                <hr/>
                                <?php if( !empty($getTotalDailyCashSales) ): ?>
                                  <?= Html::encode('$ '.number_format($getTotalDailyCashSales,2)) ?>
                                <?php else: ?>  
                                   0
                                <?php endif; ?>            
                            </div>
                            <br/>
                        </div>    
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-11 revenuesDashboard">
                            <div class="revenuesContainer">
                                <h5><b>CREDIT CARD PAYMENT</b></h5>
                                <hr/>
                                <?php if( !empty($getTotalDailyCreditCardSales) ): ?>
                                  <?= Html::encode('$ '.number_format($getTotalDailyCreditCardSales,2)) ?>
                                <?php else: ?>  
                                   0
                                <?php endif; ?>            
                            </div>
                            <br/>
                        </div>
                    </div>
                    <br/>

                    <div class="row">  
                        <div class="col-md-11 revenuesDashboard">
                            <div class="revenuesContainer">
                                <h5><b>NETS PAYMENT</b></h5>
                                <hr/>
                                <?php if( !empty($getTotalDailyNetsSales) ): ?>
                                  <?= Html::encode('$'.$getTotalDailyNetsSales.'.00') ?>
                                <?php else: ?>  
                                   0
                                <?php endif; ?>            
                            </div>
                            <br/>
                        </div>
                    </div>
                    <br/>

                </div>

        </div>
    </div>
</div>

</div>

<?php endif; ?>

<?php if( $roleId == 1 || $roleId == 2 || $roleId == 3 ): ?>
<div class="row">

<!-- Warning Stock -->
<div class="col-md-4 col-sm-4 col-xs-12">
<br/>
    <div class="x_panel dashboardContentContainer">

    <div class="x_title">
        <h5><b> <i class="fa fa-sort-amount-desc"></i> Parts in Warning Stock <i class="fa fa-cubes"></i> </b></h5>
        <ul class="nav navbar-right panel_toolbox"></ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <div class="dashboard-widget-content">

        <ul class="list-unstyled timeline widget">
           <?php if( !empty($getWarningStock) ): ?>
               <?php foreach( $getWarningStock as $wStock ): ?>        
                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title">
                                    <a class="partsDashboard"> 
                                        <i class="fa fa-dropbox"></i><?php echo $wStock['product_name']; ?> [<?php echo $wStock['quantity']; ?>] 
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </li>   
                <?php endforeach; ?>
                    <div class="partsTotalDashboard">
                        <a href="?r=inventory">
                            See All (<?= $getTotalWarningStock ?>) 
                        </a>
                    </div>
            <?php else: ?>
                <li>
                    <div class="block">
                        <div class="block_content">
                            <h2 class="title">
                                <a class="partsNoRecordDashboard">
                                    - No Record Found.
                                </a>
                            </h2>
                        </div>
                    </div>
                </li>  
            <?php endif; ?>
        </ul>

        </div>
    </div>

    </div>
</div>

<!-- Critical Stock -->
<div class="col-md-4 col-sm-4 col-xs-12">
<br/>
    <div class="x_panel dashboardContentContainer">

    <div class="x_title">
        <h5><b> <i class="fa fa-sort-amount-desc"></i> Parts in Critical Stock <i class="fa fa-cubes"></i> </b></h5>
        <ul class="nav navbar-right panel_toolbox"></ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <div class="dashboard-widget-content">

        <ul class="list-unstyled timeline widget">
           <?php if( !empty($getCriticalStock) ): ?>
               <?php foreach( $getCriticalStock as $cStock ): ?>        
                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title">
                                    <a class="partsDashboard"> 
                                        <i class="fa fa-dropbox"></i><?php echo $cStock['product_name']; ?> [<?php echo $cStock['quantity']; ?>] 
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </li>   
                <?php endforeach; ?>
                    <div class="partsTotalDashboard">
                        <a href="?r=inventory">
                            See All (<?= $getTotalCriticalStock ?>) 
                        </a>
                    </div>
            <?php else: ?>
                <li>
                    <div class="block">
                        <div class="block_content">
                            <h2 class="title">
                                <a class="partsNoRecordDashboard">
                                    - No Record Found.
                                </a>
                            </h2>
                        </div>
                    </div>
                </li>  
            <?php endif; ?>
        </ul>

        </div>
    </div>

    </div>
</div>

<!--  Zero Stock -->
<div class="col-md-4 col-sm-4 col-xs-12">
<br/>
    <div class="x_panel dashboardContentContainer">

    <div class="x_title">
        <h5><b> <i class="fa fa-sort-amount-desc"></i> Parts in Zero Stock <i class="fa fa-cubes"></i> </b></h5>
        <ul class="nav navbar-right panel_toolbox"></ul>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <div class="dashboard-widget-content">

        <ul class="list-unstyled timeline widget">
           <?php if( !empty($getZeroStock) ): ?>
               <?php foreach( $getZeroStock as $zStock ): ?>        
                    <li>
                        <div class="block">
                            <div class="block_content">
                                <h2 class="title">
                                    <a class="partsDashboard"> 
                                        <i class="fa fa-dropbox"></i><?php echo $zStock['product_name']; ?> [<?php echo $zStock['quantity']; ?>] 
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </li>   
                <?php endforeach; ?>
                    <div class="partsTotalDashboard">
                        <a href="?r=inventory">
                            See All (<?= $getTotalZeroStock ?>) 
                        </a>
                    </div>
            <?php else: ?>
                <li>
                    <div class="block">
                        <div class="block_content">
                            <h2 class="title">
                                <a class="partsNoRecordDashboard">
                                    - No Record Found.
                                </a>
                            </h2>
                        </div>
                    </div>
                </li>  
            <?php endif; ?>
        </ul>

        </div>
    </div>

</div>
</div>
<br/>

</div>
<?php endif; ?>

</div>
