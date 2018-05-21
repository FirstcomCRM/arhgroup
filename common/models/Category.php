<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $category
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'required', 'message' => 'Fill-up required fields.'],
            // [['category'], 'unique', 'message' => 'Parts category name already exist.'],
            [['status', 'created_at', 'created_by'], 'safe'],
            [['category'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
        ];
    }

    public static function dataCategory(){
        return Category::find()->where(['status' => 1])->all();
    }
}
