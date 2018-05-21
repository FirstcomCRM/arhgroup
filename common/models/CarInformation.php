<?php

namespace common\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Invoice;
use yii\helpers\ArrayHelper;
use yii\db\Query;


/**
 * This is the model class for table "car_information".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $carplate
 * @property string $make
 * @property string $model
 * @property string $engine_no
 * @property string $year_mfg
 * @property string $chasis
 * @property integer $points
 * @property integer $type
 * @property integer $status
 */
class CarInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_information';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carplate', 'make', 'model', 'engine_no', 'year_mfg', 'chasis', 'points'], 'safe'],
            [['customer_id', 'type', 'status'], 'integer'],
            [['carplate', 'make', 'model', 'engine_no', 'chasis'], 'string', 'max' => 50],
            [['year_mfg'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'carplate' => 'Carplate',
            'make' => 'Make',
            'model' => 'Model',
            'engine_no' => 'Engine No',
            'year_mfg' => 'Year Mfg',
            'chasis' => 'Chasis',
            'points' => 'Points',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }

     public function getCarInfoWithActiveCustomer() 
    {
        $rows = new Query();

        $result = $rows->select(['car_information.id','car_information.carplate'])
                ->from('car_information')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where([ 'car_information.status' => 1 ])
                ->andWhere([ 'customer.deleted' => 0 ])
                ->andWhere([ 'customer.is_blacklist' => 0 ])
                ->orderBy(['car_information.carplate' => SORT_DESC])
                ->all();
        
        return $result;
    }
    public static function getCustomerId($car_information_id=null)
    {
        $car_info = CarInformation::find()->where(['id' => $car_information_id])->one();
        return $car_info->customer_id;
    }

    public function getCustomer(){
        return $this->hasOne(CarInformation::className(), ['id' => 'customer_id']);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getBranch(){
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    public static function dataCarInformation() {
        return ArrayHelper::map(CarInformation::find()->where(['status' => 1])->all(), 'id', 'carplate');
    }

    public static function getCarInformationById($id){
        $car_info = CarInformation::find()->where(['id' => $id])->one();
        return $car_info;
    }

    public static function updatePoint($id, $point, $action='+'){

        $carInformation = CarInformation::find()->where(['id' => $id])->one();

        if($action=='+')
            $carInformation->points += $point;
        else
            $carInformation->points -= $point;

        $carInformation->save();
    }

}
