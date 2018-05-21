<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property integer $service_category_id
 * @property string $service_name
 * @property string $description
 * @property double $default_price
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_category_id', 'service_name', 'description', 'default_price', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['service_category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['default_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['service_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_category_id' => 'Service Category ID',
            'service_name' => 'Service Name',
            'description' => 'Description',
            'default_price' => 'Default Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getServicesById($id) {
        $rows = new Query();

        $result = $rows->select(['service.id','service.service_category_id','service_category.name','service.service_name','service.description','service.default_price','service.status','service.created_at','service.created_by'])
            ->from('service')
            ->join('INNER JOIN', 'service_category', 'service.service_category_id = service_category.id')
            ->where(['service.id' => $id])
            ->one();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }

    }

}
