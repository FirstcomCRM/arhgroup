<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff".
 *
 * @property integer $id
 * @property string $staff_code
 * @property string $fullname
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_group_id', 'designated_position_id', 'staff_code', 'fullname', 'address', 'email', 'contact_number', 'basic', 'allowance', 'ic_no', 'rate_per_hour', 'non_tax_allowance', 'gender'], 'required', 'message' => 'Fill-up required fields.'],
            [['status', 'created_by', 'updated_by', 'contact_number'], 'integer'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'levy_supplement', 'basic', 'allowance', 'rate_per_hour', 'non_tax_allowance'], 'safe'],
            [['staff_code', 'fullname'], 'string', 'max' => 50],
            // [['fullname'], 'unique', 'message' => 'Staff name already exist.'],
            [['staff_group_id', 'designated_position_id', 'race_id', 'citizenship'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'Invalid option selected'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_group_id' => 'Staff Group',
            'staff_code' => 'Staff Code',
            'fullname' => 'Fullname',
            'address' => 'Address',
            'email' => 'Email',
            'contact_number' => 'Contact Number',
            'basic' => 'Basic',
            'ic_no' => 'IC No',
            'rate_per_hour' => 'Rate per Hour',
            'allowance' => 'Allowance',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
