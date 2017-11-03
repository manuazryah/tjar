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
class OrderDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['master_id', 'order_id', 'product_id', 'quantity', 'amount', 'sub_total'], 'required'],
            [['master_id', 'product_id', 'quantity', 'status'], 'integer'],
            [['amount', 'sub_total'], 'number'],
            [['delivered_date', 'DOC'], 'safe'],
            [['order_id'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'amount' => 'Amount',
            'sub_total' => 'Sub Total',
            'delivered_date' => 'Delivered Date',
            'status' => 'Status',
            'DOC' => 'Doc',
        ];
    }
}
