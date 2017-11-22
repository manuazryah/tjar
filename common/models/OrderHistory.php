<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_history".
 *
 * @property int $id
 * @property int $detail_id
 * @property string $order_id
 * @property int $product_id
 * @property int $status
 * @property string $date
 * @property string $comment
 */
class OrderHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
       return [
            [['detail_id', 'order_id', 'product_id'], 'required'],
            [['detail_id', 'product_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['comment'], 'string'],
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
            'detail_id' => 'Detail ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'status' => 'Status',
            'date' => 'Date',
            'comment' => 'Comment',
        ];
    }
    
}
