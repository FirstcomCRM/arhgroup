<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PaymentType;

use yii\db\Query;
/**
 * SearchPaymentType represents the model behind the search form about `common\models\PaymentType`.
 */
class SearchPaymentType extends PaymentType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'interest', 'created_at', 'updated_at'], 'safe'],
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
        $query = PaymentType::find();

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
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    // Search box result.
    public function searchPaymentTypeName($name) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('payment_type')
                    ->where(['like', 'name', $name])
                    ->andWhere(['status' => 1])
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getPaymentType($name) 
    {
       $rows = new Query();
    
       $result = $rows->select(['name'])
        ->from('payment_type')
        ->where(['name' => $name])
        ->andWhere(['status' => 1])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }
}
