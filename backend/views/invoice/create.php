<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Job Sheet */

$this->title = 'Create Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoice', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'invoiceId' => $invoiceId,
        'branch' => $branch,
        'user' => $user,
        'customer' => $customer,
        'category' =>$category,
        'redeem_point' => $redeem_point,
        'redeem_price' => $redeem_price,
]) ?>

</div>
