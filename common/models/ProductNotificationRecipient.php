<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_notification_recipient".
 *
 * @property integer $id
 * @property string $email
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $status
 */
class ProductNotificationRecipient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_notification_recipient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required', 'message' => 'Fill-up required fields.'],
            // [['email'], 'unique', 'message' => 'Email address already exist.'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['email'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
