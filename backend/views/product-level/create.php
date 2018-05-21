<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductLevel */

$this->title = 'Create Product Level';
$this->params['breadcrumbs'][] = ['label' => 'Product Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
