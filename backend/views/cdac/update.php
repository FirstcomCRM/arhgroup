<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Cdac */

$this->title = 'Update Cdac: ' . $model->cdac_id;
$this->params['breadcrumbs'][] = ['label' => 'Cdacs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cdac_id, 'url' => ['view', 'id' => $model->cdac_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cdac-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
