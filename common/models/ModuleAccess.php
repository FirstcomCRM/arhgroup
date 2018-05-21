<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "module_access".
 *
 * @property integer $id
 * @property string $modules_id
 * @property string $role_id
 * @property integer $created_by
 * @property string $created_at
 */
class ModuleAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modules_id', 'role_id', 'created_by', 'created_at'], 'required'],
            [['created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['modules_id', 'role_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'modules_id' => 'Modules ID',
            'role_id' => 'Role ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }
}
