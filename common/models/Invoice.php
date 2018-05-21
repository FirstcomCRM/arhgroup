<?php

namespace common\models;

use Yii;

use yii\db\Query;
use common\models\InvoiceDetail;
use common\models\Payment;
/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property string $invoice_no
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $branch_id
 * @property string $date_issue
 * @property double $grand_total
 * @property string $remarks
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $delete
 * @property integer $task
 * @property integer $paid
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_no', 'date_issue', 'grand_total', 'gst', 'net'], 'required', 'message' => 'Fill up the required fields.'],
            [['branch_id', 'customer_id', 'user_id'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'Invalid option selected'],
            [['user_id', 'customer_id', 'branch_id', 'created_by', 'updated_by', 'delete', 'task', 'paid'], 'integer'],
            [['date_issue', 'created_at', 'updated_at'], 'safe'],
            [['remarks'], 'string'],
            [['invoice_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_no' => 'Invoice No',
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
            'task' => 'Task',
            'paid' => 'Paid',
        ];
    }

    

    public static function getCustomer(){
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
    // get part info
    public static function getPartInfo($ItemId) {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.product_id', 'product.product_name'])
        ->from('inventory')
        ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
        ->where(['inventory.id' => $ItemId])
        ->one();

        return $result;

    }

    public static function saveInvoice($postData){

        $invoice = $postData['Invoice'];

        $inv = new Invoice();
        $inv->come_in = $invoice['come_in'];
        $inv->come_out = $invoice['come_out'];
        $inv->remarks = $invoice['remarks'];

        if(trim($invoice['come_in'])=='--/--/---- --:--:--')
            $inv->come_in = '0000-00-00 00:00:00';
        else 
            $inv->come_in = date('Y-m-d H:i:s', strtotime($inv->come_in));

        if(trim($invoice['come_out'])=='--/--/---- --:--:--')
            $inv->come_out = '0000-00-00 00:00:00';
        else
            $inv->come_out = date('Y-m-d H:i:s', strtotime($inv->come_out));


        if($invoice['remarks'] = "")
            $inv->remarks = "No remarks.";

        $inv->quotation_code = 0;
        $inv->invoice_no = $invoice['invoice_no'];
        $inv->branch_id = $invoice['branch_id'];
        $inv->customer_id = $invoice['customer_id'];
        $inv->user_id = $invoice['user_id'];
        $inv->date_issue = date('Y-m-d', strtotime($invoice['date_issue']));
        $inv->gst = $invoice['gst'];
        $inv->net = $invoice['net'];
        $inv->grand_total = $invoice['grand_total'];
        $inv->mileage = $invoice['mileage'];
        
        $inv->created_at = date('Y-m-d').' 00:00:00';
        $inv->time_created = date("H:i:s");
        $inv->created_by = Yii::$app->user->identity->id;
        $inv->invoice_no = Invoice::generateInvoiceNo();
        $inv->task = 0;
        $inv->paid = 0;
        $inv->status = $postData['points_redeem']!=0 && $postData['points_redeem']!='' ? 1 : 0;
        $inv->paid_type = 0;
        $inv->payment_status = 'Unpaid';
        $inv->balance_amount = $invoice['net'];
        $inv->discount_amount = '0.00';
        $inv->discount_remarks = "";

        $inv->save();
        // var_dump($inv->getErrors());
        // exit;
        // QuotationDiscount::saveQuotationDiscount($quo->id, $postData);
        Payment::saveRedeemPoint($inv->id, $postData['points_redeem'], $postData['redeem_description']);
        InvoiceDetail::saveInvoiceDetail($inv->id, $postData);
        return $inv->id;
    }

    public static function updateInvoice($invoice_id, $postData){
        $invoice = $postData['Invoice'];

        $inv = Invoice::findOne($invoice_id);
        $inv->come_in = $invoice['come_in'];
        $inv->come_out = $invoice['come_out'];
        $inv->remarks = $invoice['remarks'];

        if(trim($invoice['come_in'])=='--/--/---- --:--:--')
            $inv->come_in = '0000-00-00 00:00:00';
        else 
            $inv->come_in = date('Y-m-d H:i:s', strtotime($inv->come_in));

        if(trim($invoice['come_out'])=='--/--/---- --:--:--')
            $inv->come_out = '0000-00-00 00:00:00';
        else
            $inv->come_out = date('Y-m-d H:i:s', strtotime($inv->come_out));

        if($invoice['remarks'] = "")
            $inv->remarks = "No remarks.";

        $inv->branch_id = $invoice['branch_id'];
        $inv->customer_id = $invoice['customer_id'];
        $inv->user_id = $invoice['user_id'];
        $inv->date_issue = date('Y-m-d', strtotime($invoice['date_issue']));
        $inv->gst = $invoice['gst'];
        $inv->net = $invoice['net'];
        $inv->grand_total = $invoice['grand_total'];
        $inv->mileage = $invoice['mileage'];
        
        $inv->updated_at = date('Y-m-d').' 00:00:00';
        $inv->updated_by = Yii::$app->user->identity->id;
        $inv->balance_amount = $invoice['net'];
        $inv->discount_amount = '0.00';
        $inv->discount_remarks = "";
        $inv->save();

        Payment::updateRedeemPoint($inv->id, $postData['points_redeem'], $postData['redeem_description']);
        InvoiceDetail::updateInvoiceDetail($inv->id, $postData);
    }

    public static function generateInvoiceNo(){
        $searchModel = new SearchInvoice();
        $invoiceId = $searchModel->getInvoiceId();
        $yrNow = date('Y');
        $monthNow = date('m');
        $invoiceCode = 'INV' . $yrNow  . $monthNow . sprintf('%003d', $invoiceId);

        return $invoiceCode;
    }

    public static function getInvoiceById($id=null)
    {
        $Invoice = Invoice::find()->where(['id' => $id])->one();
        return $Invoice;
    }

    public static function getInvoiceInformation($invoice_id){

        $rows = new Query();

        $result = $rows->select('i.*, c.type as customer_type, c.address as customer_address,c.fullname,c.company_name,c.hanphone_no, c.office_no, c.fax_number, b.id as branch_id, b.name as branch_name, b.address as branch_address, b.contact_no as branch_contact, b.fax as branch_fax, b.email as branch_email,b.uen_no,b.gst_no, ci.points, ci.carplate, ci.make, ci.model')
        ->from('invoice i')
        ->leftJoin('branch b', 'i.branch_id=b.id')
        ->leftJoin('car_information ci', 'ci.id=i.customer_id')
        ->leftJoin('customer c', 'c.id=ci.customer_id')
        ->where(['i.id' => $invoice_id])
        ->one();

        return $result;

    }
    
    public static function exportInvoicesByCustomerId($customer_id){
        $rows = new Query();

        $result = $rows->select('i.invoice_no, br.name as branch_name, ci.carplate, i.date_issue, u.username, (case when c.fullname IS NULL || c.fullname="" THEN c.company_name ELSE c.fullname END) as name, c.company_name, i.net, i.gst, (case when p.product_name is null || p.product_name="" THEN id.service_part_id ELSE p.product_name END)as item, id.quantity, id.selling_price, id.subTotal')
        ->from('invoice i')
        ->innerjoin('invoice_detail id', 'i.id=id.invoice_id')
        ->innerjoin('car_information ci', 'ci.id=i.customer_id')
        ->innerjoin('customer c', 'c.id=ci.customer_id')
        ->innerjoin('product p', 'p.id=id.service_part_id')
        ->innerjoin('branch br', 'br.id=i.branch_id')
        ->innerjoin('user u', 'u.id=i.user_id')
        ->where(['i.delete' => 0, 'c.id' => $customer_id])
        ->orderby('i.id desc')
        ->orderby('id.id asc')
        ->all();

        // echo "<pre>";
        // var_dump($result);
        // exit;

        return $result;
    }

}
