<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Job Sheet */

$this->title = 'Create Job Sheet';
$this->params['breadcrumbs'][] = ['label' => 'Job Sheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'quotationId' => $quotationId,
        'branch' => $branch,
        'user' => $user,
        'customer' => $customer,
        'category' =>$category,
]) ?>

</div>
