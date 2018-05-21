<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Staff;

use yii\db\Query;
/**
 * SearchStaff represents the model behind the search form about `common\models\Staff`.
 */
class SearchStaff extends Staff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staff_group_id', 'designated_position_id', 'contact_number', 'status', 'created_by', 'updated_by'], 'integer'],
            [['staff_code', 'fullname', 'address', 'email', 'basic', 'ic_no', 'rate_per_hour', 'allowance', 'created_at', 'updated_at'], 'safe'],
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
        $query = Staff::find();

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
            'status' => $this->status,
            'address' => $this->address,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'basic' => $this->basic,
            'ic_no' => $this->ic_no,
            'rate_per_hour' => $this->rate_per_hour,
            'allowance' => $this->allowance,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'staff_code', $this->staff_code])
            ->andFilterWhere(['like', 'fullname', $this->fullname]);

        return $dataProvider;
    }

    // Search box result.
    public function searchStaffName($name) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('staff')
                    ->where(['like', 'fullname', $name])
                    ->andWhere(['status' => 1])
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getStaff($name) 
    {
       $rows = new Query();
    
       $result = $rows->select(['fullname'])
        ->from('staff')
        ->where(['fullname' => $name])
        ->andWhere(['status' => 1])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

    // get Staff Lists.
    public function getStaffListById($id) 
    {
       $rows = new Query();
    
       $result = $rows->select(['staff.*', 'staff_group.name'])
        ->from('staff')
        ->join('LEFT JOIN', 'staff_group', 'staff.staff_group_id = staff_group.id')
        ->where(['staff.id' => $id])
        ->andWhere(['staff.status' => 1])
        ->one();
        
        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }
    }

    // get id
    public function getStaffId() 
    {
        $rows = new Query();

        $result = $rows->select(['Max(id) as staff_id'])
                        ->from('staff')
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['staff_id'] + 1;
        
        }else {
            return 0;
        
        }                
    }
}
