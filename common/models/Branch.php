<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "branch".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $address
 * @property string $contact_no
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'address', 'contact_no'], 'required', 'message' => 'Fill-up required fields.'],
            [['contact_no','fax'], 'integer'],
            [['email'], 'email'],
            // [['name'], 'unique', 'message' => 'Branch name already exist.'],
            [['created_at','updated_at','created_by','updated_by','status','uen_no','gst_no'], 'safe'],
            [['code', 'name', 'contact_no'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'address' => 'Address',
            'contact_no' => 'Contact No',
            'fax' => 'Fax',
            'email' => 'Email',
            'uen_no' => 'UEN No',
            'gst_no' => 'GST No',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function dataBranch($id=null) {
        return ArrayHelper::map(Branch::find()->where(['status' => 1])->all(), 'id', 'name');
    }

    public static function getBranchWithKeyId(){
        $branch = Branch::find()->where(['status' => 1])->all();

         $query = new Query;
            $query  ->select('b.*,g.gst') 
                    ->from('branch b')
                    ->leftjoin('gst g', 'b.id=g.branch_id')
                    ->where(['b.status' => 1]);

        $command = $query->createCommand()->queryAll();
        // echo "<pre>";
        // var_dump($command);exit;
        foreach($command as $key=>$value){
            $data[$value['id']] = $value;
        }
        return $data;
    }

}
