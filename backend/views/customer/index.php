<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use common\models\Customer;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';

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
            <span class="form-header"><h4><i class="fa fa-users"></i> Customer Maintenance</h4></span>
        </div>
        <hr/> 
    </div>
</div>

<div style="text-align: right;" class="other-btns-container">
<br/>
    <p>
        <a href="?r=customer/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New Customer </b>
        </a>
        

        <a href="?r=customer/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>

        <a href="?r=customer/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Print to PDF </b>
        </a>
    </p>
</div>

<div class="row table-container">

<div class="" role="tabpanel" data-example-id="togglable-tabs">

<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
    <li role="presentation" class="active"><a href="#active_customer" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
        <b><i class="fa fa-user-plus"></i> Active Customer List</b></a>
    </li>
    <li role="presentation" class=""><a href="#blacklisted_customer" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">
        <b><i class="fa fa-user-times"></i> Blacklisted Customer</b></a>
    </li>
</ul>

<div id="myTabContent" class="tab-content">

<div role="tabpanel" class="tab-pane fade active in" id="active_customer" aria-labelledby="home-tab">

 <div class="col-md-12 col-sm-12 col-xs-12">
 
 <h4><i class="fa fa-user-plus"></i> Active Customer List</h4>
 <hr/>

 <div class="form-search-container">    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
 </div> 

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" > CUSTOMER NAME </th>
            <th class="tblalign_center" > UEN NO. / NRIC NO. </th>
            <th class="tblalign_center" > PHONE NUMBER </th>
            <th class="tblalign_center" > OFFICE NUMBER </th>
            <th class="tblalign_center" > fAX NUMBER </th>
            <th class="tblalign_center" > EMAIL </th>
            <th class="no-link last tblalign_center"><span class="nobr">RECORD ACTION</span></th>
        </tr>
    </thead>

    <tbody>
        <?php if(count($getCustomer) > 0 ): ?>
            <?php foreach( $getCustomer as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['company_name'] : $row['fullname'];  ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['uen_no'] : $row['nric'];  ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['hanphone_no'] : $row['hanphone_no']; ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['office_no'] : $row['office_no']; ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['fax_number'] : $row['fax_number']; ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['email'] : $row['email'];  ?></td>
                    <td class="last tblalign_center">
                        <a href="?r=customer/export-invoices&customer_id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Download Invoices" ><li class="fa fa-download"></li> </a> |
                        <a href="?r=customer/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-eye"></li> </a> |
                        <a href="?r=customer/update&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit Record" ><li class="fa fa-pencil-square"></li> </a> | 
                        <a href="?r=customer/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()" data-toggle="tooltip" data-placement="top" title="Delete Record" ><li class="fa fa-trash"></li> </a> |
                        <a href="?r=customer/points-redemption-history&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Points Redemption History" ><li class="fa fa-laptop"></li> </a> |
                        <a href="?r=customer/block-customer&id=<?php echo $row['id']; ?>" onclick="return blockCustomer()" data-toggle="tooltip" data-placement="top" title="Block this Customer" ><li class="fa fa-user-times"></li> </a> 
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
                <td></td>
            </tr>
        <?php endif; ?>    
    </tbody>
    </table>
 
 </div>

 <div style="color:#fff">|<br/>|<br/></div>

</div>

<div role="tabpanel" class="tab-pane fade" id="blacklisted_customer" aria-labelledby="profile-tab">

 <div class="col-md-12 col-sm-12 col-xs-12">
 
 <h4><i class="fa fa-user-times"></i> Blacklisted Customer</h4>
 <hr/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" > CUSTOMER NAME </th>
            <th class="tblalign_center" > UEN NO. / NRIC NO. </th>
            <th class="tblalign_center" > PHONE NUMBER </th>
            <th class="tblalign_center" > OFFICE NUMBER </th>
            <th class="tblalign_center" > EMAIL </th>
            <th class="no-link last tblalign_center"><span class="nobr">RECORD ACTION</span></th>
        </tr>
    </thead>

    <tbody>
        <?php if(count($getBlacklistCustomer) > 0 ): ?>
            <?php foreach( $getBlacklistCustomer as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['company_name'] : $row['fullname'];  ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['uen_no'] : $row['nric'];  ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['hanphone_no'] : $row['hanphone_no'];  ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['office_no'] : $row['office_no']; ?></td>
                    <td class="tblalign_center" ><?php echo ( $row['type'] == 1 )? $row['email'] : $row['email'];  ?></td>
                    <td class="last tblalign_center">
                        <a href="?r=customer/unblock-customer&id=<?php echo $row['id']; ?>" onclick="return unblockCustomer()" data-toggle="tooltip" data-placement="top" title="UnBlock this Customer" ><li class="fa fa-user-plus"></li> </a> 
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
                <td></td>
            </tr>
        <?php endif; ?>    
    </tbody>
    </table>
 
 </div>

 <div style="color:#fff">|<br/>|<br/></div>

</div>

</div>

</div>

</div>


                                        
                                        
                                            
                                    