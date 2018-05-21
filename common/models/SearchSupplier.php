<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Supplier;
use yii\db\Query;

/**
 * SearchSupplier represents the model behind the search form about `common\models\Supplier`.
 */
class SearchSupplier extends Supplier
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'contact_number'], 'integer'],
            [['supplier_code', 'supplier_name', 'address', 'contact_number'], 'safe'],
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
        $query = Supplier::find();

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
        ]);

        $query->andFilterWhere(['like', 'supplier_code', $this->supplier_code])
            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name]);

        return $dataProvider;
    }

    // Search box result
    public function searchSupplierName($supplier_name) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('supplier')
                    ->Where(['like', 'supplier_name', $supplier_name])
                    ->andWhere(['status' => 1])
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getSuppliers($supplier_name) 
    {
       $rows = new Query();
    
       $result = $rows->select(['supplier_name'])
        ->from('supplier')
        ->where(['supplier_name' => $supplier_name])
        ->andWhere(['status' => 1])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }
}
