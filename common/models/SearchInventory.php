<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Inventory;

use yii\db\Query;

/**
 * SearchInventory represents the model behind the search form about `common\models\Inventory`.
 */
class SearchInventory extends Inventory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'old_quantity', 'new_quantity', 'type', 'created_by', 'status'], 'integer'],
            [['datetime_imported', 'datetime_purchased', 'created_at', 'invoice_no'], 'safe'],
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
        $query = Inventory::find();

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
            'product_id' => $this->product_id,
            'old_quantity' => $this->old_quantity,
            'new_quantity' => $this->new_quantity,
            'type' => $this->type,
            'datetime_imported' => $this->datetime_imported,
            'datetime_purchased' => $this->datetime_purchased,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }

    // get Supplier Name and Product Name
    public function selectSupplierNameandProductName($supplier_id,$product_id) 
    {
        $rows = new Query();

        $result = $rows->select(['supplier_id', 'product_id'])
            ->from('inventory')
            ->where(['supplier_id' => $supplier_id])
            ->andWhere(['product_id' => $product_id])
            ->all();

        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

    // get Product by Id
    public function getProductInInventoryById($id) 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price','inventory.date_imported','inventory.created_at','inventory.status'])
            ->from('inventory')
            ->join('LEFT JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
            ->where(['inventory.id' => $id])
            ->orderBy('inventory.id')
            ->one();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }   
    }

    // get zero product stock
    public function getZeroStock() 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price', 'product.created_at'])
            ->from('product')
            ->join('LEFT JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where('product.quantity = 0')
            ->orderBy('product.product_name')
            ->limit(10)
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get zero product stock
    public function getTotalZeroStock() 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price', 'product.created_at'])
            ->from('product')
            ->join('LEFT JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where('product.quantity = 0')
            ->orderBy('product.product_name')
            ->limit(10)
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get critical product stock
    public function getCriticalStock() 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price', 'product.created_at'])
            ->from('product')
            ->join('LEFT JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where("product.quantity <= product.reorder_level")
            ->orderBy('product.product_name')
            ->limit(10)
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get total critical product stock
    public function getTotalCriticalStock() 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price', 'product.created_at'])
            ->from('product')
            ->join('LEFT JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where("product.quantity <= product.reorder_level")
            ->orderBy('product.product_name')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get warning product stock
    public function getWarningStock($minimumLevel) 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price', 'product.created_at'])
            ->from('product')
            ->join('LEFT JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where("product.quantity <= $minimumLevel")
            ->orderBy('product.product_name')
            ->limit(10)
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get total warning product stock
    public function getTotalWarningStock($minimumLevel) 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price', 'product.created_at'])
            ->from('product')
            ->join('LEFT JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where("product.quantity <= $minimumLevel")
            ->orderBy('product.product_name')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get Product List in Inventory By ID
    public function getProductListInInventoryById($id) 
    {
        $rows = new Query();

        $result = $rows->select(['product.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.selling_price' ])
            ->from('product')
            ->join('INNER JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where(['product.id' => $id])
            ->orderBy('product.id')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }   
    }

    // get Product Information in Inventory By ID
    public function getProductInformation($id) 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price', 'inventory.date_imported'])
            ->from('inventory')
            ->join('LEFT JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
            ->where(['inventory.id' => $id])
            ->one();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }   
    }

    // get Product List By Type
    public function getPartsInInventoryByType($partsType) 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.gst_price', 'product.selling_price', 'product.unit_of_measure', 'inventory.datetime_imported', 'inventory.old_quantity', 'inventory.new_quantity', 'inventory.datetime_purchased', 'inventory.type', 'inventory.invoice_no', 'inventory.qty_purchased', 'inventory.created_at' ])
            ->from('inventory')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->join('INNER JOIN', 'supplier', 'product.supplier_id = supplier.id')
            ->where(['inventory.type' => $partsType ]);

        return $result;   
    }

    // get Product List
    public function getPartsInInventory() 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'product.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'product.product_code', 'product.product_name', 'product.quantity', 'product.cost_price', 'product.gst_price', 'product.selling_price', 'product.unit_of_measure', 'inventory.datetime_imported', 'inventory.old_quantity', 'inventory.new_quantity', 'inventory.datetime_purchased', 'inventory.type', 'inventory.invoice_no', 'inventory.qty_purchased', 'inventory.created_at' ])
            ->from('inventory')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->join('INNER JOIN', 'supplier', 'product.supplier_id = supplier.id');

        return $result;
       
    }

}
