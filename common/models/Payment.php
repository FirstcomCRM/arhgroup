<?php

namespace common\models;

use Yii;

use yii\db\Query;
use common\models\Payment;
use common\models\CarInformation;
/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $invoice_id
 * @property double $amount
 * @property integer $payment_method
 * @property string $payment_type
 * @property integer $points_earned
 * @property integer $points_redeem
 * @property string $remarks
 * @property string $payment_date
 * @property string $payment_time
 * @property integer $status
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'amount', 'payment_method', 'payment_type', 'points_earned', 'points_redeem', 'remarks', 'payment_date', 'payment_time', 'status'], 'required'],
            [['invoice_id', 'payment_method', 'status'], 'integer'],
            [['remarks'], 'string'],
            [['payment_date', 'payment_time', 'points_earned', 'points_redeem', 'amount' ], 'safe'],
            [['payment_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'amount' => 'Amount',
            'payment_method' => 'Payment Method',
            'payment_type' => 'Payment Type',
            'points_earned' => 'Points Earned',
            'points_redeem' => 'Points Redeem',
            'remarks' => 'Remarks',
            'payment_date' => 'Payment Date',
            'payment_time' => 'Payment Time',
            'status' => 'Status',
        ];
    }   

    public static function saveRedeemPoint($invoice_id, $redeem_point, $redeem_description){

        $invoice = Invoice::getInvoiceById($invoice_id);

        //skip if no redeem point
        if($redeem_point=='' || $redeem_point=='0')
            return '';

        $point_to_price = ($redeem_point /20);
        $point_to_price = number_format($point_to_price, 2, '.', '');   

        $payment = New Payment();
        $payment->invoice_id = $invoice_id;
        $payment->invoice_no = $invoice->invoice_no;
        $payment->customer_id = $invoice->customer_id;
        $payment->net = '0.00';
        $payment->net_with_interest = $invoice->net;
        $payment->amount = $point_to_price;
        $payment->payment_method = 1;
        $payment->points_earned = 0;
        $payment->points_redeem = $redeem_point;
        $payment->payment_type = '1';
        $payment->interest = '0';
        $payment->remarks = $redeem_description;
        $payment->payment_status = "not paid";
        $payment->payment_date = date('Y-m-d', strtotime($invoice->created_at));
        $payment->payment_time = $invoice->time_created;
        $payment->status = 1;

        $payment->save();
        
        //update point at car information points
        CarInformation::updatePoint($invoice->customer_id, $redeem_point, '-');
    }

    public static function getPaymentWithRedeemPoint($invoice_id){
        $rows = new Query();

        $result = $rows->select('sum(amount) as redeem_price')
                ->from('payment')
                ->where(['invoice_id'=>$invoice_id])
                ->andWhere(['<>', 'points_redeem', '0'])
                ->groupBy('invoice_id')
                ->one();

        return $result['redeem_price'];
    }

    public static function getPaymentbyInvoiceId($invoice_id){
        return Payment::find()->where(['status' => 1, 'invoice_id' => $invoice_id ])->all();

    }

    public static function getPaidPayment($invoice_id){
         $rows = new Query();

        $result = $rows->select('*')
                ->from('payment')
                ->where(['invoice_id'=>$invoice_id])
                ->andWhere(['points_redeem' => '0'])
                ->all();

        return $result;
    }

    public static function updateRedeemPoint($invoice_id, $redeem_point, $redeem_description){

        $invoice = Invoice::getInvoiceById($invoice_id);

        //revert redeem point
        Payment::revertRedeemPoint($invoice->customer_id, $invoice_id);

        //delete payment record
        Payment::deletePaymentRecord($invoice_id);

        //skip if no redeem point
        if($redeem_point=='' || $redeem_point=='0')
            return '';

        $point_to_price = ($redeem_point /20);
        $point_to_price = number_format($point_to_price, 2, '.', '');    

        $payment = New Payment();
        $payment->invoice_id = $invoice_id;
        $payment->invoice_no = $invoice->invoice_no;
        $payment->customer_id = $invoice->customer_id;
        $payment->net = $point_to_price;
        $payment->net_with_interest = ($invoice->net - $point_to_price);
        $payment->amount = $point_to_price;
        $payment->payment_method = 1;
        $payment->points_earned = 0;
        $payment->points_redeem = $redeem_point;
        $payment->payment_type = '1';
        $payment->interest = '0';
        $payment->remarks = $redeem_description;
        $payment->payment_status = "not paid";
        $payment->payment_date = date('Y-m-d', strtotime($invoice->created_at));
        $payment->payment_time = $invoice->time_created;
        $payment->status = 1;

        $payment->save();

        //update point at car information points
        CarInformation::updatePoint($invoice->customer_id, $redeem_point, '-');
    }

    public static function revertRedeemPoint($customer_id, $invoice_id){
        $record = Payment::getRedeemPointPaymentRecord($invoice_id);

        if($record===false)
            return '';

        $id = $customer_id;
        $point = $record['redeem_point'];

        CarInformation::updatePoint($id, $point);
    }

    public static function getRedeemPointPaymentRecord($invoice_id)
    {
        $rows = new Query();        

        return $rows->select('sum(amount) as redeem_price, sum(points_redeem) as  redeem_point ')
                ->from('payment')
                ->where(['invoice_id'=>$invoice_id])
                ->andWhere(['<>', 'points_redeem', '0'])
                ->groupBy('invoice_id')
                ->one();
    }

    public static function deletePaymentRecord($invoice_id){

        Yii::$app->db->createCommand()
            ->delete('payment', "invoice_id = $invoice_id" )
            ->execute();
    }

}
