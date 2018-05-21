<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Cdac */

$this->title = $model->cdac_id;
$this->params['breadcrumbs'][] = ['label' => 'Cdacs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cdac-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cdac_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cdac_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cdac_id',
            'from_salary',
            'to_salary',
            'minimum_monthly_contribution',
            'status',
            'date_time_created',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
