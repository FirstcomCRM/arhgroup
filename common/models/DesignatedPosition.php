<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "designated_position".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $status
 */
class DesignatedPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'designated_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required', 'message' => 'Fill-up required fields.'],
            [['description'], 'string'],
            // [['name'], 'unique', 'message' => 'Designated Position name already exist.'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
