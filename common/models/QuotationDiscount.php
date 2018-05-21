<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quotation_detail".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property integer $service_part_id
 * @property integer $quantity
 * @property double $selling_price
 * @property double $subTotal
 * @property string $created_at
 * @property integer $created_by
 * @property integer $type
 */
class QuotationDiscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_discount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_id', 'remark', 'amount'], 'required'],
            [['quotation_id', 'created_by'], 'integer'],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Quotation ID',
            'remark' => 'Remark',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'delete' => 'Delete',
        ];
    }

    public static function saveQuotationDiscount($quotation_id, $postData){

        $items = $postData['items'];

        foreach($items as $item)
        {
            $tmp = explode("``", $item);

            if($tmp[1]!='Discount')
                continue;

            $quotationDiscount = new QuotationDiscount();
            $quotationDiscount->quotation_id = $quotation_id;
            $quotationDiscount->remark = $tmp[0];
            $quotationDiscount->amount = $tmp[3];
            $quotationDiscount->created_at = date('Y-m-d H:i:s');
            $quotationDiscount->created_by = Yii::$app->user->identity->id;
            $quotationDiscount->save();
        }
    }

    public static function getQuotationDiscountByID($quotation_id){
        $quotationDiscount = QuotationDiscount::find()->where(['quotation_id' => $quotation_id])->all();
        return $quotationDiscount;
    }
}

// insert into quotation_detail(quotation_id, service_part_id, quantity, selling_price, subTotal, created_at, created_by, type, task, invoice)
// select id, discount_remarks, '1' as quantity, concat('-',discount_amount), concat('-',discount_amount), created_at, created_by, '2' as type, '0' as task, invoice from quotation where discount_amount!='0.00'