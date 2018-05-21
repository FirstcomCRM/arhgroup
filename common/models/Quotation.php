<?php

namespace common\models;

use Yii;
use yii\db\Query;
use common\models\QuotationDetail;
use common\models\SearchQuotation;


/**
 * This is the model class for table "quotation".
 *
 * @property integer $id
 * @property string $quotation_code
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $branch_id
 * @property string $date_issue
 * @property string $type
 * @property integer $no_of_services
 * @property integer $no_of_parts
 * @property double $grand_total
 * @property string $remarks
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $delete
 */
class Quotation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_code', 'date_issue', 'grand_total', 'gst', 'net'], 'required', 'message' => 'Fill up the required fields.'],
            [['branch_id', 'customer_id', 'user_id'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'Invalid option selected'],
            [['user_id', 'customer_id', 'branch_id', 'created_by', 'updated_by', 'delete', 'invoice'], 'integer'],
            [['date_issue', 'created_at', 'updated_at'], 'safe'],
            [['remarks', 'mileage'], 'string'],
            [['quotation_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_code' => 'Quotation Code',
            'user_id' => 'User ID',
            'customer_id' => 'Customer ID',
            'branch_id' => 'Branch ID',
            'date_issue' => 'Date Issue',
            'grand_total' => 'Grand Total',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'delete' => 'Delete',
        ];
    }
    public function getCustomer(){
        return $this->hasOne(CarInformation::className(), ['customer_id' => 'customer_id']);
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getBranch(){
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    public function getCar_information(){
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public static function saveQuotation($postData){

        $quotation = $postData['Quotation'];

        $quo = new Quotation();
        $quo->come_in = $quotation['come_in'];
        $quo->come_out = $quotation['come_out'];
        $quo->remarks = $quotation['remarks'];

        if(trim($quotation['come_in'])=='--/--/---- --:--:--')
            $quo->come_in = '0000-00-00 00:00:00';
        else 
            $quo->come_in = date('Y-m-d H:i:s', strtotime($quo->come_in));

        if(trim($quotation['come_out'])=='--/--/---- --:--:--')
            $quo->come_out = '0000-00-00 00:00:00';
        else
            $quo->come_out = date('Y-m-d H:i:s', strtotime($quo->come_out));


        if($quotation['remarks'] = "")
            $quo->remarks = "No remarks.";

        $quo->branch_id = $quotation['branch_id'];
        $quo->customer_id = $quotation['customer_id'];
        $quo->user_id = $quotation['user_id'];
        $quo->date_issue = date('Y-m-d', strtotime($quotation['date_issue']));
        $quo->gst = $quotation['gst'];
        $quo->net = $quotation['net'];
        $quo->grand_total = $quotation['grand_total'];
        $quo->mileage = $quotation['mileage'];
        
        $quo->created_at = date('Y-m-d').' 00:00:00';
        $quo->time_created = date("H:i:s");
        $quo->created_by = Yii::$app->user->identity->id;

        
        $searchModel = new SearchQuotation();
        $quotationId = $searchModel->getQuotationId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $quotationCodeValue = 'JS' . $yrNow  . $monthNow . sprintf('%003d', $quotationId);
        $quo->quotation_code = $quotationCodeValue;
        $quo->task = 0;
        $quo->invoice = 0;
        $quo->discount_amount = '0.00';
        $quo->discount_remarks = "";

        $quo->save();

        QuotationDetail::saveQuotationDetail($quo->id, $postData);
        return $quo->id;
    }

    public static function updateQuotation($quotation_id, $postData)
    {
        $quotation = $postData['Quotation'];

        $quo = Quotation::findOne($quotation_id);
        $quo->come_in = $quotation['come_in'];
        $quo->come_out = $quotation['come_out'];
        $quo->remarks = $quotation['remarks'];

        if(trim($quotation['come_in'])=='--/--/---- --:--:--')
            $quo->come_in = '0000-00-00 00:00:00';
        else 
            $quo->come_in = date('Y-m-d H:i:s', strtotime($quo->come_in));

        if(trim($quotation['come_out'])=='--/--/---- --:--:--')
            $quo->come_out = '0000-00-00 00:00:00';
        else
            $quo->come_out = date('Y-m-d H:i:s', strtotime($quo->come_out));

        if($quotation['remarks'] = "")
            $quo->remarks = "No remarks.";

        $quo->branch_id = $quotation['branch_id'];
        $quo->customer_id = $quotation['customer_id'];
        $quo->user_id = $quotation['user_id'];
        $quo->date_issue = date('Y-m-d', strtotime($quotation['date_issue']));
        $quo->gst = $quotation['gst'];
        $quo->net = $quotation['net'];
        $quo->grand_total = $quotation['grand_total'];
        $quo->mileage = $quotation['mileage'];
        
        $quo->updated_at = date('Y-m-d').' 00:00:00';
        $quo->updated_by = Yii::$app->user->identity->id;
        $quo->save();

        Yii::$app->db->createCommand()
                    ->delete('quotation_detail', "quotation_id = $quotation_id" )
                    ->execute();

        QuotationDetail::saveQuotationDetail($quo->id, $postData);
    }
}
