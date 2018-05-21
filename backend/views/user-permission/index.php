<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use common\models\UserPermission;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchUserPermission */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Permission';

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
        <span class="form-header"><h4><i class="fa fa-user-circle-o"></i> User Permission Maintenance</h4></span>
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
        <a href="?r=user-permission/set-permission" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New User Permission </b>
        </a>
    </p>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" > # </th>
            <th class="tblalign_center" > USER-ROLES </th>
            <th class="tblalign_center" > SYSTEM-CONTROLLERS </th>
            <th class="tblalign_center" > ALLOWED ACTIONS </th>
            <th class="no-link last tblalign_center"><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getUserPermission) ): ?>
            <?php foreach( $getUserPermission as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="tblalign_center" ><?php echo $row['id'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['role'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['controller'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['action'];  ?></td>
                    <td class="last tblalign_center">
                        <!-- <a href="?r=modules/view&id=<?php echo $row['id']; ?>"><b><li class="fa fa-eye"></li> VIEW </b></a> |  -->
                        <!-- <a href="?r=modules/update&id=<?php echo $row['id']; ?>"><b><li class="fa fa-pencil-square"></li> UPDATE </b></a> |  -->
                        <a href="?r=user-permission/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()" data-toggle="tooltip" data-placement="top" title="Delete Record" ><li class="fa fa-trash"></li> </a>
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








