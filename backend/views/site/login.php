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
        <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/bootstrap/css/animate.min.css" />
        <link rel="stylesheet" href="assets/bootstrap/css/custom.css" />
        <link rel="stylesheet" href="assets/bootstrap/css/icheck/flat/green.css" />
        <link rel="stylesheet" href="assets/bootstrap/css/styles.css" />

        <!-- favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
        <link rel="manifest" href="images/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
    
        <style>
            #bodyBackground {
                background: url('images/login/background.png') no-repeat; 
                  -webkit-background-size: cover;
                  -moz-background-size: cover;
                  -o-background-size: cover;
                  background-size: cover;  
                  min-height: 500px;          
            }
        </style>
</head>

    <body id="bodyBackground" class="body">
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div style="color: #666666;" id="login" class="login-container animate form">
                <section class="login_content">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <h1><i class="fa fa-car" style="font-size: 26px;"></i> ARH GROUP </h1>
                        <div>
                            <label><i class="fa fa-user-circle"></i> Username</label>
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-username form-control', 'id' => 'form-username', 'placeholder' => 'Username...'])->label(false) ?>
                        </div>
                        <div>
                            <label><i class="fa fa-lock"></i> Password</label>
                            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'class' => 'form-password form-control', 'id' => 'form-password', 'placeholder' => 'Password...'])->label(false) ?>
                        </div>
                        <div>
                            <?= Html::submitButton('<i class=\'fa fa-sign-in\'></i> Sign-in', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                             <div class="clearfix"></div>
                            <br />
                            <div>
                                <p> ©<?php echo date('Y'); ?> All Rights Reserved. </p>
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
