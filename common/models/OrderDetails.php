<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_details".
 *
 * @property int $id
 * @property int $master_id
 * @property string $order_id
 * @property int $product_id
 * @property int $quantity
 * @property string $amount
 * @property string $sub_total
 * @property string $delivered_date
 * @property int $status
 * @property string $DOC
 */
class OrderDetails extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'order_details';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['master_id', 'order_id', 'product_id', 'quantity', 'amount', 'sub_total', 'user_id'], 'required'],
            [['master_id', 'product_id', 'quantity', 'status', 'vendor_id', 'payment_status', 'admin_status'], 'integer'],
            [['amount', 'sub_total'], 'number'],
            [['delivered_date', 'DOC'], 'safe'],
            [['order_id'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'order_id' => 'Order ID',
            'user_id' => 'User',
            'product_id' => 'Product Name',
            'quantity' => 'Quantity',
            'amount' => 'Amount',
            'sub_total' => 'Sub Total',
            'delivered_date' => 'Delivered Date',
            'status' => 'Status',
            'payment_status' => 'Payment Status',
            'admin_status' => 'Admin  Status',
            'DOC' => 'Doc',
        ];
    }

    public static function getTotal($item_data) {
        $tot = 0;
        foreach ($item_data as $val) {
            $tot += $val->amount;
        }
        return $tot;
    }

    public static function getTotalAmount($from_date, $to, $product_id, $field_name) {
        if ($from_date != '' && $to != '') {
            echo $product_id;
            echo $field_name;
            exit;
            $from_date = $from_date;
            $to = $to;
            if ($product_id != '') {
                return OrderDetails::find()->where(['>=', 'DOC', $from_date])->andWhere(['<=', 'DOC', $to])->andWhere(['product_id' => $product_id])->sum($field_name);
            } else {
                return OrderDetails::find()->where(['>=', 'DOC', $from_date])->andWhere(['<=', 'DOC', $to])->sum($field_name);
            }
        } elseif ($from_date != '' && $to == '') {
            if ($product_id != '') {
                return OrderDetails::find()->where(['>=', 'DOC', $from_date])->andWhere(['product_id' => $product_id])->sum($field_name);
            } else {
                return OrderDetails::find()->where(['>=', 'DOC', $from_date])->sum($field_name);
            }
        } elseif ($from_date == '' && $to != '') {
            if ($product_id != '') {
                return OrderDetails::find()->where(['<=', 'DOC', $to])->andWhere(['product_id' => $product_id])->sum($field_name);
            } else {
                return OrderDetails::find()->where(['<=', 'DOC', $to])->sum($field_name);
            }
        } else {
            if ($product_id != '') {
                return OrderDetails::find()->where(['product_id' => $product_id])->sum($field_name);
            } else {
                return OrderDetails::find()->sum($field_name);
            }
        }
    }

    public static function getSalecount($from_date, $to, $product_id) {
        if ($from_date != '' && $to != '') {
            $from_date = $from_date;
            $to = $to;
            if ($product_id != '') {
                return OrderDetails::find()->where(['>=', 'DOC', $from_date])->andWhere(['<=', 'DOC', $to])->andWhere(['product_id' => $product_id])->count();
            } else {
                return OrderDetails::find()->where(['>=', 'DOC', $from_date])->andWhere(['<=', 'DOC', $to])->count();
            }
        } elseif ($from_date != '' && $to == '') {
            if ($product_id != '') {
                return OrderDetails::find()->where(['>=', 'DOC', $from_date])->andWhere(['product_id' => $product_id])->count();
            } else {
                return OrderDetails::find()->where(['>=', 'DOC', $from_date])->count();
            }
        } elseif ($from_date == '' && $to != '') {
            if ($product_id != '') {
                return OrderDetails::find()->where(['<=', 'DOC', $to])->andWhere(['product_id' => $product_id])->count();
            } else {
                return OrderDetails::find()->where(['<=', 'DOC', $to])->count();
            }
        } else {
            if ($product_id != '') {
                return OrderDetails::find()->where(['product_id' => $product_id])->count();
            } else {
                return OrderDetails::find()->count();
            }
        }
    }

    public function getProduct() {
        return $this->hasOne(ProductVendor::className(), ['id' => 'product_id']);
    }

    public function getvendor() {
        return $this->hasOne(Vendors::className(), ['id' => 'vendor_id']);
    }

    /*     * *****************Commission for order details products******************* */

    public static function commission($orderdetails) {
        $commission = '0';
        foreach ($orderdetails as $orderdtl) {
            $prdctvendor = ProductVendor::findone($orderdtl->product_id);
            $product = Products::findone($prdctvendor->product_id);
            if (isset($prdctvendor->offer_price) && $prdctvendor->offer_price != "0") {
                $price = $prdctvendor->offer_price;
            } else {
                $price = $prdctvendor->price;
            }
            $commision_price = ($price * $product->commisson) / 100;
            $commission = $commission + $commision_price;
        }
        return $commission;
    }

    /*     * *****************Commission for products******************* */

    public static function commission_product($orderdtl) {
        $commission = '0';
        $prdctvendor = ProductVendor::findone($orderdtl->product_id);
        $product = Products::findone($prdctvendor->product_id);
        if (isset($prdctvendor->offer_price) && $prdctvendor->offer_price != "0") {
            $price = $prdctvendor->offer_price;
        } else {
            $price = $prdctvendor->price;
        }
        $commision_price = ($price * $product->commisson) / 100;
        $commission = $commission + $commision_price;
        return $commission;
    }

}
