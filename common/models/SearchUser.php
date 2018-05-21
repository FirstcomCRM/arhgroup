<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\db\Query;
/**
 * SearchUser represents the model behind the search form about `common\models\User`.
 */
class SearchUser extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role_id', 'branch_id', 'role', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['fullname', 'username', 'password', 'password_hash', 'password_reset_token', 'email', 'photo', 'auth_key', 'login', 'created_at', 'updated_at'], 'safe'],
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
        $query = User::find();

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
            'role' => $this->role,
            'status' => $this->status,
            'login' => $this->login,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key]);

        return $dataProvider;
    }

    // Search box result
    public function searchUserFullname($fullname) {
        $rows = new Query();

        $result = $rows->select(['user.id', 'role.role', 'branch.name', 'user.fullname', 'user.username', 'user.email', 'user.status'])
                    ->from('user')
                    ->join('INNER JOIN', 'role', 'user.role_id = role.id')
                    ->join('INNER JOIN', 'branch', 'user.branch_id = branch.id')
                    ->where(['like', 'user.fullname', $fullname])
                    ->andWhere('user.role_id > 1')
                    ->andWhere(['user.status' => 1])                    
                    ->all();

        return $result;            
    }

    // Search if with same user.
    public function getUsernameAndEmail($username, $email) {
        $rows = new Query();

        $result = $rows->select(['username','email'])
            ->from('user')
            ->where(['username' => $username])
            ->andWhere(['email' => $email])
            ->andWhere(['status' => 1])  
            ->all();
            
            if( count($result) > 0 ) {
                return TRUE;
            }else {
                return 0;
            }
    }
    
    public function getUser() {
        $rows = new Query();

        $result = $rows->select(['user.id', 'role.role', 'branch.name', 'user.fullname', 'user.username', 'user.email', 'user.status', 'user.created_at', 'user.updated_at'])
                    ->from('user')
                    ->join('INNER JOIN', 'role', 'user.role_id = role.id')
                    ->join('INNER JOIN', 'branch', 'user.branch_id = branch.id')
                    ->where('user.role_id > 1')
                    ->andWhere(['user.status' => 1])  
                    ->all();

        return $result;   
    }

    public function getUserById($id) {
        $rows = new Query();

        $result = $rows->select(['user.id', 'role.role', 'branch.name', 'user.fullname', 'user.username', 'user.email', 'user.status', 'user.created_at', 'user.updated_at'])
                    ->from('user')
                    ->join('INNER JOIN', 'role', 'user.role_id = role.id')
                    ->join('INNER JOIN', 'branch', 'user.branch_id = branch.id')
                    ->where('user.role_id > 1')
                    ->andWhere(['user.id' => $id])
                    ->andWhere(['user.status' => 1])  
                    ->one();

        return $result;   
    }

}
