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

use common\models\UserPermission;

AppAsset::register($this);

$roleId = Yii::$app->user->identity->role_id;
$userFullname = Yii::$app->user->identity->fullname;

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
    <link rel="stylesheet" href="assets/bootstrap/css/print.css" />
    <!-- <link rel="stylesheet" href="assets/bootstrap/css/cssprint.css" media="print" /> -->
    
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
    
<style type="text/css">
    


    /*body {
      background: rgb(204,204,204); 
    }
    page[size="A4"] {
      background: white;
      width: 21cm;
      height: 29.7cm;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }
    @media print {
      body, page[size="A4"] {
        margin: 0;
        box-shadow: 0;
      }
    }*/
</style>

</head>

<body style="background: #ffffff;">

        

    <!-- page content -->
        <div >
            <?= $content ?>
        </div>           

    <!-- /page content -->

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
    

    <!-- user-permission -->
    <script type="text/javascript" src="assets/bootstrap/js/user-permission.js"></script>
    
    <!-- tab -->
    <script type="text/javascript" src="assets/bootstrap/js/tab.js"></script>

    <!-- quotation -->
    <script type="text/javascript" src="assets/bootstrap/js/quotation.js"></script>
    
    <!-- staff/payroll -->
    <script type="text/javascript" src="assets/bootstrap/js/staff_payroll.js"></script>

    </body>   

</html>

<?php $this->endPage() ?>
