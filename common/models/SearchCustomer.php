<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

use yii\db\Query;
/**
 * SearchCustomer represents the model behind the search form about `common\models\Customer`.
 */
class SearchCustomer extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {

        
        // , 'is_blacklist', 'is_member', created_by', 'updated_by'
        return [
            [['id'], 'integer'],
            [['fullname', 'role', 'nric', 'company_name', 'uen_no', 'password', 'password_hash', 'auth_key', 'race_id', 'address', 'hanphone_no', 'office_no', 'email', 'remarks', 'join_date', 'member_expiry', 'status', 'type', 'is_blacklist', 'is_member', 'created_by', 'created_at', 'updated_at', 'deleted'], 'safe'],
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
        $query = Customer::find();

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
            'is_blacklist' => $this->is_blacklist,
            'is_member' => $this->is_member,
            'join_date' => $this->join_date,
            'member_expiry' => $this->member_expiry,
            'status' => $this->status,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'race_id', $this->race_id])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'hanphone_no', $this->hanphone_no])
            ->andFilterWhere(['like', 'office_no', $this->office_no])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'uen_no', $this->uen_no])
            ->andFilterWhere(['like', 'nric', $this->nric])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }

    // Search box result
    public static function searchCustomerFullname($fullname) 
    {
        $rows = new Query();

        $result = $rows->select(['customer.*', 'race.name' ])
                    ->from('customer')
                    ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
                    ->where(['LIKE', 'customer.fullname', $fullname])
                    ->orWhere(['LIKE', 'customer.company_name', $fullname])
                    ->all();

        return $result;            
    }

    // get customer quotation by search
    public static function getCustomerQuotationBySearch($keyword) 
    {
        $rows = new Query();

        $result = $rows->select([ 'quotation.id as quotationId', 'quotation.quotation_code as quotationCode', 'quotation.user_id', 'user.fullname as salesPerson', 'quotation.customer_id', 'customer.fullname as customerName', 'car_information.carplate', 'quotation.branch_id', 'branch.name', 'quotation.date_issue', 'quotation.grand_total', 'quotation.remarks as quotationRemarks', 'quotation_detail.id as quotationDetailId', 'quotation_detail.service_part_id', 'category.category', 'product.product_name', 'inventory.selling_price', 'quotation_detail.quantity', 'quotation_detail.selling_price as quotationPartsPrice', 'quotation_detail.subTotal' ])
                ->from('quotation')
                ->join('LEFT JOIN', 'user', 'quotation.user_id = user.id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->join('LEFT JOIN', 'branch', 'quotation.branch_id = branch.id')
                ->join('LEFT JOIN', 'quotation_detail', 'quotation.id = quotation_detail.quotation_id')
                ->join('LEFT JOIN', 'inventory', 'quotation_detail.service_part_id = inventory.id')
                ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
                ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
                ->where(['LIKE', 'customer.fullname', $keyword ])
                ->orWhere(['LIKE', 'car_information.carplate', $keyword ])
                ->orWhere(['LIKE', 'product.product_name',  $keyword ])
                ->orderBy('date_issue','desc')
                ->all();

        return $result;
    }

    // get customer invoice by search
    public static function getCustomerInvoiceBySearch($keyword) 
    {
        $rows = new Query();
            $result = $rows->select([ 
                    'invoice.id',
                    'invoice.invoice_no',
                    'user.fullname as salesPerson',
                    'customer.fullname',
                    'car_information.carplate',
                    'car_information.chasis',
                    'car_information.engine_no',
                    'car_information.make',
                    'car_information.model',
                    'product.product_name',
                    'invoice_detail.service_part_id',
                    'invoice_detail.selling_price',
                    'invoice_detail.quantity',
                    'invoice_detail.subTotal',
                    'invoice.date_issue',
                    'invoice.paid',
                    'invoice.paid_type',
                    'customer.type',
                    'customer.company_name' ])
                ->from('invoice_detail')
                ->join('LEFT JOIN', 'invoice', 'invoice_detail.invoice_id = invoice.id')
                // ->join('LEFT JOIN', 'inventory', 'invoice_detail.service_part_id = inventory.id')
                ->join('LEFT JOIN', 'product', 'invoice_detail.service_part_id = product.id')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where(['LIKE', 'customer.fullname', $keyword ]) 
                ->orWhere(['LIKE', 'customer.company_name', $keyword ]) 
                ->orWhere(['LIKE', 'car_information.carplate', $keyword ]) 
                ->orWhere(['LIKE', 'invoice.invoice_no', $keyword ])
                ->orWhere(['LIKE', 'car_information.make', $keyword ])
                ->orWhere(['LIKE', 'car_information.model', $keyword ])
                ->orWhere(['LIKE', 'car_information.chasis', $keyword ])
                ->orWhere(['LIKE', 'car_information.engine_no', $keyword ])
                ->orWhere(['LIKE', 'invoice_detail.service_part_id', $keyword ])
                ->orWhere(['LIKE', 'product.product_name', $keyword ])
                ->orWhere(['LIKE', 'invoice.invoice_no', $keyword ])
                ->orderBy(['date_issue' => SORT_DESC])
                ->all();

                /*
                    car plate 
                    customer name
                    inv 号码
                    car make
                    car model
                    Service description
                    product name
                    Engine number 
                    chasis


                */

        return $result;
    }

    // get customer redeem points
    public static function getRedeemPoints($id) 
    {
        $rows = new Query();

        $result = $rows->select(['id', 'invoice_no', 'points_redeem', 'payment_date', 'payment_time'])
                    ->from('payment')
                    ->where(['customer_id' => $id])
                    ->all();

        return $result;
    }

    // get customer by id
    public static function getCustomerById($id) 
    {
        $rows = new Query();

        $result = $rows->select(['customer.*', 'race.name' ])
                    ->from('customer')
                    ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
                    ->where(['customer.id' => $id])
                    ->one();

        return $result;            
    }

    public static function getCarLastId($id)
    {
        $rows = new Query();

        $result = $rows->select(['MAX(car_information.id) as lastId'])
                    ->from('car_information')
                    ->where(['car_information.customer_id' => $id])
                    ->one();

        return $result;  
    }

    // get customer list
    public static function getCustomerList() 
    {
        $rows = new Query();

        $result = $rows->select(['customer.*', 'race.name' ])
                    ->from('customer')
                    ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
                    ->where(['customer.is_blacklist' => 0, 'customer.status' => 1,'customer.deleted' => 0])
                    ->all();

        return $result;            
    }

    // get blacklisted customer list
    public static function getBlacklistCustomerList() 
    {
        $rows = new Query();

        $result = $rows->select(['customer.*', 'race.name' ])
                    ->from('customer')
                    ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
                    ->where(['customer.is_blacklist' => 1, 'customer.status' => 1])
                    ->all();

        return $result;            
    }

    // get customer list by id
    public static function getCustomerListById($id) 
    {
        $rows = new Query();

        $result = $rows->select(['customer.*', 'race.name'  ])
                    ->from('customer')
                    ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
                    ->where(['customer.id' => $id, 'customer.is_blacklist' => 0, 'customer.status' => 1])
                    ->one();
                
        return $result;            
    }

}
