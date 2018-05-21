<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

use common\models\Customer;

$session = Yii::$app->session;
$customerId = $session->get('id');
$fullName = $session->get('fullname');
$carPlate = $session->get('carplate');

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>ARH Group Pte Ltd.</title>

    <!-- CSS -->
    
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />    
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/animate.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/custom.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/maps/jquery-jvectormap-2.0.1.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/icheck/flat/green.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/editor/external/google-code-prettify/prettify.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/editor/index.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/floatexamples.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/select/select2.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/switchery/switchery.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/datatables/tools/css/dataTables.tableTools.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/dashboard-styles.css" />

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
        .bodyHeaderBackground {
            background: url('images/dashboard/background.png') no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
        }

        #bodyContentBackground {
            background: url('images/dashboard/background.png') no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
        }
    </style>

</head>

<body class="nav-md">

    <div class="container body">

        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" >
                        <a href="?" class="site_title" >
                            <div style="text-align: center;">
                                <span class="fa fa-car" id="logoContainer"></span>
                            </div>
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="assets/bootstrap/images/user.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?= Html::encode($fullName) ?></h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->
                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3 style="color:transparent;">-</h3>
                            <ul class="nav side-menu">
                                <li><a href="?"><i class="fa fa-home"></i> Dashboard </a></li>
                                <li><a href="?r=points" id="nav-customer"><i class="fa fa-money"></i> Your Points </a></li>
                                <li><a href="?r=parts" id="nav-parts"><i class="fa fa-cogs"></i> Auto-Parts List </a></li>
                                <li><a href="?r=service" id="nav-services"><i class="fa fa-battery-quarter"></i> Services List </a></li>
                                <li><a href="?r=invoice" id="nav-invoice"><i class="fa fa-files-o"></i> Invoice </a></li>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu bodyHeaderBackground">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/bootstrap/images/user.png" alt=""><b> <?= Html::encode($fullName) ?>
                                    <span class=" fa fa-angle-down"></span> </b>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <!-- <li><a href="?r=settings">
                                            <span><center id="top-nav"><b><i class="fa fa-wrench"></i> Settings</center></b></span>
                                        </a>
                                    </li> -->
                                    <li>
                                      <?php
                                        echo Html::beginForm(['/site/logout'], 'post',['id' => 'logout-form']) . '<a href="#" onclick="document.getElementById(\'logout-form\').submit(); return false;" class="form-btn btn btn-link btn-flat" style="color: #5A738E; border-top: solid 1px #5A738E;"><i class="fa fa-power-off"></i> Sign out</a>'. Html::endForm();
                                      ?>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div id="bodyContentBackground" class="right_col" role="main">
                <div class="">     
                <br/ >

                    <div >
                        <?= $content ?>
                    </div>

                </div>
                <br/><br/>

                <!-- footer content -->
                <footer>
                    <div class="">
                        <p class="pull-right">Powered by <a>FirsCom Solutions.</a>. |
                            <span class="lead"> <i class="fa fa-car"></i> ARH GROUP</span>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->

            </div>
            <!-- /page content -->

        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <!-- Javascript -->
    <script src="assets/bootstrap/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/nprogress.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- gauge -->
    <script src="assets/bootstrap/js/gauge/gauge.min.js"></script>
    <script src="assets/bootstrap/js/gauge/gauge_demo.js"></script>
    <!-- chart js -->
    <script src="assets/bootstrap/js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="assets/bootstrap/js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="assets/bootstrap/js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="assets/bootstrap/js/icheck/icheck.min.js"></script>
     <!-- daterangepicker -->
    <script type="text/javascript" src="assets/bootstrap/js/moment.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/moment.min2.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/datepicker/daterangepicker.js"></script>
    <!-- sparkline -->
    <script src="assets/bootstrap/js/sparkline/jquery.sparkline.min.js"></script>

    <script src="assets/bootstrap/js/custom.js"></script>
    <!-- skycons -->
    <script src="assets/bootstrap/js/skycons/skycons.js"></script>

    <!-- flot -->
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.orderBars.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.time.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/date.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.spline.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.stack.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/curvedLines.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/flot/jquery.flot.resize.js"></script>

    <!-- tags -->
    <script type="text/javascript" src="assets/bootstrap/js/tags/jquery.tagsinput.min.js"></script>
    <!-- switchery -->
    <script type="text/javascript" src="assets/bootstrap/js/switchery/switchery.min.js"></script>
    <!-- richtext editor -->
    <script type="text/javascript" src="assets/bootstrap/js/editor/bootstrap-wysiwyg.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/editor/external/jquery.hotkeys.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/editor/external/google-code-prettify/prettify.js"></script>
    <!-- select2 -->
    <script type="text/javascript" src="assets/bootstrap/js/select/select2.full.js"></script>
    <!-- form validation -->
    <script type="text/javascript" src="assets/bootstrap/js/parsley/parsley.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/form-validation.js"></script>
    <!-- textarea resize -->
    <script type="text/javascript" src="assets/bootstrap/js/textarea/autosize.min.js"></script>

    <script>
            autosize($('.resizable_textarea'));
    </script>

     <!-- Autocomplete -->
    <script type="text/javascript" src="assets/bootstrap/js/autocomplete/countries.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/autocomplete/jquery.autocomplete.js"></script>

    <!-- Datatables -->
    <script type="text/javascript" src="assets/bootstrap/js/datatables/js/jquery.dataTables.js"></script>
    <!-- <script type="text/javascript" src="assets/bootstrap/js/datatables/tools/js/dataTables.tableTools.js"></script> -->
    <script type="text/javascript" src="assets/bootstrap/js/table-design.js"></script>

    <script type="text/javascript" src="assets/bootstrap/js/confirmation.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/datepicker.js"></script>
    
    <!-- select2 -->
    <script type="text/javascript" src="assets/bootstrap/js/selecttwo.js"></script>

    <!-- add & remove new product -->
    <script type="text/javascript" src="assets/bootstrap/js/add-remove-new-product.js"></script>
    
    <!-- update stocks qty -->
    <script type="text/javascript" src="assets/bootstrap/js/update-stocks-qty.js"></script>
  
    <!-- flot -->
    <script type="text/javascript" src="assets/bootstrap/js/flot.js"></script>
    
    <!-- sparkline  -->
    <script type="text/javascript" src="assets/bootstrap/js/sparkline.js"></script>
    
    <!-- reportrange -->
    <!-- datepicker -->
    <script type="text/javascript" src="assets/bootstrap/js/reportrange-datepicker.js"></script>

    <!-- moris js -->
    <script type="text/javascript" src="assets/bootstrap/js/moris/raphael-min.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/moris/morris.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/moris.js"></script>
    
    <!-- skycons -->
    <script type="text/javascript" src="assets/bootstrap/js/skycons.js"></script>
    
    <!--  gauge-->
    <script type="text/javascript" src="assets/bootstrap/js/gauge.js"></script>

    </body>   

</html>

<?php $this->endPage() ?>
