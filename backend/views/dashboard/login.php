<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARH Group Pte Ltd.</title>

        <!-- CSS -->
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/bootstrap/fonts/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/bootstrap/css/animate.min.css" />
        <link rel="stylesheet" href="assets/bootstrap/css/custom.css" />
        <link rel="stylesheet" href="assets/bootstrap/css/icheck/flat/green.css" />
        <link rel="stylesheet" href="assets/bootstrap/css/styles.css" />

</head>

    <body class="body">
         <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="login-container animate form">
                <section class="login_content">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <h1>Login Form</h1>
                        <div>
                            <input type="text" class="form-username form-control" id="form-username" />
                            <?= $form->form($model, 'ic')->textInput()->label(false) ?>
                        </div>
                        <div>
                            
                        </div>
                        <div>
                            <?= Html::submitButton('<i class=\'fa fa-sign-in\'></i> Sign-in', ['class' => 'btn btn-info', 'name' => 'login-button']) ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                             <div class="clearfix"></div>
                            <br />
                            <div>
                                <h1><i class="fa fa-car" style="font-size: 26px;"></i> ARH Group Pte Ltd. </h1>

                                <p> © <?php echo date('Y'); ?> All Rights Reserved. </p>
                            </div>
                        </div>
                    <?php ActiveForm::end() ?>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>


            <!-- Javascript -->
            <script src="assets/bootstrap/js/jquery.min.js"></script>
            
    </body>
   
</html>

<?php $this->endPage() ?>
