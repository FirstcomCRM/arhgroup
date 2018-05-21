<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "terms_and_conditions".
 *
 * @property integer $id
 * @property string $descriptions
 * @property integer $created_at
 * @property string $created_by
 * @property integer $updated_at
 * @property string $updated_by
 */
class TermsAndConditions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'terms_and_conditions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descriptions'], 'required', 'message' => 'Fill-up required fields.'],
            // [['descriptions'], 'unique', 'message' => 'Terms and Condition already exist.'],
            [['descriptions'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descriptions' => 'Descriptions',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
