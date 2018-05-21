<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Payroll;

use yii\db\Query;

/**
 * SearchPayroll represents the model behind the search form about `common\models\Payroll`.
 */
class SearchPayroll extends Payroll
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['payslip_no', 'date_issue', 'overtime_hour', 'remarks', 'prepared_by', 'approved_by', 'created_at', 'updated_at'], 'safe'],
            [['overtime_rate_per_hour', 'overtime_pay', 'employee_cpf', 'employer_cpf', 'cash_advance', 'other_deductions', 'monthly_levy_charge'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Payroll::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'date_issue' => $this->date_issue,
            'overtime_rate_per_hour' => $this->overtime_rate_per_hour,
            'overtime_pay' => $this->overtime_pay,
            'employee_cpf' => $this->employee_cpf,
            'employer_cpf' => $this->employer_cpf,
            'cash_advance' => $this->cash_advance,
            'other_deductions' => $this->other_deductions,
            'monthly_levy_charge' => $this->monthly_levy_charge,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'payslip_no', $this->payslip_no])
            ->andFilterWhere(['like', 'overtime_hour', $this->overtime_hour])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'prepared_by', $this->prepared_by])
            ->andFilterWhere(['like', 'approved_by', $this->approved_by]);

        return $dataProvider;
    }

    // Search box result.
    public function searchStaffName($staffId) 
    {
        $rows = new Query();

        $result = $rows->select(['payroll.*', 'staff.*'])
                    ->from('payroll')
                    ->join('INNER JOIN', 'staff', 'payroll.staff_id = staff.id')
                    ->where(['like', 'payroll.staff_id', $staffId])
                    ->andWhere(['payroll.status' => 1])
                    ->all();

        return $result;  
    }

    // get all payroll.
    public function getPayrolls() 
    {
        $rows = new Query();

        $result = $rows->select(['payroll.*', 'staff.*'])
                    ->from('payroll')
                    ->join('INNER JOIN', 'staff', 'payroll.staff_id = staff.id')
                    ->where(['payroll.status' => 1])
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getPayrollSameName($staffId,$payDate) 
    {
       $rows = new Query();
    
       $result = $rows->select(['staff_id'])
         ->from('payroll')
         ->where(['staff_id' => $staffId])
         ->andWhere(['pay_date' => $payDate])
         ->andWhere(['status' => 1])
         ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

    // get payroll by id.
    public function getPayrollById($id) 
    {
        $rows = new Query();

        $result = $rows->select(['payroll.*', 'staff.*'])
                    ->from('payroll')
                    ->join('INNER JOIN', 'staff', 'payroll.staff_id = staff.id')
                    ->where(['payroll.id' => $id])
                    ->andWhere(['payroll.status' => 1])
                    ->one();

        return $result;  
    }

    // get id
    public function getPayrollId() 
    {
        $rows = new Query();

        $result = $rows->select(['Max(id) as payroll_id'])
                        ->from('payroll')
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['payroll_id'] + 1;
        
        }else {
            return 0;
        
        }                
    }

    // get payroll information by id
    public function getPayrolInformationById($id) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payroll.id', 'payroll.payslip_no', 'payroll.payslip_cutoff', 'payroll.date_issue', 'payroll.staff_id', 'payroll.overtime_hour', 'payroll.overtime_rate_per_hour', 'payroll.overtime_pay', 'payroll.employee_cpf', 'payroll.employer_cpf', 'payroll.cash_advance', 'payroll.other_deductions', 'payroll.monthly_levy_charge', 'payroll.remarks', 'staff.staff_group_id', 'staff_group.name as staffgroupName', 'staff.designated_position_id', 'designated_position.name as positionName', 'staff.staff_code', 'staff.fullname as staffName', 'staff.ic_no', 'staff.gender', 'staff.rate_per_hour', 'staff.basic', 'staff.allowance', 'staff.non_tax_allowance', 'staff.levy_supplement', 'staff.race_id', 'race.name as raceName' ])
                    ->from('payroll')
                    ->leftJoin('staff', 'payroll.staff_id = staff.id')
                    ->leftJoin('staff_group', 'staff.staff_group_id = staff_group.id')
                    ->leftJoin('designated_position', 'staff.designated_position_id = designated_position.id')
                    ->leftJoin('race', 'staff.race_id = race.id')
                    ->where(['payroll.id' => $id])
                    ->one();
               
        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }                
    }

}
