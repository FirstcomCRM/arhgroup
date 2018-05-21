<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InvoiceDetail;

/**
 * SearchInvoiceDetail represents the model behind the search form about `common\models\InvoiceDetail`.
 */
class SearchInvoiceDetail extends InvoiceDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'invoice_id', 'service_part_id', 'quantity', 'created_by', 'type', 'task'], 'integer'],
            [['selling_price', 'subTotal'], 'number'],
            [['created_at'], 'safe'],
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
        $query = InvoiceDetail::find();

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
            'invoice_id' => $this->invoice_id,
            'service_part_id' => $this->service_part_id,
            'quantity' => $this->quantity,
            'selling_price' => $this->selling_price,
            'subTotal' => $this->subTotal,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'type' => $this->type,
            'task' => $this->task,
        ]);

        return $dataProvider;
    }
}
