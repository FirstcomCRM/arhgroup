<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserPermission;
use yii\db\Query;

/**
 * SearchUserPermission represents the model behind the search form about `common\models\UserPermission`.
 */
class SearchUserPermission extends UserPermission
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_id'], 'integer'],
            [['controller', 'action'], 'safe'],
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
        $query = UserPermission::find();

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
            'role_id' => $this->role_id,
        ]);

        $query->andFilterWhere(['like', 'controller', $this->controller])
            ->andFilterWhere(['like', 'action', $this->action]);

        return $dataProvider;
    }

    // Search box result
    public function searchUserPermissionNames($role_id,$controller,$action) {
        $rows = new Query();

        $result = $rows->select(['user_permission.id', 'role.role', 'user_permission.controller', 'user_permission.action', 'user_permission.role_id'])
            ->from('user_permission')
            ->join('INNER JOIN', 'role', 'user_permission.role_id = role.id')
            ->where('user_permission.role_id > 1')
            ->andWhere(['user_permission.status' => 1])
            ->andWhere(['like', 'user_permission.role_id', $role_id])
            ->andWhere(['like', 'user_permission.controller', $controller])
            ->andWhere(['like', 'user_permission.action', $action])
            ->all();

        return $result;            
    }

    public function getUserPermission() {
        $rows = new Query();

        $result = $rows->select(['user_permission.id', 'role.role', 'user_permission.controller', 'user_permission.action', 'user_permission.role_id'])
            ->from('user_permission')
            ->join('INNER JOIN', 'role', 'user_permission.role_id = role.id')
            ->where('user_permission.role_id > 1')
            ->andWhere(['user_permission.status' => 1])
            ->all();

        if( count($result) > 0 ) {
            return $result;

        }else{
            return 0;

        }   

    }
}
