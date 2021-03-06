<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DesignatedPosition;

use yii\db\Query;

/**
 * SearchDesignatedPosition represents the model behind the search form about `common\models\DesignatedPosition`.
 */
class SearchDesignatedPosition extends DesignatedPosition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['name', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = DesignatedPosition::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    // Search box result.
    public function searchPositionName($name) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('designated_position')
                    ->where(['like', 'name', $name])
                    ->andWhere('id > 1')
                    ->andWhere('status = 1')
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getPosition($name) 
    {
       $rows = new Query();
    
       $result = $rows->select(['name'])
        ->from('designated_position')
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
