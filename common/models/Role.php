<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $role
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role'], 'required', 'message' => 'Fill-up required fields.'],
            //[['role'], 'unique', 'message' => 'Role name already exist.'],
            [['created_at','created_by','status'], 'safe'],
            [['role'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
        ];
    }

}
