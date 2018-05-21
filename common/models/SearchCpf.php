<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cpf;

use yii\db\Query;

/**
 * SearchCpf represents the model behind the search form about `common\models\Cpf`.
 */
class SearchCpf extends Cpf
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from_age', 'to_age', 'employee_cpf', 'employer_cpf', 'status', 'created_by', 'updated_by'], 'integer'],
            [['description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Cpf::find()->where(['status' => 1]);

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
            'from_age' => $this->from_age,
            'to_age' => $this->to_age,
            'employee_cpf' => $this->employee_cpf,
            'employer_cpf' => $this->employer_cpf,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    // Search box result.
    public function SearchCpfAge($fromAge,$toAge) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('cpf')
                    ->where("from_age <= '$fromAge'")
                    ->andWhere("to_age >= '$toAge'")
                    ->andWhere(['status' => 1])
                    ->all();

        return $result;  
    }

}
