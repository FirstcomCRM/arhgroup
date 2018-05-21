<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dashboard".
 *
 * @property string $ic
 */
class Dashboard extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ic'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ic' => 'IC',
        ];
    }

}