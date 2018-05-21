<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inventory".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $old_quantity
 * @property integer $new_quantity
 * @property integer $type
 * @property string $datetime_imported
 * @property string $datetime_purchased
 * @property string $created_at
 * @property integer $created_by
 * @property integer $status
* @property string $invoice_no
 */
class Inventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'old_quantity', 'new_quantity'], 'required'],
            [['product_id', 'old_quantity', 'new_quantity', 'type', 'created_by', 'status'], 'integer'],
            [['datetime_imported', 'datetime_purchased', 'type', 'created_at', 'created_by', 'status', 'invoice_no'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'old_quantity' => 'Old Quantity',
            'new_quantity' => 'New Quantity',
            'type' => 'Type',
            'datetime_imported' => 'Datetime Imported',
            'datetime_purchased' => 'Datetime Purchased',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'status' => 'Status',
            'invoice_no' => 'Invoice No',
        ];
    }
}
