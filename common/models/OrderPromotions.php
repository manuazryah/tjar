<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_promotions".
 *
 * @property int $id
 * @property int $order_master_id
 * @property int $promotion_id
 * @property string $promotion_discount
 *
 * @property OrderMaster $orderMaster
 * @property Promotions $promotion
 */
class OrderPromotions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_promotions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_master_id', 'promotion_id'], 'integer'],
            [['promotion_discount'], 'number'],
            [['order_master_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderMaster::className(), 'targetAttribute' => ['order_master_id' => 'id']],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promotions::className(), 'targetAttribute' => ['promotion_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_master_id' => 'Order Master ID',
            'promotion_id' => 'Promotion ID',
            'promotion_discount' => 'Promotion Discount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderMaster()
    {
        return $this->hasOne(OrderMaster::className(), ['id' => 'order_master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotion()
    {
        return $this->hasOne(Promotions::className(), ['id' => 'promotion_id']);
    }
}
