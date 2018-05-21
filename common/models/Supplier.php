<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $id
 * @property string $supplier_code
 * @property string $supplier_name
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_code', 'supplier_name', 'address', 'contact_number'], 'required', 'message' => 'Fill-up required fields.'],
            [['status', 'created_at', 'created_by'], 'safe'],
            // [['supplier_name'], 'unique', 'message' => 'Supplier name already exist.'],
            [['supplier_code', 'supplier_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_code' => 'Supplier Code',
            'supplier_name' => 'Supplier Name',
            'address' => 'Address',
            'contact_number' => 'Contact Number',
        ];
    }
}
