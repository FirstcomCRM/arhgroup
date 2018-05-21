<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payroll".
 *
 * @property integer $id
 * @property string $payslip_no
 * @property string $payslip_cutoff
 * @property string $date_issue
 * @property integer $staff_id
 * @property string $overtime_hour
 * @property double $overtime_rate_per_hour
 * @property double $overtime_pay
 * @property double $employee_cpf
 * @property double $employer_cpf
 * @property double $cash_advance
 * @property double $other_deductions
 * @property double $monthly_levy_charge
 * @property string $remarks
 * @property string $prepared_by
 * @property string $approved_by
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $status
 */
class Payroll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payroll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payslip_cutoff', 'date_issue', 'staff_id', 'overtime_hour', 'overtime_rate_per_hour', 'overtime_pay', 'cash_advance', 'other_deductions'], 'required', 'message' => 'Fill-up required fields.'],
            [['payslip_no', 'payslip_cutoff', 'date_issue', 'prepared_by', 'approved_by', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'remarks', 'monthly_levy_charge', 'employee_cpf', 'employer_cpf'], 'safe'],
            [['staff_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['overtime_rate_per_hour', 'overtime_pay', 'cash_advance' ], 'number'],
            [['remarks'], 'string'],
            [['payslip_no', 'prepared_by', 'approved_by'], 'string', 'max' => 50],
            [['overtime_hour'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payslip_no' => 'Payslip No',
            'payslip_cutoff' => 'Payslip Cutoff',
            'date_issue' => 'Date Issue',
            'staff_id' => 'Staff ID',
            'overtime_hour' => 'Overtime Hour',
            'overtime_rate_per_hour' => 'Overtime Rate Per Hour',
            'overtime_pay' => 'Overtime Pay',
            'employee_cpf' => 'Employee Cpf',
            'employer_cpf' => 'Employer Cpf',
            'cash_advance' => 'Cash Advance',
            'other_deductions' => 'Other Deductions',
            'monthly_levy_charge' => 'Monthly Levy Charge',
            'remarks' => 'Remarks',
            'prepared_by' => 'Prepared By',
            'approved_by' => 'Approved By',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
