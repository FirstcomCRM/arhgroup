<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Quotation;
use yii\db\Query;

/**
 * SearchQuotation represents the model behind the search form about `common\models\Quotation`.
 */
class SearchQuotation extends Quotation
{
    public $date_from;
    public $date_to;
    public $carplate;
    public $username;
    public $branch;
    public $cust_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'customer_id', 'branch_id', 'created_by', 'updated_by', 'delete', 'task', 'invoice'], 'integer'],
            [['quotation_code', 'date_issue', 'remarks', 'mileage', 'come_in', 'come_out', 'created_at', 'time_created', 'discount_remarks', 'updated_at', 'date_from', 'date_to', 'branch', 'username', 'carplate', 'cust_name'], 'safe'],
            [['grand_total', 'gst', 'net', 'discount_amount'], 'number'],
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
        $date_start = $date_end = "";

        $query = new Query;

        if(isset($params['date_from']) && $params['date_from']!='')
            $date_start = date('Y-m-d', strtotime($params['date_from']));

        if(isset($params['date_to']) && $params['date_to']!='')
            $date_end = date('Y-m-d', strtotime($params['date_to']));

        $query->select('quo.id, quo.quotation_code, quo.date_issue, b.name as branch_name, u.username, ci.carplate, c.fullname,ci.customer_id,(CASE WHEN c.company_name is null OR c.company_name="" THEN c.fullname ELSE c.company_name end) as name,quo.invoice') 
                ->from('quotation quo')
                ->innerjoin('branch b', 'b.id=quo.branch_id')
                ->innerjoin('user u', 'u.id=quo.user_id')
                ->innerjoin('car_information ci', 'ci.id=quo.customer_id')
                ->innerjoin('customer c', 'c.id=ci.customer_id')
                ->where(['quo.delete'=>0])
                ->orderBy(['quo.id'=> SORT_DESC]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions

        if(isset($params['date_from']))
        {
            if($date_start!='' && $date_end!='')
                $query->andFilterWhere(['between', 'date_issue', $date_start, $date_end]);
            else if($date_start=='' && $date_end!='')
                $query->andFilterWhere(['<=', 'date_issue', date('Y-m-d', strtotime($date_end)).' 23:59:59']);
            else if($date_start!='' && $date_end=='')
                $query->andFilterWhere(['>=', 'date_issue', date('Y-m-d', strtotime($date_start)).' 00:00:00']);

            $query->andFilterWhere(['like', 'quotation_code', $params['quotation_code']])
            ->andFilterWhere(['like', 'carplate', $params['carplate']])
            ->andFilterWhere(['u.id' => $params['username']])
            ->andFilterWhere(['b.id' => $params['branch']])
            ->andFilterWhere(['like', 'CONCAT(c.fullname, " ",IFNULL(c.company_name,""))', $params['cust_name']]);
        }

        // echo $query->createCommand()->getRawSql();exit;
        return $dataProvider;
    }

     // get id
    public static function getQuotationId() 
    {
        $rows = new Query();

        $result = $rows->select(['Max(id) as quotation_id'])
                        ->from('quotation')
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['quotation_id'] + 1;
        
        }else {
            return 0;
        
        }                
    }

    // get product by category
    // get product by category
    public static function getPartsByCategory($id)
    {
        $rows= new Query();

        $result = $rows->select(['product.id', 'supplier.supplier_name', 'product.product_name', 'product.quantity', 'product.selling_price'])
            ->from('product')
            ->join('INNER JOIN', 'category', 'product.category_id = category.id')
            ->join('INNER JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where(['product.category_id' => $id])
            ->all();

        return $result;
    }

    // getProcessedQuotation
    public static function getProcessedQuotation($quotationId) 
    {
        $rows = new Query();

        
        $result = $rows->select([
                                'quotation.id',
                                'quotation.quotation_code',
                                'user.fullname as salesPerson',
                                'customer.fullname',
                                'customer.address as customerAddress',
                                'customer.hanphone_no',
                                'customer.office_no',
                                'car_information.carplate',
                                'customer.race_id',
                                'race.name as raceName',
                                'customer.email',
                                'car_information.make',
                                'car_information.model',
                                'car_information.points',
                                'branch.id as BranchId',
                                'branch.code',
                                'branch.name',
                                'branch.address',
                                'branch.contact_no as branchNumber',
                                'branch.`email` as brEmail',
                                'branch.fax',
                                'branch.uen_no as branch_uen_no',
                                'branch.gst_no as branch_gst_no',
                                'quotation.customer_id',
                                'quotation.user_id',
                                'quotation.branch_id',
                                'quotation.date_issue',
                                'quotation.remarks',
                                'quotation.grand_total',
                                'quotation.gst',
                                'quotation.net',
                                'quotation.mileage',
                                'quotation.task',
                                'quotation.invoice',
                                'quotation.created_at',
                                'quotation.created_by',
                                'quotation.updated_at',
                                'quotation.updated_by',
                                'quotation.delete',
                                'quotation.time_created',
                                'quotation.come_in',
                                'quotation.come_out',
                                'customer.type',
                                'customer.company_name',
                                'customer.uen_no',
                                'customer.nric',
                                'car_information.engine_no',
                                'car_information.chasis',
                                'car_information.year_mfg',
                                'quotation.discount_amount',
                                'quotation.discount_remarks'
                            ])
                ->from('quotation')
                ->join('LEFT JOIN', 'user', 'quotation.user_id = user.id')
                ->join('LEFT JOIN', 'branch', 'quotation.branch_id = branch.id')
                ->join('LEFT JOIN', 'car_information', 'quotation.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
                ->where(['quotation.id' => $quotationId])
                ->one();
                // echo "<pre>";
                // var_dump($result);exit;
        return $result;
    }

    // getProcesssedServices
    public static function getProcessedServices($id) 
    {
        $service = QuotationDetail::find()->where(['quotation_id' => $id, 'type' => 0])->all();

        return $service;
    }

    // getProcessedParts
    public static function getProcessedParts($id) 
    {
        $rows = new Query();

        $part = $rows->select(['quotation_detail.id', 'product.product_name', 'quotation_detail.quantity', 'quotation_detail.selling_price', 'quotation_detail.subTotal'])
            ->from('quotation_detail')
            ->join('INNER JOIN', 'product', 'quotation_detail.service_part_id = product.id')
            ->where(['quotation_detail.quotation_id' => $id, 'quotation_detail.type' => 1])
            ->all();

        return $part;
    }

    // getProcessedQuotationbyId
    public static function getProcessedQuotationbyId($id) 
    {
        $rows = new Query();

        $result = $rows->select(['quotation.id', 'quotation.quotation_code', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'car_information.carplate', 'customer.race_id', 'race.name as raceName', 'customer.email', 'car_information.make', 'car_information.model', 'car_information.points', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'quotation.customer_id', 'quotation.user_id', 'quotation.branch_id', 'quotation.date_issue', 'quotation.remarks', 'quotation.grand_total', 'quotation.gst', 'quotation.net', 'quotation.mileage', 'quotation.task', 'quotation.invoice', 'quotation.created_at', 'quotation.created_by', 'quotation.updated_at', 'quotation.updated_by', 'quotation.delete', 'quotation.task', 'quotation.time_created', 'quotation.come_in', 'quotation.come_out', 'customer.type', 'customer.company_name', 'customer.uen_no', 'customer.nric', 'car_information.engine_no', 'car_information.chasis', 'car_information.year_mfg', 'quotation.discount_amount', 'quotation.discount_remarks'])
            ->from('quotation')
            ->join('LEFT JOIN', 'user', 'quotation.user_id = user.id')
            ->join('LEFT JOIN', 'branch', 'quotation.branch_id = branch.id')
            ->join('LEFT JOIN', 'car_information', 'quotation.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
            ->where(['quotation.id' => $id])
            ->one();

        return $result;
    }

    // getLastId
    public static function getLastId($id) 
    {
        $rows= new Query();

        $lastId = $rows->select(['max(id) as id'])
                    ->from('quotation_detail')
                    ->where(['quotation_id' => $id ])
                    ->one();

        return $lastId['id'];
    }

    // get Quotation
    public static function getQuotation() 
    {
        $rows = new Query();

        $result = $rows->select(['quotation.id', 'quotation.quotation_code', 'user.fullname as salesPerson', 'customer.fullname','customer.company_name', 'branch.code', 'branch.name', 'quotation.date_issue', 'quotation.task', 'quotation.invoice', 'car_information.carplate','invoice.paid'])
            ->from('quotation')
            ->join('LEFT JOIN', 'user', 'quotation.user_id = user.id')
            ->join('LEFT JOIN', 'car_information', 'quotation.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->join('LEFT JOIN', 'branch', 'quotation.branch_id = branch.id')
            ->join('LEFT JOIN', 'invoice', 'quotation.quotation_code = invoice.quotation_code')
            ->where('quotation.delete = 0')
            ->all();

        return $result;
    }
}
