<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCdac */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cdac-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<!--     <?= $form->field($model, 'cdac_id') ?> -->

    <?= $form->field($model, 'from_salary') ?>

    <?= $form->field($model, 'to_salary') ?>

<!--     <?= $form->field($model, 'minimum_monthly_contribution') ?> -->

<!--     <?= $form->field($model, 'status') ?> -->

    <?php // echo $form->field($model, 'date_time_created') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
