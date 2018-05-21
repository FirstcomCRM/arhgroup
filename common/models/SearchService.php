<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Service;
use yii\db\Query;

/**
 * SearchService represents the model behind the search form about `common\models\Service`.
 */
class SearchService extends Service
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'service_category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['service_name', 'description', 'created_at', 'updated_at'], 'safe'],
            [['default_price'], 'number'],
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
        $query = Service::find();

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
            'service_category_id' => $this->service_category_id,
            'default_price' => $this->default_price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'service_name', $this->service_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    // Search box result.
    public function searchServiceName($service_category_id,$service_name) 
    {
        $rows = new Query();

        $result = $rows->select(['service.id','service.service_category_id','service_category.name','service.service_name','service.description','service.default_price','service.status','service.created_at','service.created_by'])
            ->from('service')
            ->join('INNER JOIN', 'service_category', 'service.service_category_id = service_category.id')
            ->where(['like', 'service.service_category_id', $service_category_id])
            ->orWhere(['like', 'service.service_name', $service_name])
            ->all();

        return $result;  
    }

    // get Service list
    public function getServices() 
    {
        $rows = new Query();

        $result = $rows->select(['service.id','service.service_category_id','service_category.name','service.service_name','service.description','service.default_price','service.status','service.created_at','service.created_by'])
            ->from('service')
            ->join('INNER JOIN', 'service_category', 'service.service_category_id = service_category.id')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }

    }

    // get Service same name
    public function getSameServices($service_category_id,$service_name) 
    {
        $rows = new Query();
        
        $result = $rows->select(['service_category_id', 'service_name'])
        ->from('service')
        ->where(['service_category_id' => $service_category_id])
        ->andWhere(['service_name' => $service_name])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

    // get pending invoice services for dashboard
    public function getPendingInvoiceServices() {
        $rows = new Query();

        $result = $rows->select([ 'invoice_detail.id', 'invoice.id as invoiceId', 'invoice.invoice_no', 'invoice.user_id', 'user.fullname as salesPerson', 'invoice.customer_id', 'customer.fullname', 'invoice.branch_id', 'branch.name', 'invoice.grand_total', 'invoice.date_issue', 'invoice_detail.id', 'invoice_detail.service_part_id', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal', 'customer.type', 'customer.company_name' ])
                ->from('invoice_detail')
                ->join('LEFT JOIN', 'invoice', 'invoice_detail.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'service', 'invoice_detail.service_part_id = service.id')
                ->where('invoice_detail.type = 0')
                ->andWhere('invoice_detail.task = 1')
                ->andWhere('invoice_detail.status = 0')
                ->orderBy(['invoice_detail.id' => SORT_DESC])
                ->all();

        return $result;
    }

    // get pending quotation services for customer-dashboard
    public function getPendingQuotationServicesByCustomer($id) {
        $rows = new Query();

        $result = $rows->select([ 'quotation_detail.id', 'quotation.id as quotationId', 'quotation.quotation_code', 'quotation.user_id', 'user.fullname as salesPerson', 'quotation.customer_id', 'customer.fullname', 'quotation.branch_id', 'branch.name', 'quotation.grand_total', 'quotation.date_issue', 'quotation_detail.id', 'quotation_detail.service_part_id', 'service.service_name', 'quotation_detail.quantity', 'quotation_detail.selling_price', 'quotation_detail.subTotal' ])
                ->from('quotation_detail')
                ->join('LEFT JOIN', 'quotation', 'quotation_detail.quotation_id = quotation.id')
                ->join('LEFT JOIN', 'user', 'quotation.user_id = user.id')
                ->join('LEFT JOIN', 'customer', 'quotation.customer_id = customer.id')
                ->join('LEFT JOIN', 'branch', 'quotation.branch_id = branch.id')
                ->join('LEFT JOIN', 'service', 'quotation_detail.service_part_id = service.id')
                ->where(['quotation.customer_id' => $id])
                ->andWhere('quotation_detail.type = 0')
                ->andWhere('quotation_detail.task = 1')
                ->andWhere('quotation_detail.invoice = 0')
                ->all();

        return $result;
    }

    // get pending invoice services for customer-dashboard
    public function getPendingInvoiceServicesByCustomer($id) {
        $rows = new Query();

        $result = $rows->select([ 'invoice_detail.id', 'invoice.id as invoiceId', 'invoice.invoice_no', 'invoice.user_id', 'user.fullname as salesPerson', 'invoice.customer_id', 'customer.fullname', 'invoice.branch_id', 'branch.name', 'invoice.grand_total', 'invoice.date_issue', 'invoice_detail.id', 'invoice_detail.service_part_id', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal' ])
                ->from('invoice_detail')
                ->join('LEFT JOIN', 'invoice', 'invoice_detail.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'customer', 'invoice.customer_id = customer.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'service', 'invoice_detail.service_part_id = service.id')
                ->where(['invoice.customer_id' => $id])
                ->andWhere('invoice_detail.type = 0')
                ->andWhere('invoice_detail.task = 1')
                ->andWhere('invoice_detail.status = 0')
                ->all();

        return $result;
    }
    
    // get Services By ID
    public function getServiceListById($id) 
    {
        $rows = new Query();

        $result = $rows->select(['service.id', 'service.service_category_id', 'service_category.name', 'service.service_name', 'service.default_price', 'service.created_at'])
            ->from('service')
            ->join('INNER JOIN', 'service_category', 'service.service_category_id = service_category.id')
            ->where(['service.id' => $id])
            ->orderBy('service.id')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }   
    }

}
