<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_master".
 *
 * @property int $id
 * @property string $order_id
 * @property int $user_id
 * @property string $total_amount
 * @property int $promotion_id
 * @property string $promotion_discount
 * @property string $discount_amount
 * @property string $net_amount
 * @property string $order_date
 * @property int $ship_address_id
 * @property int $bill_address_id
 * @property string $user_comment
 * @property string $admin_comment
 * @property int $payment_status
 * @property int $admin_status
 * @property int $shipping_status
 * @property int $status
 * @property string $DOC
 * @property string $DOU
 */
class OrderMaster extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'order_master';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['order_id', 'user_id', 'total_amount', 'net_amount'], 'required'],
            [['user_id', 'promotion_id', 'ship_address_id', 'bill_address_id', 'payment_status', 'admin_status', 'shipping_status', 'status'], 'integer'],
            [['total_amount', 'promotion_discount', 'discount_amount', 'net_amount'], 'number'],
            [['order_date', 'DOC', 'DOU'], 'safe'],
            [['user_comment', 'admin_comment'], 'string'],
            [['order_id'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'user_id' => 'User',
            'total_amount' => 'Total Amount',
            'promotion_id' => 'Promotion',
            'promotion_discount' => 'Promotion Discount',
            'discount_amount' => 'Discount Amount',
            'net_amount' => 'Net Amount',
            'order_date' => 'Order Date',
            'ship_address_id' => 'Ship Address',
            'bill_address_id' => 'Bill Address',
            'user_comment' => 'User Comment',
            'admin_comment' => 'Admin Comment',
            'payment_status' => 'Payment Status',
            'admin_status' => 'Admin Status',
            'shipping_status' => 'Shipping Status',
            'status' => 'Status',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    public static function getTotal($from_date, $to, $field_name) {
        if ($from_date != '' && $to != '') {
            $from_date = $from_date . ' 00:00:00';
            $to = $to . ' 60:60:60';
            return OrderMaster::find()->where(['>=', 'order_date', $from_date])->andWhere(['<=', 'order_date', $to])->sum($field_name);
        } elseif ($from_date != '' || $to != '') {
            return 0;
        } else {
            return OrderMaster::find()->sum($field_name);
        }
    }

}
