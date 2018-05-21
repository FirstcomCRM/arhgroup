<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Cdac */

$this->title = 'Create Cdac';
$this->params['breadcrumbs'][] = ['label' => 'Cdacs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row form-container">

<div class="cdac-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

</div>
