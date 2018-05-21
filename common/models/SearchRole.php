<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Role;
use yii\db\Query;
/**
 * SearchRole represents the model behind the search form about `common\models\Role`.
 */
class SearchRole extends Role
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['role'], 'safe'],
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
        $query = Role::find();

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

        $query->andFilterWhere(['like', 'role', $this->role]);

        return $dataProvider;
    }

    // Search box result.
    public function searchRoleName($role) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('role')
                    ->where(['like', 'role', $role])
                    ->andWhere('id > 1')
                    ->andWhere(['status' => 1])
                    ->all();

        return $result;            
    }

    // Search if with same name.
    public function getRole($role) 
    {
       $rows = new Query();
    
       $result = $rows->select(['role'])
        ->from('role')
        ->where(['role' => $role])
        ->andWhere(['status' => 1])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

}
