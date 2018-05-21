<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchPayroll */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payrolls';

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
        <span class="form-header"><h4><i class="fa fa-globe"></i> Staff Payroll </h4></span>
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
        <a href="?r=payroll/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New Payroll </b>
        </a>

        <a href="?r=payroll/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>

        <a href="?r=payroll/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Print to PDF </b>
        </a>
    </p>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" > PAYSLIP NO. </th>
            <th class="tblalign_center" > PAYSLIP MONTH </th>
            <th class="tblalign_center" > DATE ISSUE </th>
            <th class="tblalign_center" > STAFF </th>
            <th class=" no-link last tblalign_center"><span class="nobr">RECORD ACTION</span></th>
        </tr>
    </thead>

    <tbody>
        <?php if(count($getPayroll) > 0 ): ?>
            <?php foreach( $getPayroll as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="tblalign_center" ><?php echo $row['payslip_no'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['payslip_cutoff'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['date_issue'];  ?></td>
                    <td  class="tblalign_center" ><?php echo $row['fullname'];  ?></td>
                    <td class="last tblalign_center">
                        <a href="?r=payroll/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-eye"></li> </a> |
                        <a href="?r=payroll/update&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit Record" ><li class="fa fa-pencil-square"></li> </a> | 
                        <a href="?r=payroll/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()" data-toggle="tooltip" data-placement="top" title="Delete Record"  ><li class="fa fa-trash"></li> </a> | 
                    <?php if($row['citizenship'] == 1): ?>
                        <a href="?r=payroll/print-local-payslip&id=<?php echo $row['id']; ?>" onclick="return printConfirmation()" data-toggle="tooltip" data-placement="top" title="Print Record"  ><li class="fa fa-print"></li> </a>
                    <?php else: ?>
                        <a href="?r=payroll/print-foreign-payslip&id=<?php echo $row['id']; ?>" onclick="return printConfirmation()" data-toggle="tooltip" data-placement="top" title="Print Record"  ><li class="fa fa-print"></li> </a>
                    <?php endif; ?>
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
 
</div>

<div style="color:#fff">|<br/>|<br/></div>

</div>
