<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cdac;

/**
 * SearchCdac represents the model behind the search form about `common\models\Cdac`.
 */
class SearchCdac extends Cdac
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cdac_id', 'from_salary', 'to_salary', 'minimum_monthly_contribution', 'status', 'created_by', 'updated_by'], 'integer'],
            [['date_time_created', 'updated_at'], 'safe'],
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
        $query = Cdac::find();

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
            'cdac_id' => $this->cdac_id,
            'from_salary' => $this->from_salary,
            'to_salary' => $this->to_salary,
            'minimum_monthly_contribution' => $this->minimum_monthly_contribution,
            'status' => $this->status,
            'date_time_created' => $this->date_time_created,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }

     public function SearchCdacSalary($fromSalary,$toSalary) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('cdac')
                    ->where("from_salary <= '$fromSalary'")
                    ->andWhere("to_salary >= '$toSalary'")
                    ->andWhere(['status' => 1])
                    ->all();

        return $result;  
    }
}
