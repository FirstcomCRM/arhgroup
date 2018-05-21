<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $role
 * @property string $password
 * @property string $password_hash
 * @property string $auth_key
 * @property string $fullname
 * @property string $address
 * @property string $race_id
 * @property string $address
 * @property string $hanphone_no
 * @property string $office_no
 * @property string $email
 * @property string $company_name
 * @property string $uen_no
 * @property string $remarks
 * @property string $type
 * @property integer $status
 * @property string $join_date
 * @property string $member_expiry
 * @property integer $is_blacklist
 * @property integer $is_member
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $deleted
 */
class Customer extends \yii\db\ActiveRecord
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
            [['type'], 'required', 'message' => 'Fill up the required fields.'],
            [['fullname', 'nric', 'company_name', 'uen_no', 'address'], 'string' ],
            [['hanphone_no', 'office_no','fax_number', 'is_blacklist', 'is_member', 'updated_by', 'created_by'], 'integer'],
            [['email'], 'email', 'message' => 'Invalid email address format.'],
            [['is_member', 'join_date', 'member_expiry', 'type', 'deleted', 'status', 'nric', 'uen_no', 'created_at', 'updated_at', 'password', 'password_hash', 'auth_key', 'race_id', 'role' ], 'safe'],
            [['fullname', 'nric', 'company_name', 'uen_no', 'hanphone_no', 'office_no', 'email' ], 'string', 'max' => 50],
            [['type'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'Choose customer type first.'],
            [['is_member'], 'compare', 'compareValue' => 3, 'operator' => '<', 'type' => 'number', 'message' => 'Choose member type first.'],
            // [['fullname'], 'unique', 'message' => 'Fullname already exist.'],
            // [['company_name'], 'unique', 'message' => 'Company Name already exist.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'nric' => 'NRIC',
            'company_name' => 'Company Name',
            'uen_no' => 'UEN No',
            'race_id' => 'Race',
            'address' => 'Address',
            'hanphone_no' => 'Hanphone No',
            'office_no' => 'Office No',
            'fax_number' => 'Fax Number',
            'email' => 'Email',
            'remarks' => 'Remarks',
            'join_date' => 'Join Date',
            'member_expiry' => 'Member Expiry',
            'is_blacklist' => 'Is Blacklist',
            'is_member' => 'Is Member',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    public static function getCustomer($customer_id=null)
    {
        $customer = Customer::find()->where(['id' => $customer_id])->one();
        return $customer;
    }

    public static function dataCustomer($id=null) {
        return ArrayHelper::map(Customer::find()->where(['status' => 'active'])->where(['deleted' => '0'])->all(), 'id', 'fullname');
    }

    public function getCarInformation(){
        return $this->hasOne(CarInformation::className(), ['id' => 'customer_id']);
    }

}
