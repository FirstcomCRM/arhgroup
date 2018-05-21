<?php

namespace common\models;

use Yii;
use yii\db\Query;
use common\models\Invoice;
use common\models\Inventory;
use common\models\CarInformation;

/**
 * This is the model class for table "invoice_detail".
 *
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $service_part_id
 * @property integer $quantity
 * @property double $selling_price
 * @property double $subTotal
 * @property string $created_at
 * @property integer $created_by
 * @property integer $type
 * @property integer $task
 */
class InvoiceDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'service_part_id', 'quantity', 'selling_price', 'subTotal', 'created_at', 'created_by', 'type'], 'required'],
            [['invoice_id', 'quantity', 'created_by', 'type'], 'integer'],
            [['selling_price', 'subTotal'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'service_part_id' => 'Service Part ID',
            'quantity' => 'Quantity',
            'selling_price' => 'Selling Price',
            'subTotal' => 'Sub Total',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'type' => 'Type',
            'task' => 'Task',
        ];
    }

    public static function saveInvoiceDetail($invoice_id, $postData){
        $service_part_id = $postData['service_part_id'];
        $quantity = $postData['quantity'];
        $type = $postData['type'];
        $price = $postData['price'];
        $task = $postData['task'];

        $count = 0;
        foreach($service_part_id as $item_id)
        {
            $plus_minus = $type[$count]==2 ? '-' :'';
            $subTotal = ($price[$count] * $quantity[$count]);

            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $invoice_id;
            $invoiceDetail->service_part_id = $item_id;
            $invoiceDetail->quantity = $quantity[$count];
            $invoiceDetail->selling_price = $plus_minus.$price[$count];
            $invoiceDetail->subTotal = $plus_minus.$subTotal;
            $invoiceDetail->created_at = date('Y-m-d H:i:s');
            $invoiceDetail->created_by = Yii::$app->user->identity->id;
            $invoiceDetail->type = $type[$count];
            $invoiceDetail->task = $task[$count];
            $invoiceDetail->status = 0;
            $invoiceDetail->save();
            
            // if item is product
            if($type[$count]==1)
                InvoiceDetail::deductInventoryProductQuantity($invoice_id, $item_id, $quantity[$count]);

            $count++;
        }
    }

    public static function getInvoiceDetailByID($invoice_id){
        $rows = new Query();

        $result = $rows->select('id.*,p.product_name')
                ->from('invoice_detail id')
                ->leftJoin('product p', 'p.id=id.service_part_id')
                ->where(['id.invoice_id'=>$invoice_id])
                ->orderBy('id','asc')
                ->all();
        
        return $result;
    }

    public static function deductInventoryProductQuantity($invoice_id, $product_id, $new_quantity){

        $product = Product::find()->where(['id' => $product_id])->one();
        $invoice = Invoice::find()->where(['id' => $invoice_id])->one();

        $curr_qty = $product->quantity;
        $left_qty = ($product->quantity - $new_quantity);

        $inventory = new Inventory();
        
        $inventory->product_id = $product_id;
        $inventory->old_quantity = $curr_qty;
        $inventory->new_quantity = $left_qty;
        $inventory->qty_purchased = $new_quantity;
        $inventory->type = 2;
        $inventory->invoice_no = $invoice->invoice_no;
        $inventory->datetime_purchased = $invoice->date_issue;
        $inventory->created_at = $invoice->created_at;
        $inventory->created_by = Yii::$app->user->identity->id;
        $inventory->status = 1;
        $inventory->save();

        $product->quantity -= $new_quantity;
        $product->save();     
    }

    public static function updateInvoiceDetail($invoice_id, $postData){
        //revert inventory and product quantity
        InvoiceDetail::revertInventoryProductQuantity($invoice_id);

        $service_part_id = $postData['service_part_id'];
        $quantity = $postData['quantity'];
        $type = $postData['type'];
        $price = $postData['price'];
        $task = $postData['task'];

        $count = 0;
        foreach($service_part_id as $item_id)
        {
            $plus_minus = $type[$count]==2 ? '-' :'';
            $subTotal = ($price[$count] * $quantity[$count]);

            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $invoice_id;
            $invoiceDetail->service_part_id = $item_id;
            $invoiceDetail->quantity = $quantity[$count];
            $invoiceDetail->selling_price = $plus_minus.$price[$count];
            $invoiceDetail->subTotal = $plus_minus.$subTotal;
            $invoiceDetail->created_at = date('Y-m-d H:i:s');
            $invoiceDetail->created_by = Yii::$app->user->identity->id;
            $invoiceDetail->type = $type[$count];
            $invoiceDetail->task = $task[$count];
            $invoiceDetail->status = 0;
            $invoiceDetail->save();
            
            // if item is product
            if($type[$count]==1)
                InvoiceDetail::deductInventoryProductQuantity($invoice_id, $item_id, $quantity[$count]);

            $count++;
        }
    }

    public static function revertInventoryProductQuantity($invoice_id){

        $invoice = Invoice::find()->where(['id' => $invoice_id])->one();
        $invoice_detail = InvoiceDetail::getInvoiceDetailByID($invoice_id);

        foreach( $invoice_detail as $key => $item ) 
        {    
            if($item['type']==1)
            {
                $product = Product::findOne($item['service_part_id']);
                $product->quantity += $item['quantity'];
                $product->save();

                Yii::$app->db->createCommand()
                ->delete('inventory', ["invoice_no"=>$invoice->invoice_no, "product_id"=>$item['service_part_id']] )
                ->execute();                            
            }

        }

        Yii::$app->db->createCommand()
            ->delete('invoice_detail', "invoice_id = $invoice_id" )
            ->execute();

        return '';
    }

    public static function revertPoints($invoice_id){
        $query = new Query();

        $result = $query->select('sum(points_redeem) as total_points_redeem, sum(points_earned) as total_points_earned, customer_id')
                ->from('payment')
                ->where(['invoice_id'=>$invoice_id])
                ->groupBy(['invoice_id'])
                ->one();
        
        if($result==null)
            return '';

        $total_points_redeem = $result['total_points_redeem'];
        $total_points_earned = $result['total_points_earned'];
        $carInformation = CarInformation::findOne($result['customer_id']);
        $carInformation->points = $carInformation->points + $total_points_redeem - $total_points_earned;
        $carInformation->save();

        Yii::$app->db->createCommand()
            ->delete('payment', "invoice_id = $invoice_id" )
            ->execute();

        return '';
    }
}
