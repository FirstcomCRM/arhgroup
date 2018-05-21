<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CarInformation;
use common\models\Customer;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchJob Sheet */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-index">


<div style="text-align: right;" class="other-btns-container">
<br/>

    <p>
        <a href="?r=invoice/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New Invoice </b>
        </a>

        <a href="?r=invoice/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>
    </p>
</div>

<div class="row table-container">
    <div class="col-md-12">
        <div>
            <?php if(Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
                    <h5 class="alert-heading"><i class="fa fa-info-circle"></i> <?= Yii::$app->session->getFlash('success'); ?></h5>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="form-title-container">
                <span class="form-header"><h4><i class="fa fa-qrcode"></i> Invoice</h4></span>
            </div>
            <hr/>

            <div class="form-search-container">    
              <?php // $this->render('_search'); ?>
            </div> 
            
        </div>

        <h1><?= Html::encode($this->title) ?></h1>
        <?php 

        // echo "<pre>";var_dump($params);
        ?>
        <?php echo $this->render('_search', ['model' => $searchModel, 'params' => $params, 'branches' => $branches, 'staff' => $staff]); ?>

        <p>
            <?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'invoice_no',
                [
                    'attribute' => 'Date Issue',
                    'format' => 'raw',
                    'value' => function($model) {
                        return '<div>'.date('d-m-Y', strtotime($model['date_issue'])).'<div>';
                    },
                ],
                [
                    'value' => 'branch_name',
                    'label' => 'Branch',
                ],
                [
                    'value' => 'username',
                    'label' => 'Staff',
                ],
                [
                    'attribute' => 'Customer Name',
                    'format' => 'raw',
                    'value' => function($model) {
                        return '<div>'.$model['name'].'<div>';
                    },
                ],
                [
                    'value' => 'carplate',
                    'label' => 'Car Plate',
                ],
                [
                    'attribute' => 'Paid',
                    'format' => 'raw',
                    'value' => function($model) {
                        // return '<div>'.($model['payment_status']=='Unpaid' ? 'NOT YET':'YES').'<div>';
                        return '<div class="'.($model['payment_status']=='Unpaid' || $model['payment_status']=='Partially Paid' ? 'text-danger': 'text-success').'">'.$model['payment_status'].'<div>';
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a(' <span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                                'title' => Yii::t('app', 'View'),
                            ]);
                        },
                        'update' => function ($url, $model) {
                            if($model['paid']==0)
                            {
                                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', $url, [
                                    'title' => Yii::t('app', 'Update'),
                                ]);
                            }
                            else{
                                return Html::a(' <span class="glyphicon glyphicon-pencil"></span> ', '', [
                                    'title' => Yii::t('app', 'Update'), 'class'=>'invisible'
                                ]);
                            }
                        },
                        'delete' => function ($url, $model) {
                            if($model['paid']==0)
                            {
                                 return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                    ],
                                ]);
                            }
                            else{
                                return Html::a(' <span class="glyphicon glyphicon-trash"></span> ', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                    ],
                                    'class'=>'invisible'
                                ]);
                            }
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url ='?r=invoice/view&id='.$model['id'];
                            return $url;
                        }   
                        if ($action === 'update') {
                            $url ='?r=invoice/update&id='.$model['id'];
                            return $url;
                        }   
                        if ($action === 'delete') {
                            $url ='?r=invoice/delete&id='.$model['id'];
                            return $url;
                        }
                    }
                ],
            ],
        ]); ?>
    </div>
</div>
