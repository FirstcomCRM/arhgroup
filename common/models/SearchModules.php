<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Modules;
use yii\db\Query;

/**
 * SearchModules represents the model behind the search form about `common\models\Modules`.
 */
class SearchModules extends Modules
{
    public $Role;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['modules'], 'safe'],
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
        $query = Modules::find();

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

        $query->andFilterWhere(['like', 'modules', $this->modules]);

        return $dataProvider;
    }

    // Search box result
    public function searchModuleName($module) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('modules')
                    ->where(['like', 'modules', $module])
                    ->andWhere(['status' => 1])
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getModules($modules) 
    {
       $rows = new Query();
    
       $result = $rows->select(['modules'])
        ->from('modules')
        ->where(['modules' => $modules])
        ->andWhere(['status' => 1])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }
}
