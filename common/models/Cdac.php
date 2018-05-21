<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cdac".
 *
 * @property integer $cdac_id
 * @property integer $from_salary
 * @property integer $to_salary
 * @property integer $minimum_monthly_contribution
 * @property integer $status
 * @property string $date_time_created
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Cdac extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cdac';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_salary', 'to_salary', 'minimum_monthly_contribution', 'created_by'], 'required'],
            [['from_salary', 'to_salary', 'minimum_monthly_contribution', 'status', 'created_by', 'updated_by'], 'integer'],
            [['date_time_created', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cdac_id' => 'Cdac ID',
            'from_salary' => 'From Salary',
            'to_salary' => 'To Salary',
            'minimum_monthly_contribution' => 'Minimum Monthly Contribution',
            'status' => 'Status',
            'date_time_created' => 'Date Time Created',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
