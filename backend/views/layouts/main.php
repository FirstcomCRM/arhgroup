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

$isDashboard = false;
$isBranch = false;
$isRole = false;
$isModules = false;
$isUserPermission = false;
$isUser = false;
$isCustomer = false;
$isServiceCategory = false;
$isService = false;
$isCategory = false;
$isProduct = false;
$isSupplier = false;
$isInventory = false;
$isStaff = false;
$isStaffGroup = false;
$isAdditionalType = false;
$isClaimsType = false;
$isCpf = false;
$isCdac = false;
$isExpenses = false;
$isLeaveType = false;
$isPayroll = false;
$isQuotation = false;
$isInvoice = false;
$isBestSelling = false;
$isMonthlySales = false;
$isMonthlyStock = false;
$isGst = false;
$isProductLevel = false;
$isPaymentType = false;
$isTermsConditions = false;
$isRace = false;
$isPaymentStatus = false;
$isDesignatedPosition = false;
$isProductNotificationRecipient = false;
$isReligion = false;
$isMaritalStatus = false;
$isNationality = false;

$roleId = Yii::$app->user->identity->role_id;
$getUserPermission = UserPermission::find()->select('controller')->where(['role_id' => $roleId])->groupBy('controller')->all();

foreach ($getUserPermission as $key => $value) {

    switch($value['controller']) {
        case 'Site':
            $isDashboard = true;
        break;

        case 'Branch':
            $isBranch = true;
        break;

        case 'Role':
            $isRole = true;
        break;

        case 'Modules':
            $isModules = true;
        break;

        case 'UserPermission':
            $isUserPermission = true;
        break;

        case 'User':
            $isUser = true;
        break;

        case 'Customer':
            $isCustomer = true;
        break;

        case 'ServiceCategory':
            $isServiceCategory = true;
        break;

        case 'Service':
            $isService = true;
        break;

        case 'Category':
            $isCategory = true;
        break;

        case 'Product':
            $isProduct = true;
        break;

        case 'Supplier':
            $isSupplier = true;
        break;

        case 'Inventory':
            $isInventory = true;
        break;

        case 'Staff':
            $isStaff = true;
        break;

        case 'StaffGroup':
            $isStaffGroup = true;
        break;

        case 'AdditionalType':
            $isAdditionalType = true;
        break;

        case 'ClaimsType':
            $isClaimsType = true;
        break;

        case 'Cpf':
            $isCpf = true;
        break;

        case 'Cdac':
            $isCdac = true;
        break;

        case 'Expenses':
            $isExpenses = true;
        break;

        case 'LeaveType':
            $isLeaveType = true;
        break;

        case 'Payroll':
            $isPayroll = true;
        break;

        case 'Quotation':
            $isQuotation = true;
        break;

        case 'Invoice':
            $isInvoice = true;
        break;

        case 'Reports':
            $isBestSelling = true;
            $isMonthlySales = true;
            $isMonthlyStock = true;
        break;

        case 'Gst':
            $isGst = true;
        break;

        case 'ProductLevel':
            $isProductLevel = true;
        break;

        case 'PaymentType':
            $isPaymentType = true;
        break;

        case 'TermsAndConditions':
            $isTermsConditions = true;

        case 'Race':
            $isRace = true;
        break;

        case 'PaymentStatus':
            $isPaymentStatus = true;

        case 'DesignatedPosition':
            $isDesignatedPosition = true;

        break;

        case 'ProductNotificationRecipient':
            $isProductNotificationRecipient = true;

        break;

        case 'Religion':
            $isReligion = true;

        break;

        case 'MaritalStatus':
            $isMaritalStatus = true;

        break;

        case 'Nationality':
            $isNationality = true;

        break;

        default:
            $navigation = true;

    }

}

$userFullname = Yii::$app->user->identity->fullname;
$photo = Yii::$app->user->identity->photo;

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
    <?php $this->head() ?>

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

    <link rel="stylesheet" href="js/datepicker/css/datepicker.css" />
    <link rel="stylesheet" href="js/datetimepicker/css/jquery.datetimepicker.css" />

    <link rel="stylesheet" href="assets/bootstrap/js/timepicker/css/timepicki.css" />
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

    <?php

        if ( isset ( $_GET['r'] ) ) {
            $getClass = $_GET['r'];
            $url = explode('/', $_GET['r']);
            if ( $url ) {
              $getClass = $url[0];
            }

            if(isset($getClass) || !is_null($getClass)){
    ?>
        <style>
            @media only screen and (max-width: 2000px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1500px;
                }

            }

            @media only screen and (max-width: 1600px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1500px;
                }

            }

            @media only screen and (max-width: 1024px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1800px;
                }

            }

            @media only screen and (max-width: 800px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1800px;
                }

            }

            @media only screen and (max-width: 600px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1800px;
                }

            }

            @media only screen and (max-width: 360px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1800px;
                }

            }

            @media only screen and (max-width: 320px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1800px;
                }

            }
        </style>
    <?php }
        }else{
    ?>
        <style>
            @media (max-width: 2000px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1900px;
                }

            }

            @media (max-width: 1600px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1900px;
                }

            }

            @media (max-width: 1024px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1900px;
                }

            }

            @media (max-width: 800px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1900px;
                }

            }

            @media (max-width: 600px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1900px;
                }

            }

            @media (max-width: 360px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1900px;
                }

            }

            @media (max-width: 320px) {
                .nav_menu {
                    float: left;
                    /*background: #F4F6F9;
                    border-bottom: 1px solid #E6E9ED;*/

                    background: #EDEDED;
                    border-bottom: 2px solid #2A3F54;
                    margin-bottom: 10px;
                    min-width: 1000px;
                }

                body .container.body .right_col {
                    background: #F7F7F7;
                    min-width: 1000px;
                    min-height: 1900px;
                }

            }
        </style>
    <?php } ?>


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

    <style>canvas{}</style>

</head>

<body class="nav-md">
<?php //$this->beginBody() ?>

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
                            <img src="assets/bootstrap/photos/<?php echo $photo; ?>" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->
                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3><?= $userFullname ?></h3>
                            <ul class="nav side-menu">
                                <?php if($isDashboard): ?>
                                    <li><a href="?"><i class="fa fa-home"></i> Dashboard </a></li>
                                <?php endif; ?>
                                <?php if($isBranch): ?>
                                    <li><a href="?r=branch" ><i class="fa fa-globe"></i> Branch </a></li>
                                <?php endif; ?>
                                <?php if($isRole || $isModules || $isUserPermission || $isUser): ?>
                                    <li><a ><i class="fa fa-user-circle-o"></i>  User <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <?php if($isRole): ?>
                                                <li><a href="?r=role" > User Role</a></li>
                                            <?php endif; ?>
                                            <?php if($isModules): ?>
                                                <li><a href="?r=modules" > Module List</a></li>
                                            <?php endif; ?>
                                            <?php if($isUserPermission): ?>
                                                <li><a href="?r=user-permission" > User Permission</a></li>
                                            <?php endif; ?>
                                            <?php if($isUser): ?>
                                                <li ><a href="?r=user" > User Account </a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if($isStaff || $isDesignatedPosition || $isStaffGroup): ?>
                                    <li><a ><i class="fa fa-user-secret"></i>  Employee <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <?php if($isStaffGroup): ?>
                                                <li><a href="?r=staff-group" > Departments </a></li>
                                            <?php endif; ?>
                                            <?php if($isDesignatedPosition): ?>
                                                <li><a href="?r=designated-position"> Designated Position </a></li>
                                            <?php endif; ?>
                                            <?php if($isStaff): ?>
                                                <li><a href="?r=staff" > Staff Management </a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if($isAdditionalType || $isClaimsType || $isCpf): ?>
                                    <li><a ><i class="fa fa-address-book-o"></i> Payroll Setup <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <?php if($isAdditionalType): ?>
                                                <li><a href="?r=additional-type">Additional Type</a></li>
                                            <?php endif; ?>
                                            <?php if($isClaimsType): ?>
                                                <li><a href="?r=claims-type">Claims Type</a></li>
                                            <?php endif; ?>
                                            <?php if($isCpf): ?>
                                                <li><a href="?r=cpf">CPF</a></li>
                                            <?php endif; ?>
                                            <?php if($isCdac): ?>
                                                <li><a href="?r=cdac">CDAC</a></li>
                                            <?php endif; ?>
                                            <?php if($isExpenses): ?>
                                                <li><a href="?r=expenses">Expenses</a></li>
                                            <?php endif; ?>
                                            <?php if($isLeaveType): ?>
                                                <li><a href="?r=leave-type">Leave Type</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if($isPayroll): ?>
                                    <li><a href="?r=payroll"  ><i class="fa fa-money"></i> Payroll </a></li>
                                <?php endif; ?>
                                <?php if($isCustomer): ?>
                                    <li><a href="?r=customer"  ><i class="fa fa-users"></i> Customer </a></li>
                                <?php endif; ?>
                                <?php if($isCategory || $isProduct || $isSupplier || $isInventory): ?>
                                    <li><a ><i class="fa fa-cogs"></i> Parts <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <?php if($isCategory): ?>
                                                <li><a href="?r=category" >Category</a></li>
                                            <?php endif; ?>
                                            <?php if($isSupplier): ?>
                                                <li><a href="?r=supplier" >Parts-Supplier</a></li>
                                            <?php endif; ?>
                                            <?php if($isProduct): ?>
                                                <li><a href="?r=product" >Parts List</a></li>
                                            <?php endif; ?>
                                            <?php if($isInventory): ?>
                                                <li><a href="?r=inventory" > Parts-Inventory</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if($isQuotation || $isInvoice): ?>
                                    <li><a><i class="fa fa-qrcode"></i>Transactions <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <?php if($isQuotation): ?>
                                                <li><a href="?r=quotation" > Job Sheet</a></li>
                                            <?php endif; ?>
                                            <?php if($isInvoice): ?>
                                                <li><a href="?r=invoice" > Invoice</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if($isBestSelling || $isMonthlySales || $isMonthlyStock): ?>
                                    <li><a ><i class="fa fa-pie-chart"></i> Reports <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <?php if($isBestSelling): ?>
                                                <li><a href="?r=reports/best-selling-product-report">Best Selling Product</a></li>
                                            <?php endif; ?>
                                            <?php if($isMonthlySales): ?>
                                                <li><a href="?r=reports/monthly-sales-report">Monthly Sales Report</a></li>
                                            <?php endif; ?>
                                            <?php if($isMonthlyStock): ?>
                                                <li><a href="?r=reports/monthly-stock-report">Monthly Stocks Report</a></li>
                                            <?php endif; ?>
                                              <li><a href="?r=reports/carplate-report">CarPlate Report</a></li>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <?php if($isGst || $isProductLevel || $isPaymentType || $isTermsConditions || $isRace || $isPaymentStatus || $isProductEmailRecipient || $isReligion): ?>
                                    <li><a ><i class="fa fa-paint-brush"></i> Utilities <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none">
                                            <?php if($isGst): ?>
                                                <li><a href="?r=gst">Set GST</a></li>
                                            <?php endif; ?>
                                            <?php if($isProductLevel): ?>
                                                <li><a href="?r=product-level">Set Parts Warning Level</a></li>
                                            <?php endif; ?>
                                            <?php if($isPaymentType): ?>
                                                <li><a href="?r=payment-type">Set Payment Type</a></li>
                                            <?php endif; ?>
                                            <?php if($isTermsConditions): ?>
                                                <li><a href="?r=terms-and-conditions">Set Terms & Conditions</a></li>
                                            <?php endif; ?>
                                            <?php if($isRace): ?>
                                                <li><a href="?r=race">Set Race</a></li>
                                            <?php endif; ?>
                                            <?php if($isPaymentStatus): ?>
                                                <li><a href="?r=payment-status">Set Payment Status</a></li>
                                            <?php endif; ?>
                                            <?php if($isProductNotificationRecipient): ?>
                                                <li><a href="?r=product-notification-recipient">Set Product Email Recipient</a></li>
                                            <?php endif; ?>
                                            <?php if($isReligion): ?>
                                                <li><a href="?r=religion">Set Religion</a></li>
                                            <?php endif; ?>
                                            <?php if($isMaritalStatus): ?>
                                                <li><a href="?r=marital-status">Set Marital Status</a></li>
                                            <?php endif; ?>
                                            <?php if($isNationality): ?>
                                                <li><a href="?r=nationality">Set Nationality</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                </div>
            </div>

            <!-- top navigation -->
            <div  class="top_nav">

                <div class="nav_menu bodyHeaderBackground">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>


                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/bootstrap/photos/<?php echo $photo; ?>" alt=""><b> <?= $userFullname ?>
                                    <span class=" fa fa-angle-down"></span> </b>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="?r=settings">
                                            <span><center id="top-nav"><b><i class="fa fa-wrench"></i> Settings</center></b></span>
                                        </a>
                                    </li>
                                    <li>
                                      <?php
                                        echo Html::beginForm(['/site/logout'], 'post',['id' => 'logout-form']) . '<a href="#" onclick="document.getElementById(\'logout-form\').submit(); return false;" class="form-btn btn btn-link btn-flat" style="color: #5A738E; border-top: solid 1px #5A738E;"><i class="fa fa-power-off"></i> Sign out</a>'. Html::endForm();
                                      ?>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="?r=invoice/create">
                                <button class="buttonInHeader btn btn-round">
                                        <span class="buttonInHeaderLabel"> - <i class="fa fa-barcode"></i> New Invoice - </span>
                                </button>
                                </a>
                            </li>
                            <li>
                                <a href="?r=quotation/create">
                                <button class="buttonInHeader btn btn-round">
                                        <span class="buttonInHeaderLabel"> - <i class="fa fa-qrcode"></i> New Job-Sheet - </span>
                                </button>
                                </a>
                            </li>
                            <li>
                                <a href="?r=customer/create">
                                <button class="buttonInHeader btn btn-round">
                                        <span class="buttonInHeaderLabel"> - <i class="fa fa-users"></i> New Customer - </span>
                                </button>
                                </a>
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
                        <p class="pull-right">Powered by <a>FirstCom Solutions Pte Ltd.</a>. |
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
<?php $this->endBody() ?>
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

    <!-- main -->
    <script type="text/javascript" src="assets/bootstrap/js/main.js"></script>

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

    <!-- quotation -->
    <script type="text/javascript" src="assets/bootstrap/js/payment_method.js"></script>

    <!-- customer -->
    <script type="text/javascript" src="assets/bootstrap/js/customer.js"></script>



    <!-- inventory -->
    <script type="text/javascript" src="assets/bootstrap/js/inventory.js"></script>

    <!-- datepicker -->
    <script type="text/javascript" src="js/datepicker/js/bootstrap-datepicker.js"></script>

    <!-- datetimepicker -->
    <script type="text/javascript" src="js/datetimepicker/js/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="js/datetimepicker/build/jquery.datetimepicker.full.js"></script>

    <script type="text/javascript" src="assets/bootstrap/js/datetimepicker.js"></script>

    <!-- staff/payroll -->
    <script type="text/javascript" src="assets/bootstrap/js/staff_payroll.js"></script>

    <!-- form -->
    <script type="text/javascript" src="assets/bootstrap/js/form.js"></script>

    <!-- timepicker -->
    <script type="text/javascript" src="assets/bootstrap/js/timepicker/js/timepicki.js"></script>
    <script type="text/javascript" src="assets/bootstrap/js/timepicker.js"></script>


    <script type="text/javascript">
        var lab=[];
        var data=[];
    <?php
        $session = Yii::$app->session;
        $array = array (
            '0' => array (
                    'product' => 'Cash Payment',
                    'total' => $session->get('getTotalDailyCashSales'),
                ),
            '1' => array (
                    'product' => 'Credit Card Payment',
                    'total' => $session->get('getTotalDailyCreditCardSales'),
                ),
            '2' => array (
                    'product' => 'Nets Payment',
                    'total' => $session->get('getTotalDailyNetsSales'),
                ),
        );

        foreach($array as $tem) {
    ?>

        lab.push('<?php echo $tem['product']; ?>');
        data.push('<?php echo $tem['total']; ?>');

    <?php } ?>

        var barChartData = {
            labels : lab,
            datasets : [
                {
                    fillColor : "rgba(220,220,220,0.5)",
                    strokeColor : "rgba(220,220,220,1)",
                    data : data
                },
            ]
        }
    var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Bar(barChartData);

    </script>
</body>

</html>

<?php $this->endPage() ?>
<div id="loader"></div>
