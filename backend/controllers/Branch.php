<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "branch".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $address
 * @property string $contact_no
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'address', 'contact_no'], 'required', 'message' => 'Fill-up required fields.'],
            [['contact_no','fax','branch_type'], 'integer'],
            [['email'], 'email'],
            // [['name'], 'unique', 'message' => 'Branch name already exist.'],
            [['created_at','updated_at','created_by','updated_by','status','uen_no'], 'safe'],
            [['code', 'name', 'contact_no'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'address' => 'Address',
            'contact_no' => 'Contact No',
            'fax' => 'Fax',
            'email' => 'Email',
            'uen_no' => 'UEN No',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'branch_type' => 'Branch Type',
        ];
    }

}
