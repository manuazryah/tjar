<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_history".
 *
 * @property int $id
 * @property int $products_id
 * @property int $user_id
 * @property int $productvendor_id
 * @property int $usertype 1=Admin,2=Vendor,3=Customer
 * @property int $qty
 * @property int $total_stock
 * @property int $purpose 1=Stock Added,2=Stock Changed,3=Stock Saled,4=Stock Returned
 * @property string $DOC
 */
class StockHistory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'stock_history';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['products_id', 'productvendor_id', 'usertype', 'qty'], 'required'],
            [['products_id', 'user_id', 'productvendor_id', 'usertype', 'qty', 'total_stock', 'purpose'], 'integer'],
            [['DOC'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'products_id' => 'Products ID',
            'user_id' => 'User ID',
            'productvendor_id' => 'Product',
            'usertype' => 'Usertype',
            'qty' => 'Qty',
            'total_stock' => 'Total Stock',
            'purpose' => 'Purpose',
            'DOC' => 'Date',
        ];
    }

    public static function stockhistory($qty, $purpose, $prdct_vendor, $user_type, $old_qty) {//qty,purpose,product_vendor_id,usertype
        $model = new StockHistory();
        $product_vendor = ProductVendor::findone($prdct_vendor);
        $model->products_id = $product_vendor->product_id;
        $model->user_id = Yii::$app->user->identity->id;
        $model->productvendor_id = $prdct_vendor;
        $model->usertype = $user_type;
        $model->qty = StockHistory::qty($purpose, $qty, $prdct_vendor, $old_qty);
        $model->total_stock = $qty;
        $model->purpose = $purpose;
        $model->DOC = date('Y-m-d H:i:s');
        if ($model->save()) {
            
        } else {
//            var_dump($model->getErrors());
//            exit;
        }
    }

    public function qty($purpose, $qty, $prdct_vendor, $old_qty) {
        if ($purpose == "1") {
            return $qty;
        }
        if ($purpose == "2" || $purpose == "3") {
            $qnty = $qty - $old_qty;
            return $qnty;
        }
    }

}
