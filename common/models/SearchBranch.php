<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Branch;
use yii\db\Query;

/**
 * SearchBranch represents the model behind the search form about `common\models\Branch`.
 */
class SearchBranch extends Branch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name', 'address', 'contact_no', 'created_at', 'updated_at'], 'safe'],
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
        $query = Branch::find();

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
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no]);

        return $dataProvider;
    }

    // Search box result.
    public function searchBranchName($name) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('branch')
                    ->where(['like', 'name', $name])
                    ->andWhere('id > 1')
                    ->andWhere('status = 1')
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getBranch($name) 
    {
       $rows = new Query();
    
       $result = $rows->select(['name'])
        ->from('branch')
        ->where(['name' => $name])
        ->andWhere(['status' => 1])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

    public function getBranchExceptId($id) 
    {
       $rows = new Query();
    
       $result = $rows->select(['*'])
        ->from('branch')
        ->where(['!=', 'id', $id])
        ->andWhere(['status' => 1])
        ->all();
        
        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }
    }

}