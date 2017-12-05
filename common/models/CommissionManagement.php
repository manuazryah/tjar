<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "commission_management".
 *
 * @property int $id
 * @property int $product_id
 * @property int $vendor_id
 * @property string $order_id
 * @property string $product_price
 * @property string $offer_price
 * @property string $commission
 * @property int $status
 * @property string $DOC
 * @property string $DOU
 */
class CommissionManagement extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'commission_management';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['product_id', 'vendor_id', 'status'], 'integer'],
            [['product_price', 'offer_price', 'commission'], 'number'],
            [['DOC', 'DOU', 'order_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'product_id' => 'Product',
            'vendor_id' => 'Vendor',
            'order_id' => 'Order ID',
            'product_price' => 'Product Price',
            'offer_price' => 'Offer Price',
            'commission' => 'Commission',
            'status' => 'Status',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
