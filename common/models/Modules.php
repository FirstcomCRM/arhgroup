<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "modules".
 *
 * @property integer $id
 * @property string $modules
 */
class Modules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modules'], 'required', 'message' => 'Fill-up required fields.'],
            // [['modules'], 'unique', 'message' => 'Module name already exist.'],
            [['created_at','created_by','status'], 'safe'],
            [['modules'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'modules' => 'Modules',
        ];
    }

    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }
}
