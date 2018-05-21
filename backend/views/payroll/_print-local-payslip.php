<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Payroll */

$this->title = 'Print Payslip';

if($payrollInformation['basic'] == 0 || $payrollInformation['basic'] == '0.00'){
    $standardPay = 0;
}else{
    $standardPay = number_format($payrollInformation['basic'],2);
}      

if($payrollInformation['overtime_hour'] == 0 || $payrollInformation['overtime_hour'] == '0.00'){
    $overtimeHour = 0;
}else{
    $overtimeHour = number_format($payrollInformation['overtime_hour'],2);
} 

if($payrollInformation['overtime_rate_per_hour'] == 0 || $payrollInformation['overtime_rate_per_hour'] == '0.00'){
    $overtimeRatePerHour = 0;
}else{
    $overtimeRatePerHour = number_format($payrollInformation['overtime_rate_per_hour'],2);
}   

if($payrollInformation['overtime_pay'] == 0 || $payrollInformation['overtime_pay'] == '0.00'){
    $overtimePay = 0;
}else{
    $overtimePay = number_format($payrollInformation['overtime_pay'],2);
}    

if($payrollInformation['allowance'] == 0 || $payrollInformation['allowance'] == '0.00'){
    $allowance = 0;
}else{
    $allowance = number_format($payrollInformation['allowance'],2);
}    

if($payrollInformation['non_tax_allowance'] == 0 || $payrollInformation['non_tax_allowance'] == '0.00'){
    $nonTaxAllowance = 0;
}else{
    $nonTaxAllowance = number_format($payrollInformation['non_tax_allowance'],2);
} 

$totalEarning = $payrollInformation['basic'] + $payrollInformation['overtime_pay'];
$totalEarning += $payrollInformation['non_tax_allowance'];

if($payrollInformation['cash_advance'] == 0 || $payrollInformation['cash_advance'] == '0.00'){
    $cashAdvance = 0;
}else{
    $cashAdvance = number_format($payrollInformation['cash_advance'],2);
}   

if($payrollInformation['other_deductions'] == 0 || $payrollInformation['other_deductions'] == '0.00'){
    $otherDeductions = 0;
}else{
    $otherDeductions = number_format($payrollInformation['other_deductions'],2);
}   

if($payrollInformation['employee_cpf'] == 0 || $payrollInformation['employee_cpf'] == '0.00'){
    $employeeCpf = 0;
}else{
    $employeeCpf = number_format($payrollInformation['employee_cpf'],2);
}  

if($payrollInformation['employer_cpf'] == 0 || $payrollInformation['employer_cpf'] == '0.00'){
    $employerCpf = 0;
}else{
    $employerCpf = number_format($payrollInformation['employer_cpf'],2);
}  

$totalDeduction = $payrollInformation['cash_advance'] + $payrollInformation['other_deductions'];
$totalDeduction += $payrollInformation['employee_cpf'];

$nettPay = $totalEarning - $totalDeduction;
$totalCpf = $nettPay + $payrollInformation['employer_cpf'];

?>
    
<div class="invoice-box page">
<table cellpadding="0" cellspacing="0">

<tr class="top">
<td colspan="2">

    <table>
        <tr>
            <td style="width: 50%;" class="title">
                <div style="text-align: left">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="images/dashboard/logo.png" class="receiptLogo">
                        </div>
                        <div style="width: 60%;" class="col-md-8">
                            <div class="row psBranchContainer" >
                                <div class="col-md-12 psBranchName">
                                    <b> ARH GROUP PTE LTD. </b>
                                </div>
                                <div class="col-md-12 psAddressInfo">
                                    Blk 8 Marsiling Industrial Estate Road 3#01-14 Singapore 739252
                                </div>
                                <div class="col-md-12 psContactnoInfo">
                                    Helpline : 6100 2183
                                </div>
                                <div class="col-md-12 psFaxInfo">
                                    Fax : (65) 63657024
                                </div>
                                <div class="col-md-12 psEmailInfo">
                                    Email : sales@arh-group.com.sg 
                                </div>
                                <div class="col-md-12 psWebsiteInfo">
                                    Web : www.arh-group.com.sg
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            
            <td style="width: 50%; ">
                    <div class="row PayslipInfoLabel" >
                     
                     <div class="col-md-12 psInfoAlign"><b>PAYSLIP</b></div>
                     <br/>

                     <div class="col-md-5">
                         
                         <div class="col-md-12 psPayslipNo psInfoAlign"><b>Payslip No </b></div>
                         <br/>

                         <div class="col-md-12 psPayslipMonth psInfoAlign"><b>Payslip Month </b></div>
                         <br/>

                         <div class="col-md-12 psDateIssue psInfoAlign"><b>Issue Date</b></div>
                         <br/>

                         <div class="col-md-12 psDept psInfoAlign"><b>Dept.</b></div>
                         <br/>

                         <div class="col-md-12 psJobTitle psInfoAlign"><b>Job Title</b></div>
                         <br/>

                         <div class="col-md-12 psNationality psInfoAlign"><b>Nationality</b></div>
                         <br/>

                         <div class="col-md-12 psGender psInfoAlign"><b>Gender</b></div>

                     </div>
                     
                     <div class="col-md-7">
                         
                         <div class="col-md-12 psPayslipNo">
                            : &nbsp; <?= Html::encode($payrollInformation['payslip_no']) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 psPayslipMonth">
                            : &nbsp; <?= Html::encode($payrollInformation['payslip_cutoff']) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 psDateIssue">
                            : &nbsp; <?= Html::encode(date('d-M-Y', strtotime($payrollInformation['date_issue']))) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 psDept">
                            : &nbsp; <?= Html::encode($payrollInformation['staffgroupName']) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 psJobTitle">
                            : &nbsp; <?= Html::encode($payrollInformation['positionName']) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 psNationality">
                            : &nbsp; <?= Html::encode($payrollInformation['raceName']) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 psGender">
                            : &nbsp; <?= Html::encode($payrollInformation['gender']) ?> 
                         </div>
        
                     </div>
   
                    </div>
            </td>
        </tr>

        <tr >
            <td class="title">
                <div style="text-align: left">
                    <div class="row psStaffContainer">
                            <div class="col-md-6 psEmpCode">
                                <b>Employee Code</b> 
                            </div>
                            <div class="col-md-6 psEmpCodeAlign psEmpCode">
                                : &nbsp; <?= Html::encode($payrollInformation['staff_code']) ?>
                            </div>
                            <div class="col-md-6 psEmpIcWidth psEmpIc">
                                <b>Employess NRIC/FIN</b> 
                            </div>
                            <div class="col-md-6 psEmpIcAlign psEmpIc">
                                : &nbsp; <?= Html::encode($payrollInformation['ic_no']) ?>
                            </div>
                            <div class="col-md-6 psEmpName">
                                <b>Employess Name</b> 
                            </div>                            
                            <div class="col-md-6 psEmpNameAlign psEmpName">
                                : &nbsp; <?= Html::encode($payrollInformation['staffName']) ?>
                            </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table>
        <tr><td><hr class="hrLine" /></td></tr>
    </table>
</td>
</tr>

<tr class="top">
<td colspan="2">

    <table style="margin-top: -30px;">
        <tr>
            <td class="title">
                <div>
                    <div class="row">
                        <div class="col-md-12 pull-left">
                            <h5 class="psHeaders"> EARNING </h4>
                        </div>
                        <br/>
                        <div class="col-md-6 psEarningLabelsWidth">
                            <div class="row psEarningContainer" >
                                <div class="col-md-12 psStandardPay">
                                    Standard Pay
                                </div>
                                <div class="col-md-12 psOtHour">
                                    OT Hour
                                </div>
                                <div class="col-md-12 psOtRatePerHour">
                                    OT Rate Per Hour
                                </div>
                                <div class="col-md-12 psOtPay">
                                    OT Pay
                                </div>
                                <div class="col-md-12 psAllowance">
                                    Allowance
                                </div>
                                <div class="col-md-12 psNonTaxAllowance">
                                    Non Tax Allowance
                                </div>
                                <div class="col-md-12 psTotalEarning">
                                    <b>TOTAL EARNING</b> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 psEarningValueWidth">
                            <div class="row psEarningContainer" >
                                <div class="col-md-12 psStandardPay">
                                    : &nbsp; $<?= Html::encode($standardPay) ?>
                                </div>
                                <div class="col-md-12 psOtHour">
                                    : &nbsp; $<?= Html::encode($overtimeHour) ?>
                                </div>
                                <div class="col-md-12 psOtRatePerHour">
                                    : &nbsp; $<?= Html::encode($overtimeRatePerHour) ?>
                                </div>
                                <div class="col-md-12 psOtPay">
                                    : &nbsp; $<?= Html::encode($overtimePay) ?>
                                </div>
                                <div class="col-md-12 psAllowance">
                                    : &nbsp; $<?= Html::encode($allowance) ?>
                                </div>
                                <div class="col-md-12 psNonTaxAllowance">
                                    : &nbsp; $<?= Html::encode($nonTaxAllowance) ?>
                                </div>
                                <div class="col-md-12 psTotalEarning">
                                    : &nbsp; $<?= Html::encode(number_format($totalEarning,2)) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            
            <td style="width: 45%">
                <div class="row">
                    <div class="col-md-12 pull-left">
                        <h5 class="psHeaders"> DEDUCTIONS </h5> 
                    </div>
                    <br/>
                    <div class="col-md-7 psDeductionLabelsWidth">
                        <div class="row psDeductionContainer" >
                            <div class="col-md-12 psCashAdvance">
                                Cash Advance
                            </div>
                            <div class="col-md-12 psOtherDeduction">
                                Other Deduction 
                            </div>
                            <div class="col-md-12 psEmployeeCpf">
                                Employee CPF(15.00%)
                            </div>
                            <div class="col-md-12 psTotalDeduction">
                                <b>TOTAL DEDUCTION</b> 
                            </div>
                            <div class="col-md-12 psNettPay">
                                <b>NETT PAY</b> 
                            </div>
                            <div class="col-md-12 psLEmployerCpf">
                                <b>Employer CPF(12.5%)</b>
                            </div>
                            <div class="col-md-12 psLTotalCpf">
                                <b>Total CPF</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 psDeductionValueWidth">
                        <div class="row psEarningContainer" >
                            <div class="col-md-12 psCashAdvance">
                                : &nbsp; $<?= Html::encode($cashAdvance) ?>
                            </div>
                            <div class="col-md-12 psOtherDeduction">
                                : &nbsp; $<?= Html::encode($otherDeductions) ?>
                            </div>
                            <div class="col-md-12 psEmployeeCpf">
                                : &nbsp; $<?= Html::encode($employeeCpf) ?>
                            </div>
                            <div class="col-md-12 psTotalDeduction">
                                : &nbsp; $<?= Html::encode(number_format($totalDeduction,2)) ?>
                            </div>
                            <div class="col-md-12 psNettPay">
                                : &nbsp; $<?= Html::encode(number_format($nettPay,2)) ?>
                            </div>
                            <div class="col-md-12 psLEmployerCpf">
                                : &nbsp; $<?= Html::encode($employerCpf) ?>
                            </div>
                            <div class="col-md-12 psLTotalCpf">
                                : &nbsp; $<?= Html::encode(number_format($totalCpf,2)) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table>
        <tr><td><hr class="hrLine" /></td></tr>
    </table>

</td>
</tr>

<tr class="top">
<td colspan="2">

    <table style="margin-top: -30px;">
        <tr>
            <td class="title">
                <div>
                    <div class="row">
                        <div class="col-md-12 pull-left">
                            <h5 class="psHeaders"> NOTES : </h5>
                        </div> 
                        <div class="col-md-12 pull-left">
                            <div class="psNotesContainer">
                                <div class="psNotesContent">
                                    <?= Html::encode($payrollInformation['remarks']) ?>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </td>
            
            <td style="width: 35%">
                <div>
                    <div class="row">
                        <div class="col-md-11 pull-right">
                            <div style="margin-top: 75px;">
                                <hr class="hrLine" />
                            </div>
                        </div>
                        <div class="col-md-11 pull-right">
                            <div class="psReceiverContent">
                                Receiver Signature 
                                <br/>
                                Date:
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

</td>
</tr>

</table>
</div>

<!-- Print Buttons -->   
<div class="row">
    <div class="col-xs-12">
        <div style="text-align: center">
            <button class="form-btn btn btn-info btn-xs print-buttons" id="printLocalPayslip" onclick="payslipLocalPrint()" ><i class="fa fa-print"></i> Print </button>
       
            <button class="form-btn btn btn-danger btn-xs print-buttons closeLocalPrint" id="closeLocalPrint"><i class="fa fa-close"></i> Close </button>
      
        </div>
    </div>
</div>

<br/>
