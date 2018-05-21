<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductNotificationRecipient;

use yii\db\Query;

/**
 * SearchProductNotificationRecipient represents the model behind the search form about `common\models\ProductNotificationRecipient`.
 */
class SearchProductNotificationRecipient extends ProductNotificationRecipient
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['email', 'created_at', 'updated_at'], 'safe'],
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
        $query = ProductNotificationRecipient::find();

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

        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

    // Search box result.
    public function searchEmailRecipient($email) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('product_notification_recipient')
                    ->where(['like', 'email', $email])
                    ->andWhere(['status' => 1])
                    ->all();

        return $result;  
    }

    // Search if with same email.
    public function getEmailRecipient($email) 
    {
       $rows = new Query();
    
       $result = $rows->select(['email'])
        ->from('product_notification_recipient')
        ->where(['email' => $email])
        ->andWhere(['status' => 1])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }
}
