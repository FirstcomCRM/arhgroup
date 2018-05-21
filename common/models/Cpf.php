<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cpf".
 *
 * @property integer $id
 * @property integer $from_age
 * @property integer $to_age
 * @property integer $employee_cpf
 * @property integer $employer_cpf
 * @property string $description
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Cpf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cpf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_age', 'to_age', 'employee_cpf', 'employer_cpf', 'description'], 'required', 'message' => 'Fill-up required fields.'],
            [['from_age', 'to_age', 'status', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_age' => 'From Age',
            'to_age' => 'To Age',
            'employee_cpf' => 'Employee Cpf',
            'employer_cpf' => 'Employer Cpf',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
