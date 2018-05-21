<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;
use yii\db\Query;

/**
 * SearchProduct represents the model behind the search form about `common\models\Product`.
 */
class SearchProduct extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'category_id', 'created_by'], 'integer'],
            [['product_code', 'product_name', 'product_image', 'unit_of_measure', 'created_at'], 'safe'],
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
        $query = Product::find();

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
            'status' => $this->status,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_image', $this->product_image])
            ->andFilterWhere(['like', 'unit_of_measure', $this->unit_of_measure]);

        return $dataProvider;
    }

    public function searchForIndex($params)
    {   
        $rows = new Query();

        $query = Product::find();
        // $query = $rows->select(['product.id', 'category.category', 'product.product_code', 'product.product_name', 'product.unit_of_measure', 'product.category_id', 'product.product_image', 'product.status', 'product.created_at', 'product.created_by'])
        //     ->from('product')
        //     ->join('INNER JOIN', 'category', 'product.category_id = category.id')
        //     ->all();

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
            'status' => $this->status,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_image', $this->product_image])
            ->andFilterWhere(['like', 'unit_of_measure', $this->unit_of_measure]);

        return $query;
    }

    // Search box result
    public function searchProductName($category_id,$product_name) 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'category.category', 'product.product_code', 'product.product_name', 'product.unit_of_measure', 'product.category_id', 'product.product_image', 'product.status', 'product.created_at', 'product.created_by', 'product.quantity', 'product.supplier_id', 'product.cost_price', 'product.selling_price'])
            ->from('product')
            ->join('INNER JOIN', 'category', 'product.category_id = category.id')
            ->where(['product.category_id' => $category_id])
            ->orWhere(['product.product_name' => $product_name])
            ->all();

        return $result;            
    }

    // get Product List
    public function getProducts() 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'category.category', 'product.product_code', 'product.product_name', 'product.product_image', 'product.quantity', 'product.supplier_id', 'product.cost_price', 'product.selling_price', 'product.unit_of_measure'])
            ->from('product')
            ->join('INNER JOIN', 'category', 'product.category_id = category.id')
            ->where(['product.status' => 1])
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }    
    }

    // Search if with same name.
    public function getProductName($product_name) {
       $rows = new Query();
    
       $result = $rows->select(['product_code', 'product_name'])
        ->from('product')
        ->where(['product_name' => $product_name])
        ->andWhere(['status' => 1])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

    // get Product by Id
    public function getProductById($id) {
        $rows = new Query();

        $result = $rows->select(['product.id', 'category.category', 'product.product_code', 'product.product_name', 'product.unit_of_measure', 'product.category_id', 'product.product_image', 'product.status', 'product.created_at', 'product.created_by'])
            ->from('product')
            ->join('INNER JOIN', 'category', 'product.category_id = category.id')
            ->where(['product.id' => $id])
            ->andWhere(['product.status' => 1])
            ->one();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }    
    }

    // get Product List By ID
    public function getProductListById($id) 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price' ])
            ->from('product')
            ->join('INNER JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where(['product.id' => $id])
            ->andWhere(['product.status' => 1])
            ->orderBy('product.id')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }   
    }

    // get product information
    public function getProductInformation($id) 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price' ])
            ->from('product')
            ->join('LEFT JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where(['product.id' => $id])
            ->one();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }   
    }

    //=========== REPORTS ===========//

    // getBestSellingPartsReportByDateRange
    public function getBestSellingPartsReportByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select([ 'invoice_detail.id as invoiceDetailId', 'invoice_detail.invoice_id', 'invoice.invoice_no', 'invoice_detail.service_part_id', 'category.category', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal' ])
                ->from('invoice_detail')
                ->join('LEFT JOIN', 'invoice', 'invoice_detail.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'product', 'invoice_detail.service_part_id = product.id')
                ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
                ->where('invoice_detail.type = 1')
                ->andWhere('invoice_detail.status = 1')
                ->andWhere("invoice.date_issue >= '$date_start'")
                ->andWhere("invoice.date_issue <= '$date_end'")
                ->orderBy(['invoice_detail.quantity' => SORT_DESC])
                ->all();

        return $result;
    }

    // getBestSellingParts
    public function getBestSellingParts() 
    {
        $rows = new Query();

        $result = $rows->select([ 'invoice_detail.id as invoiceDetailId', 'invoice_detail.invoice_id', 'invoice.invoice_no', 'invoice_detail.service_part_id', 'category.category', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal' ])
                ->from('invoice_detail')
                ->join('LEFT JOIN', 'invoice', 'invoice_detail.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'product', 'invoice_detail.service_part_id = product.id')
                ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
                ->where('invoice_detail.type = 1')
                ->andWhere('invoice_detail.status = 1')
                ->orderBy(['invoice_detail.quantity' => SORT_DESC])
                ->all();

        return $result;
    }

    // getMonthlySalesCashReportByDateRange
    public function getMonthlySalesCashReportByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.net', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'invoice.discount_amount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date', 'car_information.carplate', 'payment.interest', 'payment.net_with_interest', 'payment.points_redeem' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->andWhere("invoice.date_issue >= '$date_start'")
                ->andWhere("invoice.date_issue <= '$date_end'")
                ->andWhere('payment.payment_type = 1')
                ->orderBy(['invoice.id' => SORT_ASC])
                ->all();

        return $result;
    }

    // getMonthlySalesCreditCardReportByDateRange
    public function getMonthlySalesCreditCardReportByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.net', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'invoice.discount_amount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date', 'car_information.carplate', 'payment.interest', 'payment.net_with_interest', 'payment.points_redeem' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->andWhere("invoice.date_issue >= '$date_start'")
                ->andWhere("invoice.date_issue <= '$date_end'")
                ->andWhere('payment.payment_type = 2')
                ->orderBy(['invoice.id' => SORT_ASC])
                ->all();

        return $result;
    }

    // getMonthlySalesNetsReportByDateRange
    public function getMonthlySalesNetsReportByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.net', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'invoice.discount_amount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date', 'car_information.carplate', 'payment.interest', 'payment.net_with_interest', 'payment.points_redeem' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->andWhere("invoice.date_issue >= '$date_start'")
                ->andWhere("invoice.date_issue <= '$date_end'")
                ->andWhere('payment.payment_type = 3')
                ->orderBy(['invoice.id' => SORT_ASC])
                ->all();

        return $result;
    }

    // getMonthlySales30DaysCreditReportByDateRange
    public function getMonthlySalesDaysCreditReportByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.net', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'invoice.discount_amount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date', 'car_information.carplate', 'payment.interest', 'payment.net_with_interest', 'payment.points_redeem' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->andWhere("invoice.date_issue >= '$date_start'")
                ->andWhere("invoice.date_issue <= '$date_end'")
                ->andWhere('payment.payment_type = 5')
                ->orderBy(['invoice.id' => SORT_ASC])
                ->all();

        return $result;
    }

    // getMonthlySalesReport
    public function getMonthlySalesCash() 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.net', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'invoice.discount_amount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date', 'car_information.carplate', 'payment.interest', 'payment.net_with_interest', 'payment.points_redeem' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->andWhere('payment.payment_type = 1')
                ->orderBy(['invoice.id' => SORT_ASC])
                ->all();

        return $result;
    }

    public function getMonthlySalesCreditCard() 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.net', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'invoice.discount_amount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date', 'car_information.carplate', 'payment.interest', 'payment.net_with_interest', 'payment.points_redeem' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->andWhere('payment.payment_type = 2')
                ->orderBy(['invoice.id' => SORT_ASC])
                ->all();

        return $result;
    }

    public function getMonthlySalesNets() 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.net', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'invoice.discount_amount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date', 'car_information.carplate', 'payment.interest', 'payment.net_with_interest', 'payment.points_redeem' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->andWhere('payment.payment_type = 3')
                ->orderBy(['invoice.id' => SORT_ASC])
                ->all();

        return $result;
    }

    public function getMonthlySalesDaysCredit() 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.net', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'invoice.discount_amount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date', 'car_information.carplate', 'payment.interest', 'payment.net_with_interest', 'payment.points_redeem' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->andWhere('payment.payment_type = 5')
                ->orderBy(['invoice.id' => SORT_ASC])
                ->all();

        return $result;
    }

    // getMonthlyStockReport
    public function getMonthlyStock() 
    {
        $rows = new Query();

        $result = $rows->select([ 'inventory.id', 'inventory.product_id', 'product.product_code', 'product.product_name', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.old_quantity as quantity', 'product.cost_price', 'product.selling_price', 'inventory.datetime_imported', 'inventory.created_by', 'user.fullname' ])
                ->from('inventory')
                ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
                ->join('INNER JOIN', 'supplier', 'product.supplier_id = supplier.id')
                ->join('INNER JOIN', 'user', 'inventory.created_by = user.id')
                ->where(['inventory.type' => 1])
                ->andWhere(['product.status' => 1])
                ->all();

        return $result;
    }

    // getMonthlyStockReportByDateRange
    public function getMonthlyStockByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select([ 'inventory.id', 'inventory.product_id', 'product.product_code', 'product.product_name', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.old_quantity as quantity', 'product.cost_price', 'product.selling_price', 'inventory.datetime_imported', 'inventory.created_by', 'user.fullname' ])
                ->from('inventory')
                ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
                ->join('INNER JOIN', 'supplier', 'product.supplier_id = supplier.id')
                ->join('INNER JOIN', 'user', 'inventory.created_by = user.id')
                ->where("inventory.datetime_imported >= '$date_start'")
                ->andWhere("inventory.datetime_imported <= '$date_end'")
                // ->andWhere(['inventory.type' => 1])
                ->andWhere(['product.status' => 1])
                ->all();

        return $result;
    }

    // get zero product stock
    public function getZeroStock() 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'category.category', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price', 'product.created_at', 'product.unit_of_measure' ])
            ->from('product')
            ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
            ->join('LEFT JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where('product.quantity = 0')
            ->orderBy(['product.product_name' => SORT_DESC])
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get low product stock
    public function getLowStock() 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'category.category', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price', 'product.created_at', 'product.unit_of_measure' ])
            ->from('product')
            ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
            ->join('LEFT JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where("product.quantity <= product.reorder_level")
            ->orderBy(['product.quantity' => SORT_DESC])
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

}
