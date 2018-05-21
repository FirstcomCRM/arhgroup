<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "quotation_detail".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property integer $service_part_id
 * @property integer $quantity
 * @property double $selling_price
 * @property double $subTotal
 * @property string $created_at
 * @property integer $created_by
 * @property integer $type
 */
class QuotationDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_id', 'service_part_id', 'quantity', 'selling_price', 'subTotal', 'created_at', 'created_by', 'type'], 'required'],
            [['quotation_id', 'quantity', 'created_by', 'type'], 'integer'],
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
            'quotation_id' => 'Quotation ID',
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

    public static function saveQuotationDetail($quotation_id, $postData){

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

            $quotationDetail = new QuotationDetail();
            $quotationDetail->quotation_id = $quotation_id;
            $quotationDetail->service_part_id = $item_id;
            $quotationDetail->quantity = $quantity[$count];
            $quotationDetail->selling_price = $plus_minus.$price[$count];
            $quotationDetail->subTotal = $plus_minus.$subTotal;
            $quotationDetail->created_at = date('Y-m-d H:i:s');
            $quotationDetail->created_by = Yii::$app->user->identity->id;
            $quotationDetail->type = $type[$count];
            $quotationDetail->task = $task[$count];
            $quotationDetail->invoice = 0;
            $quotationDetail->save();
            // var_dump($quotationDetail->getErrors());

            $count++;
        }
    }

    public static function getQuotationDetailByID($quotation_id){
        $rows = new Query();

        $result = $rows->select('qd.*,p.product_name')
                ->from('quotation_detail qd')
                ->leftJoin('product p', 'p.id=qd.service_part_id')
                ->where(['qd.quotation_id'=>$quotation_id])
                ->orderBy('id','asc')
                ->all();
        
        return $result;
    }

    public static function updateQuotationDetail($quotation_id, $postData){

        Yii::$app->db->createCommand()
                    ->delete('quotation_detail', "quotation_id = $quotation_id" )
                    ->execute();


    }
}
